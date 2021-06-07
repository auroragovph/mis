<?php

namespace Modules\FileManagement\Http\Controllers\Forms;

use Exception;
use Illuminate\Routing\Controller;
use Modules\FileManagement\Entities\Document\Document;

class FormController extends Controller
{
    public $model, $routes, $doctype, $alias;

    public function save(array $forms, bool $attached = false)
    {

        try {

            if($attached == false){
                $document = Document::directStore(request()->post('liaison'), $this->doctype);
                $forms['document_id'] = $document->id;
            }

            $data = $this->model::create($forms);
            $data->formable()->create([
                'document_id' => $document->id ?? $forms['document_id']
            ]);

        } catch (\Exception $e){
            return throw $e;
        }
        
        return $data;
    }

    public function details(int $id, array $relations = [])
    {

        $relations = array_merge($relations, [
            'document.attachments',
            'document.encoder',
            'document.liaison',
            'document.division.office',
            'document.forms.formable'
        ]);

        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Request information of ' . $this->alias,
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => $this->model
                ]
            ]
        ]);

        $data = $this->model::with($relations)->findOrFail($id);
        return $data;
    }

    public function patch(int $id, array $forms)
    {
        $data = $this->model::with('document')->findOrFail($id);
        $data->update($forms);

        if(request()->has('liaison')){
            $data->document()->update(['liaison_id' => request()->post('liaison')]);
        }


        // activity loger
        activitylog([
            'name' => 'fms',
            'log' => 'Update ' . $this->alias . ' information',
            'props' => [
                'model' => [
                    'id' => $id,
                    'class' => $this->model
                ]
            ]
        ]);

        return $data;
    }
}
