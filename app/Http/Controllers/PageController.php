<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function contact()
    {
        return view('pages.contact');
    }
    // public function routeListJson()
    // {
    //     $routes = collect(Route::getRoutes())
    //         ->map(function ($route) {

    //             $uri = $route->uri();

    //             // FIX ROOT ROUTE
    //             if ($uri === '/') {
    //                 $uri = '';
    //             }

    //             return [
    //                 'name'   => $route->getName(),
    //                 'url'    => url($uri),  // <-- FULL URL FIXED
    //                 'method' => implode(',', $route->methods()),
    //             ];
    //         })
    //         ->filter(function ($route) {
    //             return $route['name'] !== null;
    //         })
    //         ->values();

    //     return response()->json($routes);
    // }

    public function routeListJson()
{
    // 1️⃣ Render your layout or page containing the menu
    // For example: home page with your menu
    $html = View::make('layouts.app')->render(); 

    // 2️⃣ Parse HTML
    $crawler = new Crawler($html);

    // 3️⃣ Find all <a> tags inside <ul><li>
    $links = $crawler->filter('ul li a')->links();

    $routes = [];

    foreach ($links as $link) {
        $url = $link->getUri();

        // 4️⃣ Match this URL to your Laravel route
        $route = collect(Route::getRoutes())->first(function ($r) use ($url) {
            return url($r->uri() === '/' ? '' : $r->uri()) === $url;
        });

        if ($route && $route->getName()) {
            $routes[] = [
                'name'   => $route->getName(),
                'url'    => $url,
                'method' => implode(',', $route->methods()),
            ];
        }
    }

    return response()->json($routes);
}
}
