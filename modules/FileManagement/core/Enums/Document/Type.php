<?php

namespace Modules\FileManagement\core\Enums\Document;

enum Type : int
{
    case PROCUREMENT = 100;
    case PROCUREMENT_PURCHASE_REQUEST = 101;
    case PROCUREMENT_PURCHASE_ORDER = 102;

    case TRAVEL = 200;
    case TRAVEL_ORDER = 201;
    case TRAVEL_ITINERARY = 202;
    case TRAVEL_MISSION = 205;


    case OTHER = 900;
    case OTHER_LIQUIDATION = 901;
    case OTHER_OB_SLIP = 902;
    case OTHER_POW = 903;

    public function formal_label(): string
    {
        return match($this){
            self::PROCUREMENT => 'PROCUREMENT',
            self::PROCUREMENT_PURCHASE_REQUEST => 'PURCHASE REQUEST',
            self::PROCUREMENT_PURCHASE_ORDER => 'PURCHASE ORDER',

            self::TRAVEL => 'TRAVEL',
            self::TRAVEL_ORDER => 'TRAVEL ORDER',
            self::TRAVEL_ITINERARY => 'ITINERARY OF TRAVEL',
            self::TRAVEL_MISSION => 'MISSION ORDER',

            self::OTHER => "OTHER DOCUMENT",
            self::OTHER_LIQUIDATION => "LIQUIDATION REPORT",
            self::OTHER_OB_SLIP => "OB SLIP",
            self::OTHER_POW => "POWER OF WORKS",
        };
    }

    // public function
}

