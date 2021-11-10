<?php

namespace Modules\FileManagement\Http\Controllers\Document;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\FileManagement\Entities\Document\Attachment;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Document\Form;
use Modules\FileManagement\Http\Requests\Document\Attachment\CheckRequest;
use Modules\FileManagement\Http\Requests\Document\Attachment\HardcopyRequest;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:fms.sa.attach']);
    }

    public function index()
    {
        activitylog(['name' => 'fms', 'log' => 'Request document attach form.']);
        return view('filemanagement::actions.attach.index');
    }

    public function check(CheckRequest $request)
    {

        $id       = series($request->post('document'));
        $document = Document::find($id);

        if (!$document or $document->qr !== $request->post('document')) {
            return redirect()
                ->back()
                ->with('alert-error', message_box('document.not.found'));
        }

        if ($document->status === 0) {
            return redirect()
                ->back()
                ->with('alert-error', message_box('document.cancelled'));
        }

        switch ($request->post('attachtype')) {

            case 'hardcopy':
                return redirect(route('fms.documents.attach.hardcopy', [
                    'id'       => $id,
                    'qr'       => $request->post('document'),
                    'checksum' => Str::random(10),
                    'token'    => Str::random(30),
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

                if ($route == null) {
                    return abort(404);
                }

                return redirect(route($route, [
                    'attachment'  => true,
                    'document_id' => $id,
                    'qrcode'      => $document->qr,
                    'token'       => csrf_token(),
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

        if ($document->status === 0) {
            return redirect()->back()->with('alert-error', message_box('document.cancelled'));
        }

        return view('filemanagement::actions.attach.hardcopy', [
            'document' => $document,
        ]);
    }

    public function attach(HardcopyRequest $request)
    {
        $id    = $request->post("document_id");
        $mime  = 'text';
        $url   = null;

        if ($request->hasFile('file')) {

            $file           = $request->file('file');
            $hash_name      = $file->hashName();
            $mime           = 'file';
            $storage_folder = 'filemanagement/document/attachments';

            // checking if the uploaded file is an image
            if (strpos($file->getMimeType(), 'image') !== false) {

                $image = Image::make($file)->encode();

                // store in laravel storage NOT in public folder
                $store = Storage::put($storage_folder . "\\" . $hash_name, $image);
            } else {
                $store = Storage::put($storage_folder, $file);
            }
        }

        if (isset($store) AND !$store) {
            return redirect()
                ->back()
                ->with('alert-error', 'Uploading file unsuccess');
        }

        $attachment = Attachment::create([
            'document_id' => $id,
            'description' => $request->post('name'),
            'url'         => $hash_name ?? null,
            'mime'        => $mime,
            'properties'  => array(
                'number' => $request->post('number') ?? null,
                'date'   => $request->post('date') ?? null,
                'amount' => $request->post('amount') ?? null,
                'page'   => $request->post('page') ?? null,
            ),
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log'  => 'Add attachment to the document.',
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
            $id       = series($qr);
            $document = Document::find($id);

            if (!$document or $document->qr !== $qr) {
                array_push($invalids, $qr);
                continue;
            }

            // get all the attached documents
            $attachments = Form::where('document_id', $id)->get();
            $forms       = Form::insert($attachments->map(function ($att) use ($docid) {
                return [
                    'document_id'   => $docid,
                    'formable_type' => $att->formable_type,
                    'formable_id'   => $att->formable_id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            })->toArray());

        }

        return true;
    }

    public function newform(string $type): string
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
