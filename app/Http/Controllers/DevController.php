<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use EmployeeFactory;
use Modules\FileManagement\Entities\Document\FMS_Document;
use Spatie\Permission\Models\Role;

class DevController extends Controller
{
    public function index()
    {

      $arr1 = [
        'one' => 'one',
        'two' => 'two',
        'three' => [
          'a' => 'a',
          'b' => 'c'
        ]
      ];

      $arr2 = [
        'one' => 'one',
        'two' => 'three',
        'three' => [
          'a' => 'a',
          'b' => 'b'
        ]
      ];


      dd(arrdif($arr2, $arr1));
    }
}
