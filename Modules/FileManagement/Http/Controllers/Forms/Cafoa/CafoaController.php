<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Cafoa;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\FileManagement\Entities\Document\FMS_Document;

class CafoaController extends Controller
{
    public function index(Request $request)
    {


        if($request->ajax()){

            $documents = FMS_Document::with('cafoa')
                            ->where('type', 400)
                            ->where('division_id', Auth::user()->employee->division_id)
                            ->get();
            
            $records['data'] = array();

            foreach($documents as $i => $document){
                $records['data'][$i]['id'] = $document->id;
                $records['data'][$i]['qr'] = $document->qr;
                $records['data'][$i]['encoded'] = Carbon::parse($document->created_at)->format('F d, Y h:i A');
                $records['data'][$i]['number'] = $document->cafoa->number;
                $records['data'][$i]['payee'] = $document->cafoa->payee;
                $records['data'][$i]['amount'] = $document->cafoa->lists->sum('amount');
                $records['data'][$i]['status'] = show_status($document->status);
                $records['data'][$i]['action'] = hrefroute($document->id, 'fms.cafoa.show');
            }

            return response()->json($records, 200);

           
        }
        return view('filemanagement::forms.cafoa.index');
    }

    public function create()
    {
        $employees = HR_Employee::get();
        $divisions = SYS_Division::with('office')->get();

        // dd($employees);
        // die;

        return view('filemanagement::forms.cafoa.create', [
            'employees' => $employees,
            'divisions' => $divisions
        ]);

    }

    public function store(Request $request)
    {

        $document = FMS_Document::directStore($request->liaison, 400);


        $signatories = [
            'budget' => [
                'id' => $request->post('budget'),
                'date' => ''
            ],
            'treasury' => [
                'id' => $request->post('treasury'),
                'date' => ''
            ],
            'accounting' => [
                'id' => $request->post('accounting'),
                'date' => ''
            ],
        ];


        $lists = array();
        foreach($request->post('amount') as $i => $amount){
            $lists[$i]['function'] = $request->func[$i];
            $lists[$i]['allotment'] = $request->ac[$i];
            $lists[$i]['expense'] = $request->ec[$i];
            $lists[$i]['amount'] = $request->amount[$i];
        }


        $cafoa = FMS_Cafoa::create([
            'document_id' => $document->id,
            'payee' => $request->post('payee'),
            'requesting_id' => $request->post('requesting'),
            'signatories' => $signatories,
            'lists' => $lists
        ]);

        return redirect(route('fms.cafoa.show', $document->id))->with('alert-success', 'CAFOA has been created. Please activate your document to start the process.');
    }

    public function show($id)
    {
        $document = FMS_Document::with(
                    'attachments',
                    'cafoa.requesting',
                    'cafoa.budget',
                    'cafoa.treasury',
                    'cafoa.accounting',
                )->findOrFail($id);

        // dd($document);

        return view('filemanagement::forms.cafoa.show', compact('document'));
    }

    public function edit($id)
    {
        $document = FMS_Document::with(
                    'attachments',
                    'cafoa.requesting',
                    'cafoa.budget',
                    'cafoa.treasury',
                    'cafoa.accounting',
                )->findOrFail($id);

        $employees = HR_Employee::get();

        // checking the document type if match
        dm_abort($document->type, 400);

        // setting the session
        session()->pull('FMS.document.edit', 'default');
        session()->push('FMS.document.edit', $document->id);

        // dd($document);

        return view('filemanagement::forms.cafoa.edit', [
            'document' => $document,
            'employees' => $employees
        ]);
    }

    public function update(Request $request, $id)
    {
        // checking if the session and the route parameter match
        $eid = session('FMS.document.edit');
        dm_abort($id, $eid[0]);


        $document = FMS_Document::findOrFail($id);
        $document->liaison_id = $request->post('liaison');
        $document->save();

        $cafoa = FMS_Cafoa::where('document_id', $id)->first();

        if($request->has('number')){
            $cafoa->number = $request->post('number');
        }

        $cafoa->payee = $request->post('payee');
        $cafoa->requesting_id = $request->post('requesting');

        $signatories = [
            'budget' => [
                'id' => $request->post('budget'),
                'date' => ''
            ],
            'treasury' => [
                'id' => $request->post('treasury'),
                'date' => ''
            ],
            'accounting' => [
                'id' => $request->post('accounting'),
                'date' => ''
            ],
        ];


        $lists = array();
        foreach($request->post('amount') as $i => $amount){
            $lists[$i]['function'] = $request->func[$i];
            $lists[$i]['allotment'] = $request->ac[$i];
            $lists[$i]['expense'] = $request->ec[$i];
            $lists[$i]['amount'] = $request->amount[$i];
        }

        $cafoa->signatories = $signatories;
        $cafoa->lists = $lists;
        $cafoa->save();

        return redirect(route('fms.cafoa.show', $id))->with('alert-success', 'CAFOA has been updated.');
    }

    public function print($id)
    {
        return view('filemanagement::forms.cafoa.print');
    }
}
