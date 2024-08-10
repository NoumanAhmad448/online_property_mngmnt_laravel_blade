<?php

class CustomAuthenticatable extends Authenticatable {
    /*
    customize the model class with custom solution
    1. create a method with `scope` keywork appended in the method name
    2. define a logic in a `CustomModelTrait` class with additional method
    */

    public function scopeshowQuery($query) {
        return $this->showModelQuery($query);
    }

    // public function scopeget($query){

    //     return $this->get($query);
    // }
}
