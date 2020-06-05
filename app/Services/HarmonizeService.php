<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class HarmonizeService extends ServiceProvider{

    public function boot(){

    }

    public function register(){
        $this->app->bind(
                          'App\Repositories\User\Interfaces\UserInterface','App\Repositories\User\UserRepository'
                        );
    }

}
