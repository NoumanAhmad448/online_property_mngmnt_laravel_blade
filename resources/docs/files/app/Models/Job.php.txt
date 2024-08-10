<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends CustomModel {
    use HasFactory;

    protected $table = 'jobs';

    public function __construct() {
        $this->table = config('table.jobs');
    }
}
