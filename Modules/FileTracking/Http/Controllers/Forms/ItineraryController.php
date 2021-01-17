<?php

namespace Modules\FileTracking\Http\Controllers\Forms;

use Illuminate\Routing\Controller;
use Modules\FileTracking\Entities\FTS_QR;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\Office\SYS_Division;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Http\Requests\Itinerary\StoreRequest;
use Modules\FileTracking\Transformers\ItineraryDTResource;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\FileTracking\Http\Requests\Itinerary\UpdateRequest;

class ItineraryController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $model = FTS_Itinerary::with('document')->get();
            $datas = ItineraryDTResource::collection($model);
            return response()->json($datas);
        }
        return view('filetracking::forms.itinerary.index');
    }

    public function create()
    {
        $qrs = FTS_QR::available();
        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.itinerary.create', [
            'qrs' => $qrs,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function store(StoreRequest $request)
    {
        $series = fts_series($request->post('series'));

        $document = FTS_Document::create([
            'series' => $series,
            'division_id' => $request->post('division'),
            'liaison_id' =>  $request->post('liaison'),
            'encoder_id' => authenticated()->employee_id,
            'type' => config('constants.document.type.travel.itinerary')
        ]);

        
        // changing QR status
        $qr = FTS_Qr::used($series);

        $iot = FTS_Itinerary::create([
            'document_id' => $document->id,
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'destination' => $request->post('destination'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
        ]);

        // INSERTING INTO TRACKING LOGS
        FTS_Tracking::create([
            'document_id' => $document->id,
            'division_id' => authenticated()->employee->division_id,
            'user_id' => authenticated()->employee_id,
            'liaison_id' => $request->post('liaison'),
            'action' => config('constants.document.action.release'),
            'purpose' => 'DOCUMENT ENCODED BY: '.strtoupper(name_helper(authenticated()->employee->name)),
            'status' => config('constants.document.status.process.id')
        ]);

        // saving the activity logs
        activitylog([
            'name' => 'fts',
            'log' => 'Tried to store Itinerary.'
        ]);

        return response()->json([
            'message' => 'Itinerary has been encoded.',
            'receipt' => route('fts.documents.receipt', [
                'series' => $series,
                'print' => true
            ])
        ]);
    }

    public function edit($id)
    {
        $iot = FTS_Itinerary::with('document')->findOrFail($id);

        $divisions = SYS_Division::lists();
        $liaisons = HR_Employee::liaison()->get();

        return view('filetracking::forms.itinerary.edit', [
            'iot' => $iot,
            'divisions' => $divisions,
            'liaisons' => $liaisons
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $iot = FTS_Itinerary::with('document')->findOrFail($id);

        $iot->update([
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'destination' => $request->post('destination'),
            'amount' => $request->post('amount'),
            'particulars' => $request->post('particulars')
        ]);

        $iot->document()->update([
            'division_id' => $request->post('division'),
            'liaison_id' => $request->post('liaison')
        ]);

        return response()->json([
            'message' => 'Itinerary has been updated.',
            'route' => route('fts.travel.itinerary.index')
        ]);
    }
}
