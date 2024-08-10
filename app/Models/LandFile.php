<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandFile extends Model {
    use HasFactory;

    protected $table = 'land_files';

    protected $guarded = [];

    public function __construct() {
        $this->table = config('table.land_files');
    }

    public function insertRecords($records) {
        debug_logs($records);
        $landFileObj = LandFile::insert($records);
        debug_logs($landFileObj);
    }
}
