<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Defer the menu population logic until views are being rendered
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id(); // Get logged-in user's ID
                $groupId = Auth::user()->group_id; // Get the group ID of the user

                // Fetch parent menus
                $parentMenus = DB::table('menus as m')
                    ->join('group_menu_access as gma', 'm.id', '=', 'gma.menu_id')
                    ->where('gma.group_id', $groupId)
                    ->whereNull('m.parent_id')
                    ->select('m.*')
                    ->orderBy('m.order')
                    ->get();

                // Fetch child menus
                $childMenus = DB::table('menus as m')
                    ->join('group_menu_access as gma', 'm.id', '=', 'gma.menu_id')
                    ->where('gma.group_id', $groupId)
                    ->whereNotNull('m.parent_id')
                    ->select('m.*')
                    ->orderBy('m.order')
                    ->get();
                // dd($childMenus);
                // Share with all views
                $view->with([
                    'parent_menus' => $parentMenus,
                    'child_menus' => $childMenus,
                ]);
            } else {
                // No user is logged in, share empty menus
                $view->with([
                    'parent_menus' => [],
                    'child_menus' => [],
                ]);
            }
        });
    }

    /**
     * Build the nested menu tree.
     */
    private function buildMenuTree($menus, $parentId = null)
    {
        // $tree = [];
        // foreach ($menus as $menu) {
        //     if ($menu->parent_id == $parentId) {
        //         $children = $this->buildMenuTree($menus, $menu->id);
        //         $menu->children = $children;
        //         $tree[] = $menu;
        //     }
        // }
        // return $tree;
    }
}
