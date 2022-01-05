<?php

namespace Modules\FileManagement\core\Enums\Document;


enum Status: string
{
    case CANCELLED = "CANCELLED";
    case ACTIVATION = "ACTIVATION";
    case ON_PROCESS = "ON_PROCESS";
    case APPROVED = "APPROVED";
    case DISAPPROVED = "DISAPPROVED";
    case PENDING = "PENDING";
    case RETURN = "RETURN";
    case WITHDRAW = "WITHDRAW";
    case PAID = "PAID";

    public static function lists(string $type = 'value'): array
    {
      $lists = array();

      foreach(self::cases() as $key => $enum){

        switch($type){
          case 'value':
            $lists[] = $enum->value;
            break;
          case 'name':
            $lists[] = $enum->name;
            break;
          case 'formal':
            $lists[$enum->value] = $enum->formal_label();
            break;
        }

      }

      return $lists;
    }

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
