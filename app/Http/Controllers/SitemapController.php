<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class SitemapController extends Controller
{
    public function index()
    {
        $path = public_path('sitemap.xml');

        if (!file_exists($path)) {
            abort(404, 'Sitemap not found');
        }

        return response()->file($path, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function generate()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        Artisan::call('sitemap:generate');
        return redirect()->back()->with('success', 'Sitemap generated successfully!');
    }
}
