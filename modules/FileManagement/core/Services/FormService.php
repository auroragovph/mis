<?php

namespace Modules\FileManagement\core\Services;

use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Models\Document\Series;

class FormService
{
    public ?int $office, $encoder, $liaison, $type;
    public ?string $status;
    public ?array $props;
    public ?Series $series;

    public function __construct() {

        $this->office = authenticated('office_id');
        $this->encoder = authenticated('employee_id');
        $this->status = Status::ACTIVATION->value;
        $this->liaison = request()->post('liaison') ?? null;
        $this->props = null;
        $this->series = null;

        return $this;
    }

    public function office(int $office): self
    {
        $this->office = $office;
        return $this;
    }

    public function liaison(int $liaison): self
    {
        $this->liaison = $liaison;
        return $this;
    }

    public function encoder(int $encoder): self
    {
        $this->encoder = $encoder;
        return $this;
    }

    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function type(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function props(array $props): self
    {
        $this->props = $props;
        return $this;
    }

    public function store($attachment = false)
    {
        if($attachment){

            $series = Series::find($attachment);

            if(!$series){
                throw new ErrorException('Series Not Found', 419);
            }else {
                $this->series = $series;
            }

        }else{
            $this->series = Series::create([
                'office_id' => $this->office,
                'liaison_id' => $this->liaison,
                'encoder_id' => $this->encoder,
                'type' => $this->type,
                'properties' => $this->props
            ]);
        }

        return $this;
    }

    public function formable(Model $model)
    {
        if($this->series !== null){

            $model->formable()->create([
                'encoder_id' => authenticated('employee_id'),
                'series_id'  => $this->series->id,
            ]);

            return $this->series;
        }

        return throw new ErrorException('Series Not Found', 419);
    }


}
