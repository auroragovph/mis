<?php

namespace Modules\FileManagement\core\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\FileManagement\core\Models\Document\Series;

class FormController extends Controller
{
    public $model, $routes, $doctype, $alias, $circular;

    public function save(array $forms, bool $attached = false)
    {
        try {

            if ($attached == false) {
                $document           = Series::directStore(request()->post('liaison'), $this->doctype);
                $forms['series_id'] = $document->id;
            }

            $data = $this->model::create($forms);
            $data->formable()->create([
                'encoder_id' => authenticated('employee_id'),
                'series_id'  => $document->id ?? $forms['series_id'],
            ]);

        } catch (\Exception$e) {
            return $e;
        }

        return $data;
    }

    public function details(int $id, array $relations = [])
    {

        $relations = [
            'series.attachments',
            'series.office',
            'series.forms.encoder',
            'series.forms.formable',
            ...$relations,
        ];

        $data = $this->model::with($relations)->findOrFail($id);

        return $data;
    }

    public function patch(int $id, array $forms)
    {
        $data = $this->model::with('series')->findOrFail($id);
        $data->update($forms);

        if (request()->has('liaison')) {
            $data->series()->update(['liaison_id' => request()->post('liaison')]);
        }

        // activity loger
        activitylog('fms', 'Update document', [
            'series'   => $data->series->id,
            'document' => $id,
        ]);

        return $data;
    }

    public function is_attachment(): bool
    {
        if (request()->has('attachment') and request()->get('attachment') == true) {
            $doc_id   = request()->get('series_id');
            $document = Series::findOrFail($doc_id);
            if ($document->qr != request()->get('qrcode')) {
                return abort(404);
            }

            session(['fms.document.attach' => (int) $doc_id]);
            return true;

        }

        return false;
    }
}
