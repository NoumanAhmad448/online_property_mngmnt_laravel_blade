<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\VerifyUser;
use App\Helpers\FileUpload;
use App\Http\Requests\MyProfilePatch;
use App\Models\CreateLand;
use App\Models\LandFile;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserController extends Controller {
    private $createLandObj;

    private $landFileObj;

    private $fileUplaodObj;

    private $user;

    private $verifyUser;

    private $createLand;

    private $createNewUser;

    public function __construct() {
        $this->createLandObj = new CreateLand;
        $this->user = new User;
        $this->landFileObj = new LandFile;
        $this->fileUplaodObj = new FileUpload;
        $this->verifyUser = new VerifyUser;
        $this->createLand = new CreateLand;
        $this->createNewUser = new CreateNewUser;
    }

    public function myProfilePatch(MyProfilePatch $request) {
        try {
            $request->validated();
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->save();
            debug_logs($user);
            UserProfile::saveInsertProfile($request->all());

            return customResponse(
                [
                    config('setting.is_success') => true,
                    config('setting.message') => __('messages.oprntn_succ'),
                ],
                config('setting.status_200')
            );
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function myProfile(Request $request) {
        try {
            $data = [];
            if ($request->has('id')) {
                $user = User::findOrFail($request->get('id'));
            } else {
                $user = auth()?->user();
            }
            debug_logs($user?->userProfile);
            debug_logs($user?->userProfile?->job);
            $data[config('vars.user')] = $user;
            $data[config('vars.title')] = __('messages.mprofile');
            debug_logs('data => ');

            return view(config('setting.my_prfle'), compact(config('vars.data')));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function showUsers(Request $request) {
        try {
            $data = [];
            $users = $this->user::normalUserCond(true)->get();
            $data['users'] = $users;
            $data['title'] = __('messages.Users');

            return view(config('setting.show_users'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function setting(Request $request) {
        try {
            $data = [];
            $data[config('vars.title')] = __('messages.settings');

            return view(config('setting.setting_lay'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }
}
