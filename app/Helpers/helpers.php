<?php

/**
 *  Utility Helpers for Management Information System of Provincial Government of Aurora
 *
 *  @package		CodeIgniter
 *	@subpackage		Utility Helper
 *	@category		Helpers
 *	@author			JMPRNS@github
 *	@link			https://github.com/jmprns/fms
*/


if (! function_exists('employees')) {
    /**
     * Return the lists of all employees
     * @param array
     * @return collection
     */
    function employees($array){

        $employees = \Modules\HumanResource\Entities\HR_Employee::query();

        if(in_array('liaison', $array)){
            $employees->liaison();
        }

        return $employees->get();
    }
}

if (! function_exists('ucnames')) {
    /**
     * Convert names to strtolower then ucfirst
     * @param string $name
     * @return string $name
     */
    function ucnames($string)
    {
        $arrays = explode(' ', $string);

        $new = array_map(function($value){
            return ucfirst(strtolower($value));
        }, $arrays);

        return implode(' ', $new);
    }
}

if (! function_exists('name_mutate')) {
    /**
     * Explode the string and remove unnessary blank key
     * @param string $name
     * @return string $name
     */
    function name_mutate($string, $delimeter = ' ', $glue = ' ')
    {
        $a = array_filter(explode($delimeter, $string));

        return ucnames(implode($glue, $a));
    }
}

if (! function_exists('name_decode')) {
    /**
     * Decode the given name into array
     * @param string $name
     * @return array $final
     */
    function name_decode($name)
    {
        $final = array();
        


        // check first if DOT exists
        if(strpos($name, '.') !== false){
            $explode = explode('.', $name);
            $final['lname'] = name_mutate($explode[1]);
            $final['mname'] = name_mutate(substr($explode[0], -1));
            $final['fname'] = name_mutate(substr_replace($explode[0], '', -1));
            
        }else{

            $explode = explode(' ', $name);

            switch(count($explode)){

                case 2: 
                    $final['fname'] = name_mutate($explode[0]);
                    $final['mname'] = '';
                    $final['lname'] = name_mutate($explode[1]);
                break;

                case 3:
                    $final['fname'] = name_mutate($explode[0]);
                    $final['mname'] = name_mutate($explode[1]);
                    $final['lname'] = name_mutate($explode[2]); 
                break;

                case 4: 
                    $final['fname'] = name_mutate($explode[0]." ".$explode[1]);
                    $final['mname'] = '';
                    $final['lname'] = name_mutate($explode[2]." ".$explode[3]);
                break;

                default: 
                    $final['fname'] = name_mutate($name);
                    $final['mname'] = '';
                    $final['lname'] = '';
                break;

            }


        }

        return $final;
    }
}

if (! function_exists('numwords')) {
    /**
     * Convert number to readable word
     * @param float $number
     * @param string $currency
     * @return string
     */
    function numwords($number, $currency = 'pesos'){

        $word = '';

        $whole = new NumberFormatter('ph', NumberFormatter::SPELLOUT);
        $filter = $whole->format($number);

        if(strpos($filter, 'point')){
            $ex = explode(' point ', $filter);
            $word .= $ex[0];
            $word .= ' '.$currency.' and ';
            $word .= $ex[1];
            $word .= ' centavos';
        }else{
            $word .= $filter;
            $word .= ' '.$currency;
        }
        return $word;

    }
}

if (! function_exists('numonly')) {
    /**
     * Remove all the string in a string except for numbers
     * @param string $currency
     * @return int 
     */
    function numonly($string){
        return preg_replace('/[^0-9]/', '', $string);
    }
}

if (! function_exists('doc_match')) {
    /**
     * Checking if the document match with the correct type
     * @param string $doctype
     * @param string $type
     * @return void
     */
    function doc_match($doctype, $type){

        if($doctype != $type){
            return abort(404);
        }

    }
}

if (! function_exists('series')) {
    /**
     * Convert series to document ID
     * @param string 
     * @return string
     */
    function series($string){

        if(strlen($string) <= 8){
            return $string;
        }

        return (int)substr($string, 8, 8);
    }
}

if (! function_exists('fts_series')) {
    /**
     * Convert FTS series to integer
     * @param string 
     * @return string
     */
    function fts_series($string, $action = 'decode'){

        if($action == 'encode'){
            $string = strtoupper($string);
            return (strpos($string, 'SR') == false) ? 'SR-'.str_pad($string, 11, '0', STR_PAD_LEFT) : $string;
        }

        return (int)preg_replace('/[^0-9]/', '', $string);

    }
}

