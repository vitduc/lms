<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.home');
    }

    /**
     * Show courses page
     *
     * @return \Illuminate\View\View
     */
    public function courses()
    {
        return view('pages.courses');
    }

    /**
     * Show categories page
     *
     * @return \Illuminate\View\View
     */
    public function categories()
    {
        return view('pages.categories');
    }

    /**
     * Show instructors page
     *
     * @return \Illuminate\View\View
     */
    public function instructors()
    {
        return view('pages.instructors');
    }

    /**
     * Show blog page
     *
     * @return \Illuminate\View\View
     */
    public function blog()
    {
        return view('pages.blog');
    }
}
