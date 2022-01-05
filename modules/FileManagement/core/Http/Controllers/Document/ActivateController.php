<?php

namespace Modules\FileManagement\core\Http\Controllers\Document;

use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Models\Document\Track;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\FileManagement\core\Enums\Document\Track as TrackEnum;
use Modules\FileManagement\core\Http\Requests\Document\ActivateRequest;

class ActivateController extends Controller
{
    public function index()
    {
        return view('fms::document.activate');
    }

    public function submit(ActivateRequest $request)
    {
        $id       = series($request->document);
        $document = Series::find($id);

        if ($document === null || $request->document !== $document->qr) {
            return response([
              'message' => 'Document not found.'
            ], 404);
        }

        if ($document->status === Status::CANCELLED->value) {

            $response['message'] = 'Document has been cancelled. All further transactions to this document is invalid.';
            activitylog('document', 'Submit activation for ID: ' . $id . ' but failed. Reason: ' . $response['message'], ['qrcode' => $request->document]);
            return response([
              'message' => $response['message']
            ], 419);
        }

        if ($document->status !== Status::ACTIVATION->value) {

            $response['message'] = 'Document already activated.';
            activitylog('document', 'Submit activation for ID: ' . $id . ' but failed. Reason: ' . $response['message'], ['qrcode' => $request->document]);
            return response([
              'message' => $response['message']
            ], 419);
        }

        // checking liaison
        $liaison = Employee::find_liaison($request->liaison);

        if ($liaison === null) {
            $response['message'] = 'Liaison not found.';
            activitylog('document', 'Submit activation for ID: ' . $id . ' but failed. Reason: ' . $response['message'], ['qrcode' => $request->document]);
            return response([
              'message' => $response['message']
            ], 419);
        }

        $document->status = Status::ON_PROCESS->value;
        $document->save();

        // save to tracking
        Track::log($id, TrackEnum::RELEASE->value, 'Document Activation', Status::ON_PROCESS->value, (int) $liaison->id);

        // activity loger
        activitylog('document', 'Activate document. QRCODE: ' . $request->document);

        $response['message'] = 'Document activated.';
        return response([
          'message' => $response['message']
        ], 201);
    }
}

