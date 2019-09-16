<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Baixinho;
use App\Canal;
use App\Permission;
use App\Responsavel;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(256);

         //inserindo UUID
        User::creating(function (User $user) {
            $user->incrementing = false;
            $user->uuid = Str::uuid()->toString();
        });

        // Baixinho::creating(function (Baixinho $baixinho) {
        //     $baixinho->incrementing = false;
        //     $baixinho->uuid = Str::uuid()->toString();
        // });

        // Responsavel::creating(function (Responsavel $responsavel) {
        //     $responsavel->incrementing = false;
        //     $responsavel->uuid = Str::uuid()->toString();
        // });

        // Canal::creating(function (Canal $canal) {
        //     $canal->incrementing = false;
        //     $canal->uuid = Str::uuid()->toString();
        // });


        //Recuperando UUID
         User::retrieved(function (User $user) {
            $user->incrementing = false;
        });

        Baixinho::retrieved(function (Baixinho $baixinho) {
            $baixinho->incrementing = false;
        });

        Responsavel::retrieved(function (Responsavel $responsavel) {
            $responsavel->incrementing = false;
        });

        Canal::retrieved(function (Canal $canal) {
            $canal->incrementing = false;
        });

    }
}
