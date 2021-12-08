<?php 

namespace Modules\FileManagement\Enum;

enum DocumentStatus : int
{
    case CANCELLED = 0;
    case ACTIVATION = 1;
    case ON_PROCESS = 2;
    case APPROVED = 3;
    case DISAPPROVED = 4;
    case PENDING = 5;
    case RETURN = 6;
    case WITHDRAW = 7;
    case PAID = 8;

    public function color(): string
    {
        return match($this){
            self::CANCELLED => 'danger',
            self::ACTIVATION => 'warning',
            self::ON_PROCESS => 'primary',
            self::APPROVED => 'success',
            self::DISAPPROVED => 'danger',
            self::PENDING => 'warning',
            self::RETURN => 'danger',
            self::WITHDRAW => 'success',
            self::PAID => 'primary',
        };
    }

    public function formal_label(): string
    {
        return match($this){
            self::CANCELLED => 'CANCELLED',
            self::ACTIVATION => 'WAITING FOR ACTIVATION',
            self::ON_PROCESS => 'ON PROCESS',
            self::APPROVED => 'APPROVED',
            self::DISAPPROVED => 'DISAPPROVED',
            self::PENDING => 'PENDING',
            self::RETURN => 'RETURN',
            self::WITHDRAW => 'FOR WITHDRAWAL',
            self::PAID => 'PAID',
        };
    }

    // public function 
}