<?php


/**
 *  Utility Helpers for File Management System of Provincial Government of Aurora
 *
 *  @package		CodeIgniter
 *	@subpackage		Utility Helper
 *	@category		Helpers
 *	@author			JMPRNS@github
 *	@link			https://github.com/jmprns/fms
*/

/**
 * Convert numbers into series EG: 1 => PGA-{TYPE}-{DATE_ENCODED}{ID}
 * @param object $string    DOCUMENT OBJECT
 * @return string $series   STRING
 */
function convert_to_series($document){


    $type = $document->type;
    $date = Carbon\Carbon::parse($document->created_at)->format('mdY');
    $id = $document->id;

    return "PGA-{$type}-{$date}{$id}";

}


/**
 * Convert series to document ID
 * @param string 
 * @return string
 */
function series_to_id($string, $type = 'id'){

    $checker = substr($string, 1);

    if(!is_numeric($string)){

        // counting the dashes
        $counts = substr_count($string, '-');

        if($counts != 2){
            return null;
        }

        $ext =  explode('-', $string);
        $real = $ext[2];



    }else{
        $real = $string;
        return $real;
    }

    
    switch($type){

        case 'id': 
            $id = substr($real, 8);
        break;

        case 'both':

            $id['id'] = substr($real, 8);
            $id['date'] = substr($real,0, 8);

        break;

        case 'date': 
            $id = substr($real,0, 8);
        break;

        default: 
            $id = null;
        break;

    }

    return $id;

}





/**
 * Return color of the status in the show form
 * @param string
 * @return string  
 */
function show_status($status)
{
    switch($status)
    {
        case '0':  
            $status =  '<span class="badge bg-danger">CANCELLED</span>';
        break;

        case '1':  
            $status =  '<span class="badge bg-secondary">DEACTIVATED</span>';
        break;

        case '2':  
            $status =  '<span class="badge bg-primary">ON PROCESS</span>';
        break;

        case '3':  
            $status =  '<span class="badge bg-lime">APPROVED</span>';
        break;

        case '4':  
            $status =  '<span class="badge bg-purple">DISAPPROVED</span>';
        break;

        case '5':  
            $status =  '<span class="badge bg-olive">PENDING</span>';
        break;

        case '6':  
            $status =  '<span class="badge bg-warning">RETURNED</span>';
        break;

        default:
            $status =  '<span class="badge bg-black">UNDEFINED</span>';
        break;
    }

    return $status;
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
 * Echo selected in select option
 * @param string
 * @return string
 */
function select_helper($a, $b)
{
    if($a == $b){
        return 'selected';
    }
}

/**
 * Echo selected in select option
 * @param string
 * @return string
 */
function in_array_helper($a, $b)
{
    if(in_array($a, $b)){
        return 'selected';
    }
    
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
function name_helper($object, $arrangement = 'FMIL'){

    
    switch($arrangement){
    
        case 'LFMI':
            // checking if fname is available
            if($object['mname'] != ''){
                $name = $object['lname'].", ".$object['fname']." ".$object['mname'][0].".";
            }else{
                $name = $object['lname'].", ".$object['fname'];
            }

        break;

        case 'LFM':
            // checking if fname is available
            if($object['mname'] != ''){
                $name = $object['lname'].", ".$object['fname']." ".$object['mname'];
            }else{
                $name = $object['lname'].", ".$object['fname'];
            }
        break;

        case 'FMIL':  
            // checking if fname is available
            if($object['mname'] != ''){
                $name = $object['fname']." ".$object['mname'][0].". ".$object['lname'];
            }else{
                $name = $object['fname']." ".$object['lname'];
            }
        break;

        case 'FL': 
            $name = $object['fname']." ".$object['lname'];
        break;
    
        case 'FMNL':  
            // checking if fname is available
            if($object['mname'] != ''){
                $name = $object['fname']." ".$object['mname']." ".$object['lname'];
            }else{
                $name = $object['fname']." ".$object['lname'];
            }
        break;
        default:
            // checking if fname is available
            if($object['mname'] != ''){
                $name = $object['lname'].", ".$object['fname']." ".$object['mname'][0].".";
            }else{
                $name = $object['lname'].", ".$object['fname'];
            }
        break;

    }

    return $name;

}



/**
 * DOC TYPE HELPER
 * @param int
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



        
        default:
            // $type = 'undefined';
            $type = $int;
        break;
    }
    return $type;
}

/**
 * DOC TYPE HELPER
 * @param array
 * @return string
 */
function office_helper($array, $return = 'all'){

    if($array == null){
        return null;
    }

    if($array['name'] == 'MAIN'){
        if($array['office']['alias'] != ''){
            $office = "{$array['office']['name']} ({$array['office']['alias']})";
            $alias = "{$array['office']['alias']}";
        }else{
            $office = "{$array['office']['name']}";
            $alias = "{$array['office']['name']}";
        }

    }else{
        if($array['alias'] != ''){
            $office = "{$array['name']} ({$array['alias']})";
            $alias = "{$array['alias']}";
        }else{
            $office = "{$array['name']}";
            $alias = "{$array['name']}";
        }
    }

    if($return == 'all'){
        return $office;
    }else{
        return $alias;
    }  
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


function travel_order_helper($employees){

    $string = '';


    foreach($employees as $employee){
        $string .= name_helper($employee->employee->name, 'FMIL').", ";
    }


    return substr($string, 0, -2);

}



function employee_id_helper($string)
{
    if (strpos($string, '||') !== true) {
        return null;
    }

    $arr = explode('||', $string);
    return @$arr[1];
}






