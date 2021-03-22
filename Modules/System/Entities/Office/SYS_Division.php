<?php

namespace Modules\System\Entities\Office;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Database\factories\DivisionFactory;

class SYS_Division extends Model
{

    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'sys_division';
    

    protected static function newFactory()
    {
        return DivisionFactory::new();
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function scopeLists($query, $all = true)
    {
        if($all == true){
            return $query->with('office')->get();
        }else{
            return $query->with('office')->where('name', '!=', 'MAIN')->get();
        }
    }

    public function office()
    {
        return $this->belongsTo(SYS_Office::class, 'office_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(HR_Employee::class, 'division_id', 'id');
    }
}