if (! function_exists('fts_action_button')) {
    /**
     * Convert FTS series to integer
     * @param string 
     * @return string
     */
    function fts_action_button($series, $edit = ['route' => '', 'id' => 0]){

        $action =   '<div class="dropdown dropleft">
                        <button class="btn btn-default btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fal fa-cog"></i>  Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';


        if($edit['route'] != ''){
            if(auth()->user()->can('fts.document.edit')){
                $action .= '<a class="dropdown-item" href="'.route($edit['route'], $edit['id']).'"> <i class="fal fa-edit"> </i> Edit</a>';
            }
        }
        
        if(auth()->user()->can('fts.document.print')){
            $action .= '<a class="dropdown-item" target="_blank" href="'.route('fts.documents.receipt', ['series' => $series, 'print' => 'true']).'"><i class="fal fa-print"></i> Print</a>';
        }

        $action .= '<a class="dropdown-item" href="'.route('fts.documents.track', ['series' => $series]).'"> <i class="fal fa-search"></i> Track</a>';
                    
        $action .= '</div></div>';

        return $action;
    }
}

if (! function_exists('divisions')) {
    /**
     * Get the lists of divisions with it's office
     * @param string 
     * @return object|array
     */
    function divisions($type = 'object'){
        $divisions = Modules\System\Entities\Office\SYS_Division::with('office')->get();
        return ($type == 'array') ? $divisions->toArray() : $divisions;
    }
}


if (! function_exists('is_date')) {
    /**
     * Check if the string is date
     * @param string 
     * @return bool
     */
    function is_date($string){

        if(!$string){return false;}

        try{
            return Carbon\Carbon::parse($string)->format('Y-m-d');
            // return true;
        }catch(\Exception $e){
            return false;
        }

    }
}

if(! function_exists('fts_series_lists')) {
    /**
     * Return all the available QR Codes
     * @param string 
     * @return string
     */
    function fts_series_lists($modifier = 'available'){
        $qrs = new Modules\FileTracking\Entities\Document\FTS_Qr;
        return ($modifier == 'available') ? $qrs->where('status', false)->get() : $qrs->get();
    }
}

if (! function_exists('doc_type_only')) {
    /**
     * DOC TYPE HELPER
    * @param int $int
    * @return string
    */
    function doc_type_only($int){
        switch($int){

            case 101: 
                $type = 'Purchase Request';
            break;

            case 102: 
                $type = 'Purchase Order';
            break;

            case 200: 
                $type = 'Obligation Request';
            break;

            case 301: 
                $type = 'Travel Order';
            break;

            case 302: 
                $type = 'Itinerary of Travel';
            break;

            case 400: 
                $type = 'CAFOA';
            break;

            case 500: 
                $type = 'Application for Leave';
            break;

            case 600: 
                $type = 'Disbursement Voucher';
            break;

            case 700: 
                $type = 'Payroll';
            break;
            
            default:
                // $type = 'undefined';
                $type = $int;
            break;
        }
        return $type;
    }
}

if (! function_exists('show_status')) {
    /**
    * Return color of the status in the show form
    * @param string
    * @return string  
    */
    function show_status($status)
    {
        $status = document_status($status);
        $color = document_status($status, 'label');
        return "<span class=\"label label-light-{$color} label-inline font-weight-bold label-lg\">{$status}</span>";
    }
}

if (! function_exists('authenticated')) {
    /**
    * Return the current authenticated user
    * @return object  
    */
    function authenticated(){
        return session()->get('authenticated');
    }
}




if (! function_exists('document_status')) {
    /**
    * Return color of the status in the show form
    * @param string
    * @return string  
    */
    function document_status($status, $return = 'status')
    {
        switch($status)
        {
            case '0':  
                $label =  'danger';
                $status = 'Cancelled';
            break;

            case '1':  
                $label = 'warning';
                $status = 'Wating for Activation';
            break;

            case '2':  
                $label = 'primary';
                $status = 'On Process';
            break;

            case '3':  
                $label = 'success';
                $status = 'Approves';
            break;

            case '4':  
                $label = 'danger';
                $status = 'Disapproved';
            break;

            case '5':  
                $label = 'warning';
                $status = 'Pending';
            break;

            case '6':  
                $label = 'danger';
                $status = 'Pending';
            break;

            case '7':  
                $label = 'success';
                $status = 'For Withdrawal';
            break;

            case '8':  
                $label = 'primary';
                $status = 'Paid';
            break;

            default:
                $label = 'inverse';
                $status = 'Undefined';
            break;
        }

        return ($return == 'status') ? $status : $label;
    }
}


