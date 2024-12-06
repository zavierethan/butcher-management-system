<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

use DB;

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
        // View::composer('*', function ($view) {
        //     $menuTree = Cache::rememberForever('menu_tree', function () {
        //         $menus = DB::table('menus')
        //             ->select('id', 'name', 'url', 'icon', 'parent_id', 'order')
        //             ->orderBy('parent_id')
        //             ->orderBy('order')
        //             ->get();

        //         return $this->buildMenuTree($menus);
        //     });

        //     $view->with('menuTree', $menuTree);
        // });

        $parent = DB::table('menus')->whereNull('parent_id')->orderBy('order', 'asc')->get();

        $child = DB::table('menus')->whereNotNull('parent_id')->orderBy('order', 'asc')->get();

        View::share([
            'parent_menus' => $parent,
            'child_menus' => $child,
        ]);
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
