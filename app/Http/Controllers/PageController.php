<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

final class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function impressum(): View
    {
        return view('pages.impressum');
    }

    public function datenschutz(): View
    {
        return view('pages.datenschutz');
    }
}