if (! function_exists('transmittal_status')) {
    /**
    * Return color of the status in the show form
    * @param string
    * @return string  
    */
    function transmittal_status($transmittal)
    {

        if($transmittal->status == 1){

            if($transmittal->isExpired == true){
                return '<span class="badge bg-danger">EXPIRED</span>';
            }
            
        }
        
        switch($transmittal->status)
        {
           
            case '1':  
                $status =  '<span class="badge bg-primary">PENDING</span>';
            break;

            case '2':  
                $status =  '<span class="badge bg-success">RECEIVED</span>';
            break;

            case '3':  
                $status =  '<span class="badge bg-danger">EXPIRED</span>';
            break;

            default:
                $status =  '<span class="badge bg-black">UNDEFINED</span>';
            break;
        }

        return $status;
    }
}

if (! function_exists('sh')) {
    /**
    * Echo selected in select option
    * @param string
    * @return string
    */
    function sh($a, $b)
    {
        if($a == $b){
            return 'selected';
        }
    }
}

if (! function_exists('dm_abort')) {
    /**
    * Check the parameters if match and return http response
    * @param string $a
    * @param string $b
    * @param int $code
    * @return void
    */

    function dm_abort($a, $b, $code = 404, $strict = true){

        if($strict == false && auth()->user()->can('godmode')){
            return true;
        }

        if($a != $b){
            return abort($code);
        }
    }
}

if (! function_exists('iah')) {
    /**
    * Echo selected in select option
    * @param string
    * @param array
    * @return string
    */
    function iah($a, $b)
    {
        if(in_array($a, $b)){
            return 'selected';
        }
        
    }
}

if (! function_exists('auth_division')) {
    /**
    * Return authenticated employees division id
    * @return string
    */
    function auth_division()
    {
       return authenticated()->employee->division_id;
    }
}

if (! function_exists('tonh')) {
    /**
    * Return all the name of the emloyees in travel order
    * @param object
    * @return string
    */
    function tonh($employees){

        $string = '';
    
    
        foreach($employees as $employee){
            $string .= name_helper($employee->name).", ";
        }
    
    
        return substr($string, 0, -2);
    
    }
}

if (! function_exists('employee_id_helper')){
    /**
    * Get the employee ID from the QR Code
    * @param object
    * @return string
    */
    function employee_id_helper($string)
    {
        $string = strtoupper($string);

        if(strpos($string, 'PGA-JO-')){
            $explode = explode('PGA-JO-', $string);
            return 'PGA-JO-'.numonly($explode[1]);
        }

        if(strpos($string, 'PGA-C-')){
            $explode = explode('PGA-C-', $string);
            return 'PGA-C-'.numonly($explode[1]);
        }

        if(strpos($string, 'PGA-P-')){
            $explode = explode('PGA-P-', $string);
            return 'PGA-C-'.numonly($explode[1]);
        }
        
        return $string;
    }
}

if (! function_exists('office_helper')) {
    /**
    * DOC TYPE HELPER
    * @param array
    * @param string
    * @return string
    */
    function office_helper($array, $return = 'all'){

        if($array == null){
            return null;
        }

        $office = $array['office'];
        $division = ['name' => $array['name'], 'alias' => $array['alias']];

        // check if the division is the main office .... return the office name
        if($division['name'] == 'MAIN'){
            return ($office['alias'] == null) ? $office['name'] : "{$office['name']} ({$office['alias']})";
        }else{
            // if not the main return the division name with office alias

            // check if the office name is null
            $off = ($office['alias'] == null) ? '' : "{$office['alias']} - ";
            return ($division['alias'] == null) ? "{$off} {$division['name']}" : "{$off} {$division['name']} ({$division['alias']})";

        }

    }
}

if (! function_exists('hrefroute')) {
    /**
    * Hyperlink to route show helper
    * @param int $id
    * @param string $route
    * @return string
    */
    function hrefroute($id, $route, $size = 'xs', $color = 'primary', $icon = 'eye', $verb = 'View'){

        $route = route($route, $id);

        return "
            <a 
            target=\"_blank\"
            href=\"{$route}\"
            class=\"btn btn-{$size} bg-gradient-{$color}\"
            >

            <i class=\"fal fa-{$icon}\"></i>

            {$verb}

            </a>
        ";
    
    }
}

