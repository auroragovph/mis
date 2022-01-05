<?php

namespace Modules\FileManagement\core\Http\Controllers\Document;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Http\Requests\Document\Attachment\CheckRequest;
use Modules\FileManagement\core\Http\Requests\Document\Attachment\HardcopyRequest;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\FileManagement\core\Models\Document\Attachment;

class AttachmentController extends Controller
{
    public function index()
    {
        return view('fms::document.attach.index');
    }

    public function check(CheckRequest $request)
    {

        $id     = series($request->post('document'));
        $series = Series::find($id);

        if (!$series or $series->qrcode !== $request->post('document')) {
            return redirect()
                ->back()
                ->with('alert-error', message_box('document.not.found'));
        }

        if ($series->status === Status::CANCELLED->value) {
            return redirect()
                ->back()
                ->with('alert-error', message_box('document.cancelled'));
        }

        switch ($request->post('attachtype')) {

            case 'hardcopy':
                return redirect(route('fms.document.attach.hardcopy', [
                    'id'       => $id,
                    'qrcode'   => $request->post('document'),
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
                    'series_id' => $id,
                    'qrcode'      => $series->qrcode,
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
        $document = Series::findOrfail(request()->get('id'));

        if ($document->qrcode !== request()->get('qrcode')) {
            return abort(404);
        }

        if ($document->status === Status::CANCELLED->value) {
            return redirect()->back()->with('alert-error', message_box('document.cancelled'));
        }

        return view('fms::document.attach.hardcopy', [
            'document' => $document,
        ]);
    }

    public function attach(HardcopyRequest $request)
    {
        $id   = $request->post("document_id");
        $mime = 'text';
        $url  = null;

        if ($request->hasFile('file')) {

            $file           = $request->file('file');
            $hash_name      = $file->hashName();
            $mime           = 'file';
            $storage_folder = 'document/attachments';

            // checking if the uploaded file is an image
            if (strpos($file->getMimeType(), 'image') !== false) {

                $image = Image::make($file)->encode();

                // store in laravel storage NOT in public folder
                $store = Storage::put($storage_folder . "\\" . $hash_name, $image);
            } else {
                $store = Storage::put($storage_folder, $file);
            }
        }

        if (isset($store) and !$store) {
            return redirect()
                ->back()
                ->with('alert-error', 'Uploading file unsuccess');
        }

        $attachment = Attachment::create([
            'series_id'   => $id,
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
        activitylog('document', 'Add a hardcopy attachment to the document. ', [
            'series' => $id,
        ]);

        return redirect()->back()->with('alert-success', 'Attachment success');
    }

    public function file($file)
    {
        return response()->file(storage_path('app/document/attachments/' . $file));
    }

    /**
     * Attach existing documents to another document using the formable method of the documents
     */

    public function dynamic(string $qrs, int $docid)
    {
        $invalids = array();
        $qrs = explode(',', $qrs);
        // $series = Series::whereIn('id', array_map(fn($qr) => series($qr), $qrs))->get();

        // get the first attachments of that qrcode
        foreach($qrs as $qr){

            $id       = series($qr);
            $document = Series::find($id);

            if (!$document or $document->qrcode !== $qr or $document->id == $docid) {
                array_push($invalids, $qr);
                continue;
            }

            $attachments = Form::where('series_id', $id)->get();
            $forms       = Form::insert($attachments->map(function ($att) use ($docid) {
                return [
                    'series_id'     => $docid,
                    'formable_type' => $att->formable_type,
                    'formable_id'   => $att->formable_id,
                    'encoder_id'    => authenticated('employee_id'),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            })->toArray());

        }
        dd($forms);
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
                $route = 'procurement.request.create';
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
