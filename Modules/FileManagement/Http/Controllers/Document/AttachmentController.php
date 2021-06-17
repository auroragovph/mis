<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\FileManagement\Entities\Document\Attachment;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Form;
use Modules\FileManagement\Http\Requests\Document\Attachment\CheckRequest;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.attach']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document attach form.']);
        return view('filemanagement::documents.attach.index');
    }

    public function check(CheckRequest $request)
    {

        $id = series($request->post('document'));
        $document = Document::find($id);

        if (!$document or $document->qr !== $request->post('document')) {
            return redirect()
                ->back()
                ->with('alert-error', 'Document not found.');
        }

        switch ($request->post('attachtype')) {

            case 'hardcopy':
                return redirect(route('fms.documents.attach.hardcopy', [
                    'id' => $id,
                    'qr' => $request->post('document'),
                    'checksum' => Str::random(10),
                    'token' => Str::random(30),
                ]));
                break;

            case 'dynamic':
                if ($this->dynamic($request->post('dynamic_ids'), $id) == true) {
                    return redirect()
                        ->back()
                        ->with('alert-success', 'Form has been attached.');
                }

                return redirect()
                    ->back()
                    ->with('alert-success', 'Form attached error.');
                break;

            case 'newform':

                $route = $this->newform($request->post('document_type_new_form'));

                if($route == null){
                    return abort(404);
                }

                return redirect(route($route, [
                    'attachment' => true,
                    'document_id' => $id,
                    'qrcode' => $document->qr,
                    'token' => csrf_token()
                ]));

                break;

            default:
                return redirect()
                    ->back()
                    ->with('alert-error', 'Invalid attachment type.');
                break;

        }

    }

    public function hardcopy()
    {
        $document = Document::findOrfail(request()->get('id'));

        if ($document->qr !== request()->get('qr')) {
            return abort(404);
        }

        return view('filemanagement::documents.attach.hardcopy', [
            'document' => $document,
        ]);
    }

    public function attach(Request $request)
    {
        $id = $request->post("document_id");

        $mime = '';

        if ($request->hasFile('file')) {

            $mime = 'file';

            $file = $request->file('file');
            // $path = Storage::store;
            $path = $file->store('filemanagement/document/attachments');
        }

        $attachment = Attachment::create([
            'document_id' => $id,
            'description' => $request->post('name'),
            'url' => (isset($path)) ? str_replace('filemanagement/document/attachments/', '', $path) : null,
            'mime' => ($mime == '') ? 'text' : 'file',
            'properties' => array(
                'number' => $request->post('number') ?? null,
                'date' => $request->post('date') ?? null,
                'amount' => $request->post('amount') ?? null,
                'page' => $request->post('page') ?? null,
            ),
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Add attachment to the document.',
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => Document::class,
                ],
            ],
        ]);

        return redirect()->back()->with('alert-success', 'Attachment success');

        // return response()->json([
        //     'message' => 'Attachment success'
        // ]);
    }

    public function file($file)
    {
        return response()->file(storage_path('app/filemanagement/document/attachments/' . $file));
    }

    /**
     * Attach existing documents to another document using the formable method of the documents
     * @author Jimwell Pariñas <jp.pagapulan@gmail.com>
     * @param array $qrs
     * @return mixed
     *
     */

    public function dynamic($qrs, $docid)
    {
        // $lists = array_map('series', $qrs);
        // $documents = Document::whereIn('id', $lists)->get();

        $invalids = array();

        foreach ($qrs as $qr) {
            $id = series($qr);
            $document = Document::find($id);

            if (!$document or $document->qr !== $qr) {
                array_push($invalids, $qr);
                continue;
            }

            // get all the attached documents
            $attachments = Form::where('document_id', $id)->get();
            $forms = Form::insert($attachments->map(function ($att) use ($docid) {
                return [
                    'document_id' => $docid,
                    'formable_type' => $att->formable_type,
                    'formable_id' => $att->formable_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray());

        }

        return true;
    }

    public function newform(string $type) : string
    {
        switch ($type) {
            case 'leave':
                $route = 'fms.afl.create';
                break;

            case 'cafoa':
                $route = 'fms.cafoa.create';
                break;

            case 'purchase_request':
                $route = 'fms.procurement.request.create';
                break;

            case 'purchase_order':
                $route = 'fms.procurement.order.create';
                break;

            case 'travel_itinerary':
                $route = 'fms.travel.itinerary.create';
                break;

            case 'travel_order':
                $route = 'fms.travel.order.create';
                break;

            default: 
                $route = null;
                break;

        }

        return $route;
    }
}
