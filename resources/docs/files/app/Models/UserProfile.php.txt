<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model {
    use HasFactory;

    protected $table = 'user_profiles';

    protected $guarded = [];

    public function __construct() {
        $this->table = config('table.user_profiles');
    }

    public static function saveInsertProfile($record) {

        debug_logs(is_array($record));
        $data = [
            config('table.mobile') => null,
            config('table.job_id') => null,
            config('table.age') => null,
            config('table.gender') => null,
            config('table.address') => null,
        ];
        $data[config('table.user_id')] = auth()->user()->id;
        $unique[config('table.user_id')] = auth()->user()->id;

        if (is_key_exists(config('table.mobile'), $record) && $record[config('table.mobile')]) {
            $data[config('table.mobile')] = $record[config('table.mobile')];
        }
        debug_logs($data);

        if (is_key_exists(config('table.job_id'), $record) && $record[config('table.job_id')]) {
            $data[config('table.job_id')] = $record[config('table.job_id')];
        }
        if (is_key_exists(config('table.age'), $record) && $record[config('table.age')]) {
            $data[config('table.age')] = $record[config('table.age')];
        }
        if (is_key_exists(config('table.gender'), $record) && $record[config('table.gender')]) {
            $data[config('table.gender')] = $record[config('table.gender')];
        }
        if (is_key_exists(config('table.address'), $record) && $record[config('table.address')]) {
            $data[config('table.address')] = $record[config('table.address')];
        }
        debug_logs('data => ');
        debug_logs($data);

        UserProfile::updateOrCreate($unique, $data);
    }

    public function job() {
        return $this->belongsTo(Job::class, config('table.job_id'));
    }
}
