<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\TShirts;
use App\Policies\TShirtsPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void{
   
        /*Gate::define('isAdmin', function($user) {
           return $user->user_type == 'A';
        });
       
        Gate::define('isFuncionario', function($user) {
            return $user->user_type == 'F';
        });
      
        Gate::define('isCliente', function($user) {
            return $user->user_type == 'C';
        });*/
    }
}
