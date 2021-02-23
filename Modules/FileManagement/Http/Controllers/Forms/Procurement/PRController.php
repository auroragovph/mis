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
    public function __construct()
    {
        // middlewares
        // $this->middleware('fms.document.check', ['only' => ['show', 'edit', 'update', 'print']]);
        $this->middleware(['permission:fms.document.create'], ['only' => ['create', 'store']]);
        // $this->middleware(['permission:fms.document.edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['only.ajax'], ['only' => ['store', 'update']]);
    }

    public function index(Request $request)
    {
        if($request->ajax()){

            $model = FMS_PR::with('document.division.office')->whereHas('document', function($q){
                $q->where('division_id', auth_division());
            })->get();

            $datas = RequestDTResource::collection($model);
            return response()->json($datas);
        }

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request purchase request list.']);

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

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Request new purchase request form.']);
        
        return view('filemanagement::forms.procurement.request.create', [
            'employees' => $employees
        ]);
    }

    public function store(PRStoreRequest $request)
    {
        // storing document
        $document = FMS_Document::directStore($request->post('liaison'), config('constants.document.type.procurement.request'));

        $pr = FMS_PR::create([
            'document_id' => $document->id,
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'lists' => $request->post('lists')
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Encode cafoa', 
            'props' => [
                'model' => [
                    'id' => $pr->id,
                    'class' => FMS_PR::class
                ]
            ]
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
                    'document.purchase_order',

                    'requesting',
                    'treasury',
                    'approval'
                )->findOrFail($id);
        

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information of purchase request', 
            'props' => [
                'model' => [
                    'id' => $pr->id,
                    'class' => FMS_PR::class
                ]
            ]
        ]);

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

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Edit purchase request.', 'props' => [
           'edit' => ['model' => FMS_PR::class,'id' => $pr->id]
        ]]);
        
        return view('filemanagement::forms.procurement.request.edit', [
            'employees' => $employees,
            'pr' => $pr
        ]);
    }

    public function update(PRStoreRequest $request, $id)
    {
        $pr = FMS_PR::with('document')->findOrFail($id);

        $pr->update([
            'requesting_id' => $request->post('requesting'),
            'treasury_id' => $request->post('treasury'),
            'approving_id' => $request->post('approving'),
            'number' => $request->post('number'),
            'fund' => $request->post('fund'),
            'fpp' => $request->post('fpp'),
            'purpose' => $request->post('purpose'),
            'lists' => $request->post('lists')
        ]);

        // setting session
        session()->flash('alert-success', 'Purchase request has been updated.');

        // activity loger
        activitylog(['name' => 'fms', 'log' => 'Update purchase request.', 'props' => [
            'edit' => ['model' => FMS_PR::class,'id' => $pr->id]
        ]]);

        return response()->json([
            'message' => "Purchase request has been updated.",
            'route' => route('fms.procurement.request.show', $pr->id)
        ]);

    }

    public function print($id)
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


        $lists = collect($pr->lists);

        $total_amount = $lists->sum(function($amount){
            return $amount['quantity'] * $amount['amount'];
        });

        $pages = array();
        $consumed_row = 0;
        $pager = 0;

        foreach($lists as $index => $list){

            $new_line = substr_count($list['description'], "\r\n");

            // count first the description of the list
            $count = strlen($list['description']);

            
            $list_consumed = ($new_line == 0) ? ceil($count / 40) : $new_line + 1;

            $consumed_row += $list_consumed;

            $list['consumed_row'] = $list_consumed;

            if($consumed_row >= 30){
                $consumed_row = 0;
                $pager++;
            }else{

                $pages[$pager][] = $list;

                if($index + 1 == $lists->count()){
                    // this is the last iteration
                    for($consumed_row; $consumed_row <= 29; $consumed_row++){
                        
                       $blank['stock'] = '';
                       $blank['unit'] = '';
                       $blank['description'] = '&nbsp';
                       $blank['quantity'] = null;
                       $blank['amount'] = null;
   
                       $pages[$pager][] = $blank;
                   }
               }
            }

           
        }

        

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information for print of purchase request', 
            'props' => [
                'model' => [
                    'id' => $pr->id,
                    'class' => FMS_PR::class
                ]
            ]
        ]);

        return view('filemanagement::forms.procurement.request.print', [
            'pr' => $pr,
            'pages' => $pages,
            'total_amount' => $total_amount
        ]);
    }
}
