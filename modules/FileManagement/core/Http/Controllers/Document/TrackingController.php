<?php

namespace Modules\FileManagement\core\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Models\Document\Track;
use Modules\FileManagement\core\Models\Document\Series;

class TrackingController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->has('qrcode')) {

            $id       = series($request->get('qrcode'));
            $document = Series::with('attachments', 'encoder', 'liaison', 'office')->find($id);

            // checking if the qr code match
            if (!$document || $document->qr != $request->get('qrcode')) {
                return redirect(route('fms.document.track'))->with('alert-error', 'Document not found.');
            }

            require module_path('FileManagement', 'core/Includes/SwitchDocument.php');

            $tracks = Track::with('liaison', 'clerk', 'office')->where('series_id', $id)->orderBy('id', 'DESC')->get();

            // tracker
            // activitylog('document', 'Track document', ['qrcode' => $request->get('qrcode')]);

            return view('fms::document.track.track', [
                'document' => $document,
                'rel'      => $rel,
                'datas'    => $datas,
                'tracks'   => $tracks,
            ]);

        }

        return view('fms::document.track.index');
    }
}
