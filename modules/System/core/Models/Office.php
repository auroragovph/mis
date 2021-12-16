<?php

namespace Modules\System\core\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = [];
    protected $table = 'sys_office';
}
