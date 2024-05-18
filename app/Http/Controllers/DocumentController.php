<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Document/Index');
    }

    public function create()
    {
        return Inertia::render('Admin/Document/Form');
    }

    public function edit()
    {
        return Inertia::render('Admin/Document/Form');
    }
}
