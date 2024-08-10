<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreateLandLog extends CustomModel {
    use HasFactory;

    protected $table = 'land_create_logs';

    protected $guarded = [];

    public function __construct() {
        $this->table = config('table.land_create_logs');
    }

    public function landDetails($land_id) {
        $land_id = str_to_array($land_id);
        $land = CreateLandLog::whereIn(config('table.land_id'), $land_id);
        $land = $land->with('user');
        $land = $land->orderByDesc(config('table.primary_key'));
        $land = $land->get();

        return $land;
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
