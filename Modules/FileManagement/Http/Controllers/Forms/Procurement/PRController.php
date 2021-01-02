<?php

namespace Modules\FileManagement\Http\Controllers\Forms\Procurement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Modules\FileManagement\Entities\Procurement\FMS_PR;
use Modules\FileManagement\Http\Requests\Forms\Procurement\Request\PRStoreRequest;
use Modules\FileManagement\Transformers\Forms\Procurement\Request\RequestDTResource;

class PRController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $model = FMS_PR::with('document.division.office')->whereHas('document', function($q){
                $q->where('division_id', auth_division());
            })->get();

            $datas = RequestDTResource::collection($model);
            return response()->json($datas);
        }

        return view('filemanagement::forms.procurement.request.index');
    }

    public function create()
    {
        $employees = HR_Employee::whereIn('division_id', [
            auth()->user()->employee->division_id,
            config('constants.office.ACCOUNTING'),
            config('constants.office.PTO'),
            config('constants.office.BUDGET'),
        ])->get();
        
        return view('filemanagement::forms.procurement.request.create', [
            'employees' => $employees
        ]);
    }

    public function store(PRStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::directStore($request->post('liaison'), config('constants.document.type.procurement.request'));

        $lists = [];
        foreach($request->post('lists') as $i => $list){
            $lists[$i] = json_decode($list, true);
        }

        $pr = FMS_PR::create([
            'document_id' => $document->id,
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'lists' => $lists
        ]);

        // setting session
        session()->flash('alert-success', 'Purchase request has been encoded.');

        return response()->json([
            'message' => "Purchase request has been encoded.",
            'route' => route('fms.procurement.request.show', $pr->id)
        ]);

    }

    public function show($id)
    {
        $pr = FMS_PR::with(

                    'document.attachments',
                    'document.liaison',
                    'document.encoder',
                    'document.division.office',

                    'requesting',
                    'treasury',
                    'approval'
                    )->findOrFail($id);

        return view('filemanagement::forms.procurement.request.show', [
            'pr' => $pr
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

        $pr = FMS_PR::with('document')->findOrFail($id);
        
        return view('filemanagement::forms.procurement.request.edit', [
            'employees' => $employees,
            'pr' => $pr
        ]);
    }

    public function update(PRStoreRequest $request, $id)
    {
        $pr = FMS_PR::with('document')->findOrFail($id);

        $lists = [];
        foreach($request->post('lists') as $i => $list){
            $lists[$i] = json_decode($list, true);
        }

        $pr->update([
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'number' => $request->post('number'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'lists' => $lists
        ]);

        // setting session
        session()->flash('alert-success', 'Purchase request has been updated.');

        return response()->json([
            'message' => "Purchase request has been updated.",
            'route' => route('fms.procurement.request.show', $pr->id)
        ]);

    }
}
