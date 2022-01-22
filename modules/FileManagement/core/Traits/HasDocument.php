<?php

namespace Modules\FileManagement\core\Traits;
use Modules\FileManagement\core\Models\Document\Form;
use Modules\FileManagement\core\Models\Document\Series;

trait HasDocument
{
    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function formable()
    {
        return $this->morphOne(Form::class, 'formable');
    }

    public static function createDocument(array $forms, bool $attachment = false): static
    {
        if (!$attachment) {
            $document           = Series::directStore(request()->post('liaison'), self::doctype());
            $forms['series_id'] = $document->id;
        }
        $data = self::create([...$forms]);

        $data->formable()->create([
            'encoder_id' => authenticated('employee_id'),
            'series_id'  => $document->id ?? $forms['series_id'] ?? null,
        ]);
        return $data;
    }

}
