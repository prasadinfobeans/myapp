<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('validate_int', function ($attribute, $value, $parameters, $validator) {
            // return !(($value ^ 0) !== $value);
            $temp = explode('.', $value);
           // dd($temp);die;
            return (isset($temp[1]) && $temp[1]) ? false : true;
        });
    }

}
