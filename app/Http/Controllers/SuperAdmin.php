<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\VerifyUser;
use App\Helpers\FileUpload;
use App\Http\Requests\SubAdminsDelete;
use App\Http\Requests\SubAdminsPost;
use App\Http\Requests\SubAdminsUpdate;
use App\Models\CreateLand;
use App\Models\CreateLandLog;
use App\Models\LandComments;
use App\Models\LandFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SuperAdmin extends Controller {
    private $createLandObj;

    private $landFileObj;

    private $fileUplaodObj;

    private $user;

    private $verifyUser;

    private $createLand;

    private $createNewUser;

    private $createLandLog;

    private $landComments;

    public function __construct() {
        $this->createLandObj = new CreateLand;
        $this->user = new User;
        $this->landFileObj = new LandFile;
        $this->fileUplaodObj = new FileUpload;
        $this->verifyUser = new VerifyUser;
        $this->createLand = new CreateLand;
        $this->createLandLog = new CreateLandLog;
        $this->landComments = new LandComments;
        $this->createNewUser = new CreateNewUser;

    }

    public function subAdmin(Request $request) {
        try {
            $data = [];
            $users = $this->user->getAdmins();
            $data['users'] = $users;
            $data['title'] = __('messages.ap');

            return view(config('setting.sub_admins'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function DelsubAdmin(SubAdminsDelete $request) {
        try {
            $request->validated();
            $this->user->delAdmins($request->id);

            return customResponse([
                config('setting.is_success') => true,
                config('setting.message') => __('messages.admn_del_op')],
                config('setting.status_200')
            );
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function CreatesubAdmin(SubAdminsPost $request) {
        try {
            $request->validated();
            $this->createNewUser->createUser($request->all());

            return customResponse([
                config('setting.is_success') => true,
                config('setting.message') => __('messages.admn_del_op')],
                config('setting.status_200')
            );
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function UpdatesubAdmin(SubAdminsUpdate $request) {
        try {
            $request->validated();
            debug_logs($this->user->passChange($request->id, $request->password));

            return customResponse([
                config('setting.is_success') => true,
                config('setting.message') => __('messages.del_op')],
                config('setting.status_200')
            );
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function landLogs(Request $request) {
        try {
            $data = [];
            if ($request->has(config('table.primary_key'))) {
                $land_id = $request->get(config('table.primary_key'));
            } else {
                abort(config('setting.err_403'));
            }
            $lands = $this->createLandLog->landDetails($land_id);

            $data[config('table.lands')] = $lands;
            $data[config('table.title')] = __('table.land_logs');

            return view(config('setting.land_logs'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function commentLogs(Request $request) {
        try {
            $data = [];
            if ($request->has(config('table.primary_key'))) {
                $land_id = $request->get(config('table.primary_key'));
            } else {
                abort(config('setting.err_403'));
            }
            $land_comments_logs = $this->landComments->landDetails($land_id);

            $data[config('table.land_comments_logs')] = $land_comments_logs;
            $data[config('table.title')] = __('table.land_comments_logs');

            return view(config('setting.comment_logs'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function documentation() {
        return File::get(resource_path().'/docs/index.html');
    }
}
