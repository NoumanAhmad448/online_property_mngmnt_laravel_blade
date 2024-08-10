<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class CustomBuilder extends Builder {
    protected function showQuery() {
        debug_logs($this->toSql());

        return $this;
    }
}

trait CustomModelTrait {
    public function showQuery($query) {
        return new CustomBuilder($query);
    }

    public function showModelQuery($query) {
        debug_logs($query->toSql());

        return $query;
    }

    // function get($query)
    // {
    //     $results = $query->get();
    //     debug_logs($results);
    //     return $results;
    // }
}
class CustomModel extends Model {
    public function scopeshowQuery($query) {
        return $this->showModelQuery($query);
    }
    // public function scopeget($query){

    //     return $this->get($query);
    // }
}
