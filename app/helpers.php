<?php

if (!function_exists('authenticated')) {
    /**
     * Return specific details for authencated user
     */
    function authenticated($details)
    {
        $user = auth()->user();

        return match($details) {
            'division_id'   => $user->employee->division_id,
            'employee_id'   => $user->employee_id,
            'name'          => $user->employee->name,
            'username'      => strtolower($user->username),
            'image'         => $user->employee->info['image'],
            'position'      => $user->employee->position->name,
            default         => null
        };
    }
}

if (!function_exists('name')) {
    /**
     * Convert the JSON object of name into readable name
     */
    function name(
        ?array $name_object = null,
        string $arrangement = 'FMIL',
        ?string $first = null,
        ?string $last = null,
        ?string $middle = null,
        ?string $suffix = null,
    ): ?string {

        // dd(empty($name_object));

        if ($name_object !== null) {
            $first  = (is_null($first)) ? $name_object['first'] : $first;
            $last   = (is_null($last)) ? $name_object['last'] : $last;
            $middle = (is_null($middle)) ? $name_object['middle'] : $middle;
        }

        $middle_initials = substr($middle, 0, 1);

        $name = match($arrangement) {
            'LFMI' => "{$last}, {$first} {$middle_initials}",
            'LFMN' => "{$last}, {$first} {$middle}",
            'FMIL' => "{$first} {$middle_initials}. $last",
            'FL' => "{$first} {$last}",
            'FMNL' => "{$first} {$middle} {$last}",
            'SYM-F' => strtoupper(@$first[0]),
            'SYM-FL' => substr($first, 0, 1) . substr($last, 0, 1),
        default=> ''
        };

        return $name;
    }
}

if (!function_exists('sh')) {
    /**
     * Echo selected in select option if the parameters matched
     */
    function sh(mixed $a, mixed $b, string $type = 'selected'): string
    {
        return ($a == $b) ? $type : '';
    }
}

if (!function_exists('office')) {
    /**
     * Mutate the office object and determine the office name
     */
    function office(array | object | null $array, string $return = 'all'): ?string
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

if (!function_exists('number_only')) {
    /**
     * Remove all the string in a string except for numbers
     */
    function number_only(string $string): int
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}

if (!function_exists('employee_id')) {
    /**
     * Get the employee ID from the QR Code
     */
    function employee_id(string $string)
    {
        $string = strtoupper($string);

        if (strpos($string, 'PGA-JO-')) {
            $explode = explode('PGA-JO-', $string);
            return 'PGA-JO-' . number_only($explode[1]);
        }

        if (strpos($string, 'PGA-C-')) {
            $explode = explode('PGA-C-', $string);
            return 'PGA-C-' . number_only($explode[1]);
        }

        if (strpos($string, 'PGA-P-')) {
            $explode = explode('PGA-P-', $string);
            return 'PGA-P-' . number_only($explode[1]);
        }

        return $string;
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

if (!function_exists('user_agent')) {
    /**
     * Return the user agent
     */
    function user_agent(): array
    {
        $agent = new Jenssegers\Agent\Agent();

        return [
            'ip'       => request()->getClientIp(),
            'browser'  => $agent->browser(),
            'device'   => $agent->device(),
            'platform' => $agent->platform(),
            'payload'  => request(),
        ];

    }
}

if (!function_exists('activitylog')) {
    /**
     * Insert activity logs
     */
    function activitylog(string $name = 'sys', ?string $log = null, ?array $props = null): \App\Models\System\ActivityLog
    {

        $log = \App\Models\System\ActivityLog::create([
            'name'        => $name,
            'log'         => $log,
            'properties'  => $props,
            // 'employee_id' => authenticated()->employee_id,
            'employee_id' => authenticated('employee_id'),
            'agent'       => user_agent(),
        ]);

        return $log;
    }
}

if (!function_exists('get_date_diff')) {

    /**
     * DATE DIFFERENCE
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
}

if (!function_exists('random_color')) {

    /**
     * Return random colors of twitter bootrap
     */

    function random_color(): string
    {
        $selections = [
            'primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark',
            'blue', 'azure', 'indigo', 'purple', 'pink', 'red', 'orange', 'yellow', 'lime', 'green', 'teal', 'cyan',
        ];
        return \Illuminate\Support\Arr::random($selections);
    }

}
