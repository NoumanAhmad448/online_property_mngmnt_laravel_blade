<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileUpload {
    private $file_path = '';

    public function __construct() {
        $this->file_path = config('setting.landreg_folder');
    }

    public function upload($files, $key, $value) {
        $data = [];
        debug_logs($files);

        if (isArray($files) && count($files) > 0) {
            foreach ($files as $file) {
                $data[] = $this->uploadFile($file, $key, $value);
            }
        } else {
            $data = $this->uploadFile($files, $key, $value);
        }

        return $data;
    }

    private function uploadFile($file, $key, $value) {
        $data = [];
        Storage::makeDirectory($this->file_path, 0775, true);
        debug_logs('in uploadFile');
        debug_logs(gettype($this->file_path));
        debug_logs(gettype($file));
        debug_logs($file);

        $data[config('table.link')] = config('app.env') == config('setting.default_local') ?
                config('setting.default_img') : Storage::put($this->file_path, $file, 'public');
        $data[config('table.f_mimetype')] = $file->getClientMimeType();
        $data[config('table.f_name')] = $file->getClientOriginalName();
        $data[$key] = $value;
        debug_logs($data);

        return $data;
    }
}
