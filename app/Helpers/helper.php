<?php

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

if (! function_exists('check_input')) {
    function check_input($u_input) {
        return htmlspecialchars(trim(stripslashes($u_input)));
    }
}

if (! function_exists('is_xss')) {
    function is_xss($u_input) {
        return strip_tags($u_input) !== $u_input;
    }
}

if (! function_exists('reduceCharIfAv')) {
    // reduce character in string if there is any available
    function reduceCharIfAv($u_input, $limit) {
        return strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input, $limit) : $u_input;
    }
}

if (! function_exists('reduceWithStripping')) {
    function reduceWithStripping($u_input, $limit) {
        $u_input = strip_tags($u_input);

        return strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input, $limit) : $u_input;
    }
}

if (! function_exists('removeSpace')) {
    function removeSpace($input) {
        if (is_string($input)) {
            return trim($input);
        }

        return $input;
    }
}

if (! function_exists('isAdmin')) {
    function isAdmin($action = true) {
        if ($action) {
            $action = abort(403);
        }
        $auth = Auth::user();

        return $auth && ($auth->is_admin | $auth->is_super_admin) ?? $action;
    }
}
if (! function_exists('isSuperAdmin')) {
    /**
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     **/
    function isSuperAdmin(bool $action = true) {
        if ($action) {
            $action = abort(403);
        }
        $auth = Auth::user();

        return $auth && ($auth->is_super_admin) ?? $action;
    }
}
if (! function_exists('isNotSuperAdmin')) {
    /**
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     **/
    function isNotSuperAdmin(bool $action = false) {
        return ! isSuperAdmin($action);
    }
}

if (! function_exists('showLessText')) {
    function showLessText($text, $len) {
        if (strlen($text) > $len) {
            return substr($text, $len);
        }

        return $text;
    }
}

if (! function_exists('dateFormat')) {

    function dateFormat($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
if (! function_exists('php_config')) {

    function php_config() {
        if (config('app.debug')) {
            dump('memory_limit =>'.ini_get('memory_limit'));
            dump(config('setting.dash_lines'));
            dump('upload_max_filesize =>'.ini_get('upload_max_filesize'));
            dump(config('setting.dash_lines'));
        }
        ini_set('memory_limit', '8096M');
        ini_set('upload_max_filesize', '2000M');
    }
}
if (! function_exists('server_logs')) {
    function server_logs($e = [], $request = [], $config = false, $response_status = '',
        $return_response = true) {
        if (empty($response_status)) {
            $response_status = config('setting.err_500');
        }
        if (config('app.debug')) {
            if (count($e) > 1 && $e[0]) {
                dump($e[1]->getMessage());
                dump(config('setting.dash_lines'));
            }
            if (count($request) > 1 && $request[0]) {
                dump($request[1]->all());
                dump(config('setting.dash_lines'));
            }
            if ($config) {
                dump('memory_limit'.ini_get('memory_limit'));
                dump(config('setting.dash_lines'));
                dump('upload_max_filesize=>'.ini_get('upload_max_filesize'));
                dump(config('setting.dash_lines'));
            }
        } elseif ($return_response) {
            return customResponse([config('setting.error') => __('messages.err_msg')], $response_status);
        }
    }
}

if (! function_exists('includeErr')) {
    function includeErr($data) {
        /*
        include error key if there is no success and error key exist however message
        entity must exist
        */
        if (is_key_not_exists(config('setting.is_success'), $data) &&
            is_key_not_exists(config('setting.error'), $data) &&
            is_key_exists(config('setting.message'), $data)
        ) {
            $data[config('setting.error')] = __('messages.err_msg');
        }

        return $data;
    }
}
if (! function_exists('customResponse')) {
    function customResponse($data, $status = '') {
        if (empty($status)) {
            $status = config('setting.status_200');
        }

        $data = includeErr($data);

        return response()->json($data, $status);
    }
}
if (! function_exists('failValidation')) {
    function failValidation($validator): void {
        try {
            $errors = $validator->errors();
        } catch (AccessDeniedHttpException $e) {
            $errors = config('setting.ad');
            if (config('app.debug')) {
                dump($validator->errors());
            }
        }

        $errors = includeErr($errors);

        throw new HttpResponseException(customResponse([config('setting.error') => $errors],
            config('setting.err_422'),
        ));
    }
}

if (! function_exists('is_key_exists')) {
    function is_key_exists($key, $array): bool {
        return isArray($array) && array_key_exists($key, $array);
    }
}
if (! function_exists('is_key_not_exists')) {
    function is_key_not_exists($key, $array): bool {
        return ! is_key_exists($key, $array);
    }
}

if (! function_exists('debug_logs')) {
    function debug_logs($input): void {
        if (config('app.debug')) {
            dump($input);
            dump(config('setting.dash_lines'));
        }
    }
}

if (! function_exists('add_key_if_exist')) {
    function add_key_if_exist($key, $array, $new_data = []) {
        // add the data in the array and returns
        debug_logs($key);
        debug_logs($array);
        debug_logs($new_data);
        if (is_key_exists($key, $array) && $array[$key]) {
            $new_data[$key] = $array[$key];
        }

        return $new_data;
    }
}

if (! function_exists('isArray')) {
    function isArray($array): bool {
        return is_array($array);
    }
}
if (! function_exists('isNotArray')) {
    function isNotArray($array): bool {
        return ! is_array($array);
    }
}

if (! function_exists('fromMailer')) {
    function fromMailer($mailer): string {
        $from = config("mail.mailers.{$mailer}.from");

        return $from;
    }
}

if (! function_exists('gen_str')) {
    function gen_str($uuid = false, $limit = 8): string {
        if ($uuid) {
            return (string) Str::uuid();
        } else {
            return 'd'.substr(sha1(time()), 0, $limit);
        }
    }
}
if (! function_exists('is_normal_user')) {
    function is_normal_user(): bool {
        /*
        every unregisterd user and non admin is a normal user
        */
        return ! isAdmin(false);
    }
}
if (! function_exists('is_auth_user')) {
    function is_auth_user($action = false): bool {
        /*
        every registerd user and admin(excluding super admin) is a auth user
        */
        if ($action) {
            $action = abort(config('setting.err_403'));
        }
        $auth = Auth::user();
        if (! $auth) {
            return false;
        }

        return $auth && ! $auth->is_super_admin ?? $action;
    }
}
if (! function_exists('str_to_array')) {
    function str_to_array($str, $sep = ','): array {
        return explode($sep, $str);
    }
}
if (! function_exists('add_array')) {
    function add_array($main_array, $given_array) {
        return array_push($main_array, $given_array);
    }
}
if (! function_exists('file_path')) {
    function file_path($path, $disk = '') {
        if (empty($disk)) {
            $site_path = config('app.url');
            $server_path = config('setting.storage');

            return $site_path.$server_path.$path;
        }
    }
}
if (! function_exists('can_call_fun')) {
    function can_call_fun($fun) {
        return is_callable($fun);
    }
}
