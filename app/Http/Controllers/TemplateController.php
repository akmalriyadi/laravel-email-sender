<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Template/Index');
    }

    public function create()
    {
        return Inertia::render('Admin/Template/Form');
    }
    public function edit()
    {
        return Inertia::render('Admin/Template/Form');
    }
}
