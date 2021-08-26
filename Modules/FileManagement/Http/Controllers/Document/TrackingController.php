<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Track;

class TrackingController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->has('qrcode')){

            $id = series($request->get('qrcode'));
            $document = Document::with('attachments', 'encoder', 'liaison', 'division.office')->find($id);

            // checking if the qr code match
            if(!$document || $document->qr != $request->get('qrcode')){
                return redirect(route('fms.documents.track'))->with('alert-error', 'Document not found.');
            }
            require base_path()."/Modules/FileManagement/Includes/SwitchDocument.php";

            $tracks = Track::with('liaison', 'clerk', 'division.office')->where('document_id', $id)->orderBy('id', 'DESC')->get();

            // tracker
            actlog('fms', 'Track document', ['qrcode' => $request->get('qrcode')]);

            return view('filemanagement::actions.track.track', [
                'document'      => $document,
                'rel'           => $rel,
                'datas'         => $datas,
                'tracks'        => $tracks
            ]);

        }

        return view('filemanagement::actions.track.index');
    }
}
