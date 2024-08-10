<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\VerifyUser;
use App\Helpers\FileUpload;
use App\Http\Requests\AdminLogin;
use App\Models\CreateLand;
use App\Models\LandFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class Admin extends Controller {
    private $createLandObj;

    private $landFileObj;

    private $fileUplaodObj;

    private $user;

    private $verifyUser;

    private $createLand;

    public function __construct() {
        $this->createLandObj = new CreateLand;
        $this->user = new User;
        $this->landFileObj = new LandFile;
        $this->fileUplaodObj = new FileUpload;
        $this->verifyUser = new VerifyUser;
        $this->createLand = new CreateLand;
    }

    public function clearCache() {
        Artisan::call('config:cache');

        return customResponse([config('setting.is_success') => true,
            config('setting.message') => __('messages.admn_del_op')],
            config('setting.status_200'));
    }

    public function optimize() {
        Artisan::call('optimize');

        return customResponse([config('setting.is_success') => true,
            config('setting.message') => __('messages.admn_del_op')],
            config('setting.status_200'));
    }

    public function clearFiles() {
        Artisan::call('files:clear');

        return customResponse([config('setting.is_success') => true,
            config('setting.message') => __('messages.admn_del_op')],
            config('setting.status_200'));
    }

    public function adminOp(Request $request) {
        try {
            $data = [];
            $data[config('vars.title')] = __('messages.admin_op');
            debug_logs('data => ');
            debug_logs($data);

            return view(config('setting.admn_oprtn'), compact(config('vars.data')));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function clearLogs(Request $request) {
        $duration = $request->query('duration');
        debug_logs($duration);
        $duration = $duration ?? '';
        Artisan::call("log:clear {$duration}");

        return customResponse([config('setting.is_success') => true,
            config('setting.message') => __('messages.admn_del_op')],
            config('setting.status_200'));
    }

    public function login(Request $request) {
        try {
            $user = auth()->user();
            if ($user && ($user->is_super_admin || $user->is_admin)) {
                return redirect()->route('admin_chart');
            } elseif ($user) {
                return redirect()->route('index');
            }

            return view(config('setting.admin_login'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function logout(Request $request) {
        try {
            if ($this->verifyUser->logout($request)) {
                return redirect()->route('admin_login', [], config('setting.err_301'));
            } else {
                return redirect()->route('index', [], config('setting.err_301'));
            }
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }

    }

    public function adminLogin(AdminLogin $request) {
        try {
            $request->validated();
            $user = $this->verifyUser->verifyUser($request->all(), true);
            if (! $user) {
                return customResponse([config('setting.error') => __('messages.login_failed')],
                    config('setting.err_422'));
            }
            $request->session()->regenerate();
            Auth::login($user);

            return customResponse([config('setting.is_success') => true,
                config('setting.message') => __('messages.logged_in')], config('setting.status_200'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function chart(Request $request) {
        try {
            $data = [];
            $users = User::normalUserCond(true);
            $users = $users->count();
            debug_logs('users => '.$users);
            $data[config('vars.users')] = $users;

            $active_users = User::normalUserCond();
            $active_users = $active_users->count();
            debug_logs('active_users => '.$active_users);
            $data[config('vars.active_users')] = $active_users;

            $admins = User::adminCond(true);
            $admins = $admins->count();
            debug_logs('admins => '.$admins);
            $data[config('vars.admins')] = $admins;

            $active_admins = User::adminCond();
            $active_admins = $active_admins->count();
            debug_logs('active_admins => '.$active_admins);
            $data[config('vars.active_admins')] = $active_admins;

            $lands = CreateLand::count();
            $data[config('vars.lands')] = $lands;
            debug_logs('users => '.$users);

            $data[config('vars.title')] = __('messages.summary');

            return view(config('setting.admin_chart'), compact(config('vars.data')));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function lands(Request $request) {
        try {
            $data = [];
            $users = $this->user->getIds();
            $lands = $this->createLand->landDetails($users);

            $data[config('table.lands')] = $lands;
            $data[config('table.title')] = __('messages.lands');

            return view(config('setting.admin_lands'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }
}
