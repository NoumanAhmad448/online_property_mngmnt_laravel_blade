<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Helpers\FileUpload;
use App\Http\Requests\AdminLandsPatch;
use App\Http\Requests\LandCreate;
use App\Mail\LandCreateEmail;
use App\Models\CreateLand;
use App\Models\LandComments;
use App\Models\LandFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class LandCreateController extends Controller {
    private $createNewUser;

    private $landComments;

    private $createLand;

    private $email;

    private $createLandObj;

    private $landFileObj;

    private $fileUplaodObj;

    public function __construct() {
        $this->createNewUser = new CreateNewUser;
        $this->landComments = new LandComments;
        $this->createLand = new CreateLand;
        $this->email = config('form.email');
        $this->createLandObj = new CreateLand;
        $this->landFileObj = new LandFile;
        $this->fileUplaodObj = new FileUpload;

    }

    public function land(Request $request) {
        try {
            $data = [];
            $user = auth()->id();

            $lands = $this->createLand->landDetails($user);

            $data[config('table.lands')] = $lands;
            $data[config('table.title')] = __('messages.lands');

            return view(config('setting.lands'), compact('data'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    private function storeFiles($request, $land = null) {

        if (config('setting.en_land_reg_file') && $request->file(config('setting.land_reg_file_upload'))) {
            $uploaded_records = $this->fileUplaodObj->upload($request->file(config('setting.land_reg_file_upload')),
                config('table.land_create').'_id', $land ? $land?->id : $this?->createLand?->id
            );
            $this->landFileObj->insertRecords($uploaded_records);
        }
    }

    public function landSave(LandCreate $request) {
        php_config();
        try {
            $request->validated();
            if (! Auth::user()) {
                $user = $this->createNewUser->createUser($request->all());
            } else {
                $user = auth()->user();
            }

            $createLand = $this->createLandObj->insert($user, $request->all());
            $this->storeFiles($request, $createLand);
            if (config('setting.send_land_email')) {
                // mailer(config("mail.default"))->
                Mail::to($user->email)->send(new LandCreateEmail($user->name,
                    $user->email, $createLand,
                    __('messages.land_reg_mail_sub')));
            }

            return customResponse([config('setting.is_success') => true,
                config('setting.message') => __('messages.land_reg_msg')], config('setting.status_200'));

        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function landUpdate($uuid_or_id, LandCreate $request) {
        $land = $this->createLandObj->getLand(($uuid_or_id));

        $denies_update = Gate::denies(config('policy.update_land'), $land);
        if (empty($land) || $denies_update) {
            abort(config('setting.err_403'));
        }

        $this->createLandObj->updateLand($land, $request->all());
        $this->storeFiles($request, $land);

        return customResponse([config('setting.is_success') => true,
            config('setting.message') => __('messages.lnd_updt_msg')], config('setting.status_200'));
    }

    public function landUpdateBulk(AdminLandsPatch $request) {
        try {
            $request->validated();
            $this->landComments->insertRecords(auth()->user(), $request->all());

            return customResponse([
                config('setting.is_success') => true,
                config('setting.message') => __('messages.land_updt_op')],
                config('setting.status_200')
            );

        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function landSaveAPI(LandCreate $request) {
        php_config();
        if ($request->ajax()) {
            try {
                return view(config('setting.land_create'));
            } catch (\Exception $d) {
                return server_logs($e = [true, $d], $request = [true, $request], $config = true);
            }
        } else {
            abort(403);
        }
    }

    public function landCreate(Request $request) {
        try {
            return view(config('setting.land_create'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }

    public function landUpdateShow($land, Request $request) {
        try {
            $land = $this->createLandObj->getLand(($land));
            debug_logs($land);
            debug_logs($land->user_id);
            debug_logs($land->landFiles);
            $denies_update = Gate::denies(config('policy.update_land'), $land);
            if (empty($land) || $denies_update) {
                abort(config('setting.err_403'));
            }

            return view(config('setting.land_create'), compact('land'));
        } catch (\Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }
}
