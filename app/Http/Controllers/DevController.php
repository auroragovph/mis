<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\System\Entities\SYS_User;
use Illuminate\Support\Facades\Storage;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\HumanResource\Entities\HR_SalaryGrade;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class DevController extends Controller
{

    public $liaisonKeys;
    public $userKeys;

    public function __construct()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
    }

    public function index()
    {
        // $timer = microtime(true);


        // dd(config('filetracking.allowAllEmployeesToLiaison'));

       
        // dd($this->join());    

        // echo 'TOTAL TIME EXECUTION: '.(microtime(true) - $timer);

    }

    public function join()
    {
        $query = DB::table('fts_documents')
                    ->where('fts_documents.type', config('constants.document.type.afl'))
                    ->join('fts_form_afl', 'fts_documents.id', '=', 'fts_form_afl.document_id')
                    ->take(5)
                    ->get();
        
        return $query;
    }

    public function index2()
    {





        $this->liaisonKeys();
        $this->userKeys();

        return die;

        

        $userJSON = file_put_contents(storage_path('app/jsons/seeds/usersKeys.json'), json_encode($this->userKeys, JSON_PRETTY_PRINT));
        return die;


        $documents = collect($this->document());
        

        // dd($this->userKeys);

        $lists = array();

        foreach($documents as $i => $document){

            array_push($lists, [
                'id' => $i + 1,
                'series' => fts_series($document->series),
                'division_id' => $this->ftsOfficeToMisOffice()[$document->office_id] ?? 1,
                'liaison_id' => $this->liaisonKeys[$document->liaison_id] ?? 0,
                'encoder_id' => $this->userKeys[$document->user_id] ?? 0
            ]);
        }

        echo json_encode($lists, JSON_PRETTY_PRINT);

    }

    public function liaisonKeys()
    {
        $employees = HR_Employee::liaison()->get();

        $lists = array();

        foreach($employees as $employee){
            $lists[$employee->properties['ftsOldData']['id']] = $employee->id;
        }

        file_put_contents(storage_path('app/jsons/keys/liaisons.json'), json_encode($lists, JSON_PRETTY_PRINT));

        return $this->liaisonKeys = $lists;
    }

    public function userKeys()
    {
        $employees = HR_Employee::get();

        $lists = array();
        foreach($employees as $employee){

            if(array_key_exists('account', $employee->properties['ftsOldData'])){

                $lists[$employee->properties['ftsOldData']['account']['id']] = $employee->id;

            }else{

                if(array_key_exists('username', $employee->properties['ftsOldData'])){
                    $lists[$employee->properties['ftsOldData']['id']] = $employee->id;
                }

            }

            
        }

        file_put_contents(storage_path('app/jsons/keys/users.json'), json_encode($lists, JSON_PRETTY_PRINT));

        return $this->userKeys = $lists;
    }


    public function docDirty()
    {
        $document = collect($this->document())->chunk(1000);

        foreach($document as $i => $chunk){

            $batch = collect($chunk);

            $start = $batch->first();
            $end = $batch->last();

            file_put_contents(storage_path('app/jsons/fts/dirty/documents/'.$start->id.'-'.$end->id.'.json'), json_encode($chunk, JSON_PRETTY_PRINT));
        }

    }

    public function document()
    {
        $file = file_get_contents(storage_path('app/documents.json'));
        $document = json_decode($file);

        return $document;
    }


    public function ftsOfficeToMisOffice()
    {
        return  [
                    2 => 3,
                    3 => 2,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    8 => 7,
                    9 => 8,
                    11 => 9,
                    12 => 10,
                    13 => 11,
                    14 => 12,
                    15 => 13,
                    16 => 14,
                    17 => 15,
                    18 => 16,
                    19 => 17,
                    20 => 18,
                    21 => 19,
                    22 => 20,
                    23 => 21,
                    24 => 22,
                    25 => 23,
                    26 => 24,
                    27 => 25,
                    32 => 26,
                    33 => 27,
                    36 => 43,
                    37 => 28,
                    43 => 29,
                    58 => 30,
                    59 => 31,
                    60 => 44,
                    71 => 42,
                    72 => 41,
                    73 => 34,
                    74 => 1,
                    75 => 32,
                    76 => 33,
                ];

                

            // return file_put_contents(storage_path('/app/jsons/officeKeys.json'), json_encode($newOfficeKeys, JSON_PRETTY_PRINT));
    }

    public function permissions()
    {
        return [
            1 => 'godmode',
            3 => 'fts.document.*',
            5 => 'fts.sa.rr'
        ];
    }

    public function user()
    {
        $file = file_get_contents(storage_path('app/seeders_documents/users.json'));
        $users = json_decode($file);
        $users = $users[2]->data;

        // dd($users);

        $newKeys = $this->ftsOfficeToMisOffice();
        $permissions = $this->permissions();

        $lists = array();

        foreach($users as $user){
            array_push($lists, [

                'name' => name_decode($user->name),
                'division_id' => $newKeys[$user->office_id] ?? 1,
                'liaison' => false,
                'credentials' => [

                    'username' => $user->username,
                    'password' => $user->password,
                    'level' => $user->user_level,

                    'permissions' => $permissions[$user->user_level] ?? ''

                ],
                'fts_data' => (array)$user
            ]);
        }

        return file_put_contents(storage_path('app/jsons/fts/users.json'), json_encode($lists, JSON_PRETTY_PRINT));
    }

    public function liaisonKeysFileJson()
    {
        $liaisons = HR_Employee::liaison()->get();

        $lists = array();

        foreach($liaisons as $liaison){
            $lists[$liaison->properties['ftsOldData']['id']] = $liaison->id;
        }

        return $lists;
    }

  

    public function liaison()
    {
        $file = file_get_contents(storage_path('app/seeders_documents/liaisons.json'));
        $liaisons = json_decode($file);
        $liaisons = $liaisons[2]->data;

        $newKeys = $this->ftsOfficeToMisOffice();

        $lists = array();

        foreach($liaisons as $liaison){
            array_push($lists, [
                'name' => name_decode($liaison->name),
                'division_id' => $newKeys[$liaison->office_id] ?? 1,
                'credentials' => null,
                'liaison' => true,
                'fts_data' => (array)$liaison
            ]);
        }

        return collect($lists);

        // return file_put_contents(storage_path('app/jsons/fts/liaisons.json'), json_encode($lists, JSON_PRETTY_PRINT));
    }

    public function employeeSeedTest()
    {
        $employees = collect(json_decode(file_get_contents(storage_path('app/jsons/seeds/employees.json')), true));

        
        $lists = array();
        foreach($employees as $i => $employee){
            $lists[] = [
                'division_id' => $employee['division_id'],
                'position_id' => 0,
                'name' => json_encode([
                    'fname' => $employee['name']['fname'],
                    'lname' => $employee['name']['lname'],
                    'mname' => $employee['name']['mname'],
                    'sname' => $employee['name']['suffix'] ?? '',
                    'title' => $employee['name']['title'] ?? '',
                ]),
                'info' => json_encode([
                    'gender' => '',
                    'address' => '',
                    'birthday' => '',
                    'civilStatus' => '',
                    'phoneNumber' => ''
                ]),
                'employment' => json_encode([
                    'type' => 1,
                    'status' => 1,
                    'leave' => [
                        'vacation' => 0,
                        'sick' => 0
                    ]
                ]),
                'card' => 0,
                'liaison' => $employee['liaison'],
                'properties' => json_encode($employee['properties']),
                'created_at' => now()
            ];
        }

        return HR_Employee::insert($lists);
    }

    public function userSeedTest()
    {
        $file = storage_path('app/jsons/seeds/users.json');
        $users = json_decode(file_get_contents($file), true);


        foreach($users as $user){
            $account = SYS_User::create([

                'employee_id' => $user['employee_id'],
                'username' => $user['username'],
                'password' => password_hash($user['password'], PASSWORD_BCRYPT),
                'properties' => $user['properties'],
                'created_at' => now()
            ]);
            $account->givePermissionTo($user['permission']);
        }
    }



    public function employees()
    {
        $file = file_get_contents(storage_path('app/jsons/fts/employees.json'));
        $employees = json_decode($file);

        $lists = array();
        $users = array();

        foreach($employees as $i => $employee){

            array_push($lists, [
                'division_id' => $employee->division_id,
                'position_id' => 0,
                'name' => (array)$employee->name,
                'info' => [
                    'gender' => '',
                    'birthday' => '',
                    'address' => '',
                    'birthday' => '',
                    'civilStatus' => '',
                    'phoneNumber' => '',
                ],
                'employment' => [
                    'type' => 1,
                    'status' => 1,
                    'leave' => [
                        'vacation' => 0,
                        'sick' => 0
                    ]
                ],
                'card' => 0,
                'liaison' => $employee->liaison,
                'properties' => [
                    'ftsOldData' => (array)$employee->fts_data
                ]
            ]);

            if($employee->credentials !== null){
                array_push($users, [
                    'employee_id' => $i + 1,
                    'username' => $employee->credentials->username,
                    'password' => $employee->credentials->password,
                    'properties' => ['auth' => ['firstLogin' => true]],
                    'permission' => $employee->credentials->permissions,
                ]);
            }
        }


        // // saving into the json
        $employeeJSON = file_put_contents(storage_path('app/jsons/seeds/employees.json'), json_encode($lists, JSON_PRETTY_PRINT));
        $userJSON = file_put_contents(storage_path('app/jsons/seeds/users.json'), json_encode($users, JSON_PRETTY_PRINT));

        return [$employeeJSON, $userJSON];
    }
}
 