if (! function_exists('user_agent')) {
    /**
    * Return the user agent
    * @return array
    */
    function user_agent(){

        $agent = new Jenssegers\Agent\Agent();

        return [
            'ip' => request()->getClientIp(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'platform' => $agent->platform()
        ];
    }
}

if (! function_exists('name_to_username')) {
    /**
    * Convert name to username
    * @return array
    */
    function name_to_username($fname, $lname){
        // return str_replace(' ', '_', strtolower($fname." ".$lname))."_".mt_rand(1,999);
        return str_replace(' ', '_', strtolower($fname." ".$lname));
    }
}


if (! function_exists('menu_helper')) {
    /**
    * Convert name to username
    * @return array
    */
    function menu_helper($string){
        $current_url = request()->url();
        $menu_url = request()->getSchemeAndHttpHost()."/".$string;
        return (strpos($current_url, $menu_url) === false) ? '' : 'menu-item-here';
    }
}


if (! function_exists('qr_to_base64')) {
    /**
    * Convert name to username
    * @return array
    */
    function qr_to_base64($string){
        $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(500)
                    ->merge('/public/media/logos/favicon.png', .3)
                    ->errorCorrection('H')
                    ->generate($string);

        return base64_encode($qr);
    }
}

if (! function_exists('pretty_number')) {
    /**
    * Convert number to pretty
    * @param string
    * @return string
    */
    function pretty_number($string){
        return number_format(floatval($string), 2);
    }
}

if (! function_exists('link_back')) {
    /**
    * Return the referer url
    * @return array
    */
    function link_back($route = '#'){
        $referer = request()->headers->get('referer');
        return ($referer == null) ? $route : $referer;
    }
}

if (! function_exists('activitylog')) {
    /**
    * Insert activity logs
    * @param array
    * @return object
    */
    function activitylog($array){
        $name = $array['name'] ?? 'sys';
        $log = $array['log'] ?? '';
        $properties = $array['props'] ?? null;

        $log = \Modules\System\Entities\SYS_ActivityLog::create([
            'name' => $name,
            'log' => $log,
            'properties' => $properties,
            'employee_id' => authenticated()->employee_id,
            'agent' => user_agent()
        ]);
    }
}


if (! function_exists('arrdif')) {
    /**
    * Insert activity logs
    * @param array
    * @return object
    */
    function arrdif($old, $new){

        $changes = array();

        foreach($old as $key => $value){

            if(is_array($value)){
                $changes[$key] = arrdif($value, $new[$key]);
            }else{

                if($value != $new[$key]){

                    $changes[$key] = [
                        'old' => $old[$key],
                        'new' => $new[$key]
                    ];
                }

            }
        }

        return $changes;
      
    }
}








function tracking_table_status($status)
{
    switch($status)
    {
        case '0':  
            $status =  '<span class="btn-danger ">CANCELLED</span>';
        break;

        case '1':  
            $status =  '<span class="btn-warning ">DEACTIVATED</span>';
        break;

        case '2':  
            $status =  '<span class="btn-primary ">ON PROCESS</span>';
        break;

        case '3':  
            $status =  '<span class="btn-success ">APPROVED</span>';
        break;

        case '4':  
            $status =  '<span class="btn-danger ">DISAPPROVED</span>';
        break;

        case '5':  
            $status =  '<span class="btn-info ">PENDING</span>';
        break;

        case '6':  
            $status =  '<span class="btn-warning ">RETURNED</span>';
        break;

        case '7':  
            $status =  '<span class="bg-olive">FOR WITHDRAWAL</span>';
        break;

        case '8':  
            $status =  '<span class="bg-lime">PAID</span>';
        break;

        default:
            $status =  '<span class="btn-inverse ">UNDEFINED</span>';
        break;
    }
    return $status;

}



/**
 * Convert the document attached into array
 * @param string
 * @return string  
 */
function implode_attached($attachments)
{
    $data = array();

    foreach($attachments as $attachment){
        $data[] = $attachment->description;
    }

    return implode(',', $data);
}


/**
 * Get the unique values id
 * @param string
 * @return string
 */
function unique_array($delimeter, $datas)
{
    $array = array();

    foreach($datas as $data){

        if(!in_array($data[$delimeter], $array)){
            $array[] = $data[$delimeter];
        }

    }

    return $array;
}







/**
 * Improved in_array_multiple function
 * @param string
 * @return string
 */
function in_array_any($needles, $haystack) {
    return (bool)array_intersect($needles, $haystack);
 }




/**
 * LEAVE HELPER
 * @param int
 * @return string
 */
function leave_helper($type){

    switch((int)$type){
        case 1:
            $type = 'Vacation';
        break;

        case 2:
            $type = 'Sick';
        break;

        case 3:
            $type = 'Maternity';
        break;
        
        default:
            $type = 'Others';
        break;
    }
    return $type;
}


/**
 * Text Print Helper
 * @param int
 * @return string
 */
function print_text_helper($string){

    $length = strlen($string);

    // $formatted = '14px';

    if($length <= 15){
        $formatted = '13px';
    }

    if($length > 15 && $length <= 40){
        $formatted = '12px';
    }

    if($length >= 41){
        $formatted = '10px';
    }


    return $formatted;
}

/**
 * Padding Helper
 * @param int
 * @return string
 */
function padding_helper($string, $length, $pad = STR_PAD_BOTH){

    $string = str_pad($string, $length, '*', $pad);
    $string = str_replace("*", "&nbsp;", $string);

    return $string;

}

/**
 * Name Helper
 * @param array
 * @return string
 */
function name_helper($name, $arrangement = 'FMIL'){

    $name = (array)$name;

    $fname = (array_key_exists('fname', $name)) ? ucfirst($name['fname']) : "";
    $lname = (array_key_exists('lname', $name)) ? ucfirst($name['lname']) : "";
    $mname = (array_key_exists('mname', $name)) ? ucfirst($name['mname']) : "";

    // $fname = @$name['fname'];
    // $mname = @$name['mname'];
    // $lname = @$name['lname'];


    
    switch($arrangement){
    
        case 'LFMI':
          $name = $lname.", ".$fname." ".@$mname[0].".";
        break;

        case 'LFM':
            $name = $lname.", ".$fname." ".$mname;
        break;

        case 'FMIL':  
            $name = $fname." ".@$mname[0].". ".$lname;
        break;

        case 'FL': 
            $name = $fname." ".$lname;
        break;
    
        case 'FMNL':  
            $name = $fname." ".$mname." ".$lname;
        break;

        case 'SYM-F': 
            $name = strtoupper($fname[0]);
        break;

        case 'SYM-FL': 
            $name = strtoupper($fname[0].$lname[0]);
        break;


        default:
           $name = null;
        break;

    }

    return $name;

}







/**
 * OFFICE ALIAS HELPER
 * @param array
 * @return string
 */
function office_alias_helper($array){

    if($array->name == 'MAIN'){
        if($array->office->alias != ''){
            $office = "{$array->office->alias}";
        }else{
            $office = "{$array->office->name}";
        }

    }else{
        if($array->alias != ''){
            $office = "{$array->alias}";
        }else{
            $office = "{$array->name}";
        }
    }

    return $office;
    
}

/**
 * EMPLOYMENT ALIAS HELPER
 * @param string
 * @return string
 */
function employment_helper($type){
    switch($type)
    {
        case '1': 
            $em = 'JOB ORDER';
        break;

        case '2': 
            $em = 'CASUAL';
        break;

        case '3': 
            $em = 'PERMANENT';
        break;
    }

    return $em;
}


/**
 * ACTION HELPER
 * @param string
 * @return int
 */
function action_helper($act)
{
    switch($act){
        case 'RECEIVE':
            $a = 0; 
        break;

        case 'RELEASE':
            $a = 1; 
        break;

        default:
            $a = false; 
        break;
    }

    return $a;
}





/**
 * DATE DIFFERENCE
 * @param int
 * @return string
 */
function get_date_diff( $time1, $time2, $precision = 3 ) {
	// If not numeric then convert timestamps
	if( !is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if( !is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}
	// If time1 > time2 then swap the 2 values
	if( $time1 > $time2 ) {
		list( $time1, $time2 ) = array( $time2, $time1 );
	}
	// Set up intervals and diffs arrays
	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
	$diffs = array();
	foreach( $intervals as $interval ) {
		// Create temp time from time1 and interval
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ( $time2 >= $ttime ) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime( "+" . $add . " " . $interval, $time1 );
			$looped++;
		}
		$time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
		$diffs[ $interval ] = $looped;
	}
	$count = 0;
	$times = array();
	foreach( $diffs as $interval => $value ) {
		// Break if we have needed precission
		if( $count >= $precision ) {
			break;
		}
		// Add value and interval if value is bigger than 0
		if( $value > 0 ) {
			if( $value != 1 ){
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	// Return string with times
	return implode( ", ", $times );
}


/**
 * Permission helper
 * @param array
 * @return boolean
 */

function permission_helper($array = '', $strict = false){

    // Return true if the user is a ROOT user
    if($_SESSION['role']['description'] == 'Root User' || $_SESSION['role']['id'] == 1){
        return true;
    }

    $count = 0;
    $permissions = $_SESSION['permissions'];

    if(!is_array($array)){
        $array = [$array];
    }

    foreach($array as $permission){
        if(in_array($permission, $permissions)){
            $count++;
        }
    }

    if($strict == false){

        if($count != 0){
            return true;
        }

        return false;
    }

    if(empty($array) || $count < count($array)){
        return false;
    }

    return true;

}








