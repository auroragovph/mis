<?php

/**
 *  Utility Helpers for Management Information System of Provincial Government of Aurora
 *
 *  @package        CodeIgniter
 *    @subpackage        Utility Helper
 *    @category        Helpers
 *    @author            JMPRNS@github
 *    @link            https://github.com/jmprns/fms
 */

if (!function_exists('employees')) {
    /**
     * Return the lists of all employees
     * @param array
     * @return collection
     */
    function employees($array)
    {

        $employees = \Modules\HumanResource\Entities\HR_Employee::query();

        if (in_array('liaison', $array)) {
            $employees->liaison();
        }

        return $employees->get();
    }
}

if (!function_exists('ucnames')) {
    /**
     * Convert names to strtolower then ucfirst
     * @param string $name
     * @return string $name
     */
    function ucnames($string)
    {
        $arrays = explode(' ', $string);

        $new = array_map(function ($value) {
            return ucfirst(strtolower($value));
        }, $arrays);

        return implode(' ', $new);
    }
}

if (!function_exists('name_mutate')) {
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

if (!function_exists('name_decode')) {
    /**
     * Decode the given name into array
     * @param string $name
     * @return array $final
     */
    function name_decode($name)
    {
        $final = array();

        // check first if DOT exists
        if (strpos($name, '.') !== false) {
            $explode        = explode('.', $name);
            $final['lname'] = name_mutate($explode[1]);
            $final['mname'] = name_mutate(substr($explode[0], -1));
            $final['fname'] = name_mutate(substr_replace($explode[0], '', -1));
        } else {

            $explode = explode(' ', $name);

            switch (count($explode)) {

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
                    $final['fname'] = name_mutate($explode[0] . " " . $explode[1]);
                    $final['mname'] = '';
                    $final['lname'] = name_mutate($explode[2] . " " . $explode[3]);
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

if (!function_exists('numwords')) {
    /**
     * Convert number to readable word
     */
    function numwords(mixed $number, string $currency = 'pesos'): string
    {
        $amount = explode('.', (string) $number);

        // return $amount;

        $whole_number = new NumberFormatter('ph', NumberFormatter::SPELLOUT);
        $whole        = $whole_number->format($amount[0]);

        $whole_plural = ((int) $amount[0] <= 1) ? 'peso' : 'pesos';

        $words = $whole . " " . $whole_plural;

        if (array_key_exists(1, $amount)) {

            $cent_value = (strlen($amount[1]) == 1) ? $amount[1] . "0" : $amount[1];

            $cent_number = new NumberFormatter('ph', NumberFormatter::SPELLOUT);
            $cent        = $cent_number->format($cent_value);

            $plural = ($cent_value > 1) ? 'centavos' : 'centavo';

            $words .= ' and ' . $cent . ' ' . $plural;
        }

        return $words;
    }
}

if (!function_exists('numonly')) {
    /**
     * Remove all the string in a string except for numbers
     */
    function numonly(string $string): int
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}

if (!function_exists('doc_match')) {
    /**
     * Checking if the document match with the correct type
     * @param string $doctype
     * @param string $type
     * @return void
     */
    function doc_match($doctype, $type)
    {

        if ($doctype != $type) {
            return abort(404);
        }
    }
}

if (!function_exists('series')) {
    /**
     * Convert series to document ID
     */
    function series(string $string)
    {
        $string = preg_replace('~\D~', '', $string);

        if (strlen($string) <= 8) {
            return $string;
        }

        return (int) substr($string, 8, 8);
    }
}

if (!function_exists('fts_series')) {
    /**
     * Convert FTS series to integer
     * @param string
     * @return string
     */
    function fts_series($string, $action = 'decode')
    {

        if ($action == 'encode') {
            $string = strtoupper($string);
            return (strpos($string, 'SR') == false) ? 'SR-' . str_pad($string, 11, '0', STR_PAD_LEFT) : $string;
        }

        return (int) preg_replace('/[^0-9]/', '', $string);
    }
}

if (!function_exists('fts_action_button')) {
    /**
     * Convert FTS series to integer
     * @param string
     * @return string
     */
    function fts_action_button($series, $edit = ['route' => '', 'id' => 0])
    {

        $action = '<div class="dropdown dropleft">
                        <button class="btn btn-default btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fal fa-cog"></i>  Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

        if ($edit['route'] != '') {
            if (authenticated()->can('fts.document.edit')) {
                $action .= '<a class="dropdown-item" href="' . route($edit['route'], $edit['id']) . '"> <i class="fal fa-edit"> </i> Edit</a>';
            }
        }

        if (authenticated()->can('fts.document.print')) {
            $action .= '<a class="dropdown-item" target="_blank" href="' . route('fts.documents.receipt', ['series' => $series, 'print' => 'true']) . '"><i class="fal fa-print"></i> Print</a>';
        }

        $action .= '<a class="dropdown-item" href="' . route('fts.documents.track', ['series' => $series]) . '"> <i class="fal fa-search"></i> Track</a>';

        $action .= '</div></div>';

        return $action;
    }
}

if (!function_exists('is_date')) {
    /**
     * Check if the string is date
     * @param string
     * @return bool
     */
    function is_date($string)
    {

        if (!$string) {
            return false;
        }

        try {
            return Carbon\Carbon::parse($string)->format('Y-m-d');
            // return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('doc_type_only')) {
    /**
     * DOC TYPE HELPER
     * @param int $int
     * @return string
     */
    function doc_type_only($int)
    {
        switch ($int) {

            case 101:
                $type = 'Purchase Request';
                break;

            case 102:
                $type = 'Purchase Order';
                break;

            case 104:
                $type = 'CAFOA <br> (Procurement)';
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

if (!function_exists('show_status')) {
    /**
     * Return color of the status in the show form
     * @param string
     * @return string
     */
    function show_status($status_id)
    {

        $status = document_status($status_id);
        $color  = document_status($status_id, 'label');
        return "<span class=\"badge bg-{$color}\">{$status}</span>";

        // return "<span class=\"badge badge-danger\">New</span>";
        // return "<span class=\"label label-light-{$color} label-inline font-weight-bold \">{$status}</span>";
    }
}


if (!function_exists('authenticated')) {
    /**
     * Return the current authenticated user
     */
    function authenticated()
    {
        // return auth()->user();
        return session()->get('authenticated');
    }
}

if (!function_exists('document_status')) {
    /**
     * Return color of the status in the show form
     * @param string
     * @return string
     */
    function document_status(int $status, $return = 'status')
    {
        switch ((int) $status) {

            case 0:
                $label  = 'danger';
                $status = 'Cancelled';
                break;

            case 1:
                $label  = 'warning';
                $status = 'Wating for Activation';
                break;

            case 2:
                $label  = 'primary';
                $status = 'On Process';
                break;

            case 3:
                $label  = 'success';
                $status = 'Approved';
                break;

            case 4:
                $label  = 'danger';
                $status = 'Disapproved';
                break;

            case 5:
                $label  = 'warning';
                $status = 'Pending';
                break;

            case 6:
                $label  = 'danger';
                $status = 'Returned';
                break;

            case 7:
                $label  = 'success';
                $status = 'For Withdrawal';
                break;

            case 8:
                $label  = 'primary';
                $status = 'Paid';
                break;

            default:
                $label  = 'secondary';
                $status = 'Undefined';
                break;
        }

        return ($return == 'status') ? $status : $label;
    }
}

if (!function_exists('transmittal_status')) {
    /**
     * Return color of the status in the show form
     * @param string
     * @return string
     */
    function transmittal_status($transmittal)
    {

        if ($transmittal->status == 1) {

            if ($transmittal->isExpired == true) {
                return '<span class="badge bg-danger">EXPIRED</span>';
            }
        }

        switch ($transmittal->status) {

            case '1':
                $status = '<span class="badge bg-primary">PENDING</span>';
                break;

            case '2':
                $status = '<span class="badge bg-success">RECEIVED</span>';
                break;

            case '3':
                $status = '<span class="badge bg-danger">EXPIRED</span>';
                break;

            default:
                $status = '<span class="badge bg-black">UNDEFINED</span>';
                break;
        }

        return $status;
    }
}

if (!function_exists('sh')) {
    /**
     * Echo selected in select option
     * @param string
     * @return string
     */
    function sh($a, $b, $type = 'selected')
    {
        if ($a == $b) {
            return $type;
        }
    }
}

if (!function_exists('dm_abort')) {
    /**
     * Check the parameters if match and return http response
     * @param string $a
     * @param string $b
     * @param int $code
     * @return void
     */

    function dm_abort($a, $b, $code = 404, $strict = true)
    {

        if ($strict == false && authenticated()->can('godmode')) {
            return true;
        }

        if ($a != $b) {
            return abort($code);
        }
    }
}

if (!function_exists('iah')) {
    /**
     * Echo selected in select option
     * @param string
     * @param array
     * @return string
     */
    function iah($a, $b)
    {
        if (in_array($a, $b)) {
            return 'selected';
        }
    }
}

if (!function_exists('auth_division')) {
    /**
     * Return authenticated employees division id
     * @return string
     */
    function auth_division()
    {
        return authenticated()->employee->division_id;
    }
}

if (!function_exists('tonh')) {
    /**
     * Return all the name of the emloyees in travel order
     * @param object
     * @return string
     */
    function tonh($employees)
    {

        $string = '';

        foreach ($employees as $employee) {
            $string .= name_helper($employee->name) . ", ";
        }

        return substr($string, 0, -2);
    }
}

if (!function_exists('employee_id_helper')) {
    /**
     * Get the employee ID from the QR Code
     * @param object
     * @return string
     */
    function employee_id_helper($string)
    {
        $string = strtoupper($string);

        if (strpos($string, 'PGA-JO-')) {
            $explode = explode('PGA-JO-', $string);
            return 'PGA-JO-' . numonly($explode[1]);
        }

        if (strpos($string, 'PGA-C-')) {
            $explode = explode('PGA-C-', $string);
            return 'PGA-C-' . numonly($explode[1]);
        }

        if (strpos($string, 'PGA-P-')) {
            $explode = explode('PGA-P-', $string);
            return 'PGA-P-' . numonly($explode[1]);
        }

        return $string;
    }
}

if (!function_exists('office_helper')) {
    /**
     * DOC TYPE HELPER
     * @param array
     * @param string
     * @return string
     */
    function office_helper($array, $return = 'all')
    {

        if ($array == null) {
            return null;
        }

        $office   = $array['office'];
        $division = ['name' => $array['name'], 'alias' => $array['alias']];

        // check if the division is the main office .... return the office name
        if ($division['name'] == 'MAIN') {
            return ($office['alias'] == null) ? $office['name'] : "{$office['name']} ({$office['alias']})";
        } else {
            // if not the main return the division name with office alias

            // check if the office name is null
            $off = ($office['alias'] == null) ? '' : "{$office['alias']} - ";
            return ($division['alias'] == null) ? "{$off} {$division['name']}" : "{$off} {$division['name']} ({$division['alias']})";
        }
    }
}

if (!function_exists('office_name')) {
    /**
     * Get the office name with it's alias.
     */
    function office_name(\Modules\System\Entities\Office\Office $office): string
    {
        return ($office->alias == null) ? $office->name : $office->name . " (" . $office->alias . ") ";
    }
}

if (!function_exists('hrefroute')) {
    /**
     * Hyperlink to route show helper
     * @param int $id
     * @param string $route
     * @return string
     */
    function hrefroute($id, $route, $size = 'xs', $color = 'primary', $icon = 'eye', $verb = 'View')
    {

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

if (!function_exists('user_agent')) {
    /**
     * Return the user agent
     * @return array
     */
    function user_agent()
    {
        $agent = new Jenssegers\Agent\Agent();

        return [
            'ip'       => request()->getClientIp(),
            'browser'  => $agent->browser(),
            'device'   => $agent->device(),
            'platform' => $agent->platform(),
            'request'  => request(),
        ];

    }
}

if (!function_exists('name_to_username')) {
    /**
     * Convert name to username
     * @return array
     */
    function name_to_username($fname, $lname)
    {
        // return str_replace(' ', '_', strtolower($fname." ".$lname))."_".mt_rand(1,999);
        return str_replace(' ', '_', strtolower($fname . " " . $lname));
    }
}

if (!function_exists('menu_helper')) {
    /**
     * Convert name to username
     * @return array
     */
    function menu_helper($string)
    {
        $current_url = request()->url();
        $menu_url    = request()->getSchemeAndHttpHost() . "/" . $string;
        return (strpos($current_url, $menu_url) === false) ? '' : 'menu-item-here';
    }
}

if (!function_exists('qr_to_base64')) {
    /**
     * Convert name to username
     * @return array
     */
    function qr_to_base64($string, $code_only = false)
    {
        $format = (extension_loaded('imagick')) ? 'png' : 'svg';
        $qr     = \SimpleSoftwareIO\QrCode\Facades\QrCode::format($format)
            ->size(50)
            ->margin(1.5)
            ->generate($string);

        $base64 = base64_encode($qr);

        if ($code_only) {
            return $base64;
        }

        if ($format == 'png') {
            return 'data:image/png;base64,' . $base64;
        }

        return 'data:image/svg+xml;base64,' . $base64;

    }
}

if (!function_exists('pretty_number')) {
    /**
     * Convert number to pretty
     * @param string
     * @return string
     */
    function pretty_number($string, $trail = true)
    {
        return number_format(floatval($string), ($trail) ? 2 : 0);
    }
}

if (!function_exists('link_back')) {
    /**
     * Return the referer url
     * @return array
     */
    function link_back($route = '#')
    {
        $referer = request()->headers->get('referer');
        return ($referer == null) ? $route : $referer;
    }
}

if (!function_exists('activitylog')) {
    /**
     * Insert activity logs
     * @param array
     * @return object
     */
    function activitylog($array)
    {
        $name       = $array['name'] ?? 'sys';
        $log        = $array['log'] ?? '';
        $properties = $array['props'] ?? null;

        $log = \Modules\System\Entities\ActivityLog::create([
            'name'        => $name,
            'log'         => $log,
            'properties'  => $properties,
            // 'employee_id' => authenticated()->employee_id,
            'employee_id' => auth()->user()->employee_id,
            'agent'       => user_agent(),
        ]);

        return $log;
    }
}

if (!function_exists('arrdif')) {
    /**
     * Insert activity logs
     * @param array
     * @return object
     */
    function arrdif($old, $new)
    {

        $changes = array();

        foreach ($old as $key => $value) {

            if (is_array($value)) {
                $changes[$key] = arrdif($value, $new[$key]);
            } else {

                if ($value != $new[$key]) {

                    $changes[$key] = [
                        'old' => $old[$key],
                        'new' => $new[$key],
                    ];
                }
            }
        }

        return $changes;
    }
}

if (!function_exists('convert_bytes')) {
    /**
     * Converto bytes in readable size
     * @param string
     * @return string
     */

    function convert_bytes($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}

if (!function_exists('session_attached_form')) {
    /**
     * Setting session for the attached document
     */

    function session_attached_form(): bool
    {
        if (request()->has('attachment') and request()->get('attachment') == true) {
            $doc_id   = request()->get('document_id');
            $document = \Modules\FileManagement\Entities\Document\Document::findOrFail($doc_id);
            if ($document->qr != request()->get('qrcode')) {
                return abort(404);
            }

            session(['fms.document.attach' => (int) $doc_id]);
            return true;

        }

        return false;

    }
}

if (!function_exists('get_instance_class_type')) {
    /**
     * Convert name to username
     * @return array
     */
    function get_instance_class_type($form)
    {
        switch (get_class($form)) {

            case \App\Models\Form\Afl::class:
                return 'Application For Leave';
                break;

            case \App\Models\Form\Dv::class:
                return 'Disbursement Voucher';
                break;

            case \App\Models\Form\Cafoa::class:
                return 'CAFOA';
                break;

            case \App\Models\Form\Itinerary::class:
                return 'Itinerary of Travel';
                break;

            case \App\Models\Form\Payroll::class:
                return 'Payroll';
                break;

            case \App\Models\Form\Pr::class:
                return 'Purchase Request';
                break;

            case \App\Models\Form\To::class;
                return 'Travel Order';
                break;

            case \App\Models\Form\Liquidation::class;
                return 'Liquidation Report';
                break;

        }
    }
}

if (!function_exists('actlog')) {
    /**
     * Add logs to the system
     * @param string $name
     * @param string|null $log
     * @param array $props
     * @return object
     */
    function actlog(string $name = 'sys', $log = null, ?array $props = null): object
    {
        return activitylog([
            'name'  => $name,
            'log'   => $log,
            'props' => $props,
        ]);
    }
}

if (!function_exists('message_box')) {

    /**
     * Get the message box
     */
    function message_box(string $key): string
    {
        $file    = include app_path('Helpers/messagebox.php');
        $message = \Illuminate\Support\Arr::get($file, $key);

        if (is_array($message)) {
            return '';
        }

        return $message;
    }
}

if (!function_exists('name')) {
    /**
     * Name Helper
     */
    function name(array $name, string $arrangement = 'FMIL'): string
    {
        if ($name == null) {
            return null;
        }

        $name = (array) $name;

        $fname = (array_key_exists('first', $name)) ? ucfirst($name['first']) : "";
        $lname = (array_key_exists('last', $name)) ? ucfirst($name['last']) : "";
        $mname = (array_key_exists('middle', $name)) ? ucfirst($name['middle']) : "";

        // $fname = @$name['fname'];
        // $mname = @$name['mname'];
        // $lname = @$name['lname'];

        switch ($arrangement) {

            case 'LFMI':
                $name = $lname . ", " . $fname . " " . @$mname[0] . ".";
                break;

            case 'LFM':
                $name = $lname . ", " . $fname . " " . $mname;
                break;

            case 'FMIL':
                $name = $fname . " " . @$mname[0] . ". " . $lname;
                break;

            case 'FL':
                $name = $fname . " " . $lname;
                break;

            case 'FMNL':
                $name = $fname . " " . $mname . " " . $lname;
                break;

            case 'SYM-F':
                $name = strtoupper($fname[0]);
                break;

            case 'SYM-FL':
                $name = strtoupper($fname[0] . $lname[0]);
                break;

            default:
                $name = '';
                break;
        }

        return $name;
    }
}

if (!function_exists('checkbox_svg')) {
    /**
     * Converto bytes in readable size
     * @param string
     * @return string
     */

    function checkbox_svg($width = '100px', $height = '100px', $type = 'checked')
    {
        if ($type == 'checked') {
            return '
                <svg height="' . $height . '" viewBox="0 0 512 512" width="' . $width . '" xmlns="http://www.w3.org/2000/svg">
                    <path d="m452
                            512h-392c-33.085938
                            0-60-26.914062-60-60v-392c0-33.085938
                            26.914062-60 60-60h392c33.085938
                            0
                            60
                            26.914062
                            60
                            60v392c0
                            33.085938-26.914062
                            60-60
                            60zm-392-472c-11.027344
                            0-20
                            8.972656-20
                            20v392c0
                            11.027344
                            8.972656
                            20
                            20
                            20h392c11.027344
                            0
                            20-8.972656
                            20-20v-392c0-11.027344-8.972656-20-20-20zm370.898438
                            111.34375-29.800782-26.6875-184.964844
                            206.566406-107.351562-102.046875-27.558594
                            28.988281 137.21875
                            130.445313zm0
                            0"/>
                    </svg>
            ';
        } else {
            return '
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="' . $width . '" height="' . $height . '" viewBox="0 0 401.998 401.998" style="enable-background:new 0 0 401.998 401.998;"
                        xml:space="preserve">
                <g>
                    <path d="M377.87,24.126C361.786,8.042,342.417,0,319.769,0H82.227C59.579,0,40.211,8.042,24.125,24.126
                        C8.044,40.212,0.002,59.576,0.002,82.228v237.543c0,22.647,8.042,42.014,24.123,58.101c16.086,16.085,35.454,24.127,58.102,24.127
                        h237.542c22.648,0,42.011-8.042,58.102-24.127c16.085-16.087,24.126-35.453,24.126-58.101V82.228
                        C401.993,59.58,393.951,40.212,377.87,24.126z M365.448,319.771c0,12.559-4.47,23.314-13.415,32.264
                        c-8.945,8.945-19.698,13.411-32.265,13.411H82.227c-12.563,0-23.317-4.466-32.264-13.411c-8.945-8.949-13.418-19.705-13.418-32.264
                        V82.228c0-12.562,4.473-23.316,13.418-32.264c8.947-8.946,19.701-13.418,32.264-13.418h237.542
                        c12.566,0,23.319,4.473,32.265,13.418c8.945,8.947,13.415,19.701,13.415,32.264V319.771L365.448,319.771z"/>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
            </svg>
            ';
        }
    }
}

function tracking_table_status($status)
{
    switch ($status) {
        case '0':
            $status = '<span class="btn-danger ">CANCELLED</span>';
            break;

        case '1':
            $status = '<span class="btn-warning ">DEACTIVATED</span>';
            break;

        case '2':
            $status = '<span class="btn-primary ">ON PROCESS</span>';
            break;

        case '3':
            $status = '<span class="btn-success ">APPROVED</span>';
            break;

        case '4':
            $status = '<span class="btn-danger ">DISAPPROVED</span>';
            break;

        case '5':
            $status = '<span class="btn-info ">PENDING</span>';
            break;

        case '6':
            $status = '<span class="btn-warning ">RETURNED</span>';
            break;

        case '7':
            $status = '<span class="bg-olive">FOR WITHDRAWAL</span>';
            break;

        case '8':
            $status = '<span class="bg-lime">PAID</span>';
            break;

        default:
            $status = '<span class="btn-inverse ">UNDEFINED</span>';
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

    foreach ($attachments as $attachment) {
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

    foreach ($datas as $data) {

        if (!in_array($data[$delimeter], $array)) {
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
function in_array_any($needles, $haystack)
{
    return (bool) array_intersect($needles, $haystack);
}

/**
 * LEAVE HELPER
 * @param int
 * @return string
 */
function leave_helper($type)
{

    switch ((int) $type) {
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
function print_text_helper($string)
{

    $length = strlen($string);

    // $formatted = '14px';

    if ($length <= 15) {
        $formatted = '13px';
    }

    if ($length > 15 && $length <= 40) {
        $formatted = '12px';
    }

    if ($length >= 41) {
        $formatted = '10px';
    }

    return $formatted;
}

/**
 * Padding Helper
 * @param int
 * @return string
 */
function padding_helper($string, $length, $pad = STR_PAD_BOTH)
{

    $string = str_pad($string, $length, '*', $pad);
    $string = str_replace("*", "&nbsp;", $string);

    return $string;
}

/**
 * Name Helper
 * @param array
 * @return string
 */
function name_helper($name, $arrangement = 'FMIL')
{
    if ($name == null) {
        return null;
    }

    $name = (array) $name;

    $fname = (array_key_exists('first', $name)) ? ucfirst($name['first']) : "";
    $lname = (array_key_exists('last', $name)) ? ucfirst($name['last']) : "";
    $mname = (array_key_exists('middle', $name)) ? ucfirst($name['middle']) : "";

    // $fname = @$name['fname'];
    // $mname = @$name['mname'];
    // $lname = @$name['lname'];

    switch ($arrangement) {

        case 'LFMI':
            $name = $lname . ", " . $fname . " " . @$mname[0] . ".";
            break;

        case 'LFM':
            $name = $lname . ", " . $fname . " " . $mname;
            break;

        case 'FMIL':
            $name = $fname . " " . @$mname[0] . ". " . $lname;
            break;

        case 'FL':
            $name = $fname . " " . $lname;
            break;

        case 'FMNL':
            $name = $fname . " " . $mname . " " . $lname;
            break;

        case 'SYM-F':
            $name = strtoupper($fname[0]);
            break;

        case 'SYM-FL':
            $name = strtoupper($fname[0] . $lname[0]);
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
function office_alias_helper($array)
{

    if ($array->name == 'MAIN') {
        if ($array->office->alias != '') {
            $office = "{$array->office->alias}";
        } else {
            $office = "{$array->office->name}";
        }
    } else {
        if ($array->alias != '') {
            $office = "{$array->alias}";
        } else {
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
function employment_helper($type)
{
    switch ($type) {
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
    switch ($act) {
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
function get_date_diff($time1, $time2, $precision = 3)
{
    // If not numeric then convert timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }
    // If time1 > time2 then swap the 2 values
    if ($time1 > $time2) {
        list($time1, $time2) = array($time2, $time1);
    }
    // Set up intervals and diffs arrays
    $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
    $diffs     = array();
    foreach ($intervals as $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add    = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }
        $time1            = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$interval] = $looped;
    }
    $count = 0;
    $times = array();
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval if value is bigger than 0
        if ($value > 0) {
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }
    // Return string with times
    return implode(", ", $times);
}

/**
 * Permission helper
 * @param array
 * @return boolean
 */

function permission_helper($array = '', $strict = false)
{

    // Return true if the user is a ROOT user
    if ($_SESSION['role']['description'] == 'Root User' || $_SESSION['role']['id'] == 1) {
        return true;
    }

    $count       = 0;
    $permissions = $_SESSION['permissions'];

    if (!is_array($array)) {
        $array = [$array];
    }

    foreach ($array as $permission) {
        if (in_array($permission, $permissions)) {
            $count++;
        }
    }

    if ($strict == false) {

        if ($count != 0) {
            return true;
        }

        return false;
    }

    if (empty($array) || $count < count($array)) {
        return false;
    }

    return true;
}
