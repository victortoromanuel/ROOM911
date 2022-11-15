<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Admin_room_911;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('admin-room-911', function($user){
            $gate = false;
            $admin_room_911 = Admin_room_911::find($user->id_admin_room_911);
            if (!is_null($admin_room_911)){
                $gate = true;
            }
            else{
                $gate = false;
            }
            return $gate;
        });
    }
}
