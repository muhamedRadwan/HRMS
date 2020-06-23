<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Menus\GetSidebarMenu;
use App\Models\Menulist;
use App\Models\RoleHierarchy;
use jeremykenedy\LaravelRoles\Models\Role;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            $role = 'guest';
            //$role =  Auth::user()->menuroles;
            $role = Auth::user()->roles()->select("slug")->pluck('slug')->toArray();//Role::where('level', Auth::user()->level())->select("slug")->first()->slug;
            // //$userRoles = $userRoles['items'];
            // $roleHierarchy = RoleHierarchy::select('role_hierarchy.role_id', 'roles.name')
            // ->join('roles', 'roles.id', '=', 'role_hierarchy.role_id')
            // ->orderBy('role_hierarchy.hierarchy', 'asc')->get();
            // $flag = false;
            // foreach($roleHierarchy as $roleHier){
            //     foreach($userRoles as $userRole){
            //         if($userRole == $roleHier['name']){
            //             $role = $userRole;
            //             $flag = true;
            //             break;
            //         }
            //     }
            //     if($flag === true){
            //         break;
            //     }
            // }
        }else{
            $role = 'guest';
        }
        // if(session("role", false) == $role && session("menues")){
        //     view()->share('appMenus', session("menues") );
        // }else{
            //session(['prime_user_role' => $role]);
            $menus = new GetSidebarMenu();
            $menulists = Menulist::all();
            $result = array();
            foreach($menulists as $menulist){
                $result[ $menulist->name ] = $menus->get( $role, $menulist->id );
            }
            session(["menues" => $result, "role" => $role ]);
            view()->share('appMenus', $result );
        // }
       
        return $next($request);
    }
}