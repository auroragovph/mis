<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Cafoa;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Cafoa\FMS_Cafoa;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Http\Requests\Forms\Cafoa\CafoaStoreRequest;
use Modules\FileManagement\Transformers\Forms\Cafoa\CafoaDTResource;

class CafoaController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){

            $model = FMS_Cafoa::with('document')->whereHas('document', function($q){
                $q->where('division_id', auth_division());
            })->get();

            $datas = CafoaDTResource::collection($model);
            return response()->json($datas);
        }

        return view('filemanagement::forms.cafoa.index');
    }

    public function create()
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        return view('filemanagement::forms.cafoa.create', [
            'employees' => $employees
        ]);
    }

    public function edit($id)
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();

        $cafoa = FMS_Cafoa::with(
                'document',
                'requesting',
                'budget',
                'accounting',
                'treasury'
            )
        ->findOrFail($id);

        return view('filemanagement::forms.cafoa.edit', [
            'employees' => $employees,
            'cafoa' => $cafoa
        ]);
    }

    public function store(CafoaStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::directStore($request->post('liaison'), config('constants.document.type.cafoa'));

        $lists = [];
        foreach($request->post('lists') as $i => $list){
            $lists[$i] = json_decode($list, true);
        }

        $cafoa = FMS_Cafoa::create([
            'payee' => $request->post('payee'),
            'document_id' => $document->id,
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'budget_id' => $request->post('budget'),
            'accountant_id' => $request->post('accountant'),
            'requesting_id' => $request->post('requesting'),
            'lists' => $lists
        ]);

         // setting session
         session()->flash('alert-success', 'Cafoa has been encoded.');

         return response()->json([
             'message' => "CAFOA has been encoded.",
             'route' => route('fms.cafoa.show', $cafoa->id)
         ]);

        
    }

    public function show($id)
    {
        $cafoa = FMS_Cafoa::with(
                                'document.attachments',
                                'document.liaison',
                                'document.encoder',
                                'document.division.office',
                                'requesting',
                                'budget',
                                'accounting',
                                'treasury'
                        )
                    ->findOrFail($id);

        return view('filemanagement::forms.cafoa.show', compact('cafoa'));
    }

    public function update(CafoaStoreRequest $request, $id)
    {
        $cafoa = FMS_Cafoa::with('document')->findOrFail($id);

        $lists = [];
        foreach($request->post('lists') as $i => $list){
            $lists[$i] = json_decode($list, true);
        }

        $cafoa->update([
            'payee' => $request->post('payee'),
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'budget_id' => $request->post('budget'),
            'accountant_id' => $request->post('accountant'),
            'requesting_id' => $request->post('requesting'),
            'lists' => $lists
        ]);


        $cafoa->document()->update([
            'liaison_id' => $request->post('liaison')
        ]);

         // setting session
         session()->flash('alert-success', 'Cafoa has been updated.');

         return response()->json([
             'message' => "CAFOA has been updated.",
             'route' => route('fms.cafoa.show', $cafoa->id)
         ]);

    }
}
