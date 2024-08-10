<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\VerifyUser;
use Illuminate\Http\Request;

class HomeController extends Controller {
    private $verifyUser;

    private $user;

    public function __construct() {
        $this->verifyUser = new VerifyUser;
        $this->user = auth()->user();
    }

    public function index() {
        try {
            $response = $this->indexApi();
            $data = [];
            $features = [
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features1'), 'title_desc' => __('messages.features1_desc')],
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features2'), 'title_desc' => __('messages.features2_desc')],
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features3'), 'title_desc' => __('messages.features3_desc')],
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features4'), 'title_desc' => __('messages.features4_desc')],
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features5'), 'title_desc' => __('messages.features5_desc')],
                ['img' => url(config('setting.im_event')), 'alt' => __('messages.event'), 'title' => __('messages.features6'), 'title_desc' => __('messages.features6_desc')],
            ];

            $data['features'] = $features;

            return view(config('setting.welcome'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [false, ''], $config = true);
        }
    }

    public function indexApi() {
        try {
            return customResponse([config('setting.is_success') => true, 'data' => '']);
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [false, ''], $config = true);
        }
    }

    public function logout(Request $request) {
        try {
            $this->verifyUser->logout($request);

            return redirect()->route('index');
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function login(Request $request) {
        try {
            if ($this->user) {
                if (isAdmin(false)) {
                    return redirect()->route('admin_login', [], config('setting.err_301'));
                }

                return redirect()->route('index', [], config('setting.err_301'));
            }

            return view('login');
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function myProfile(Request $request) {
        dd('here');
    }
}
