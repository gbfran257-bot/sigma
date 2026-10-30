<?php

namespace App\Http\Controllers\Wizard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WizardController extends Controller
{
    public function index()
    {
        return view('wizard.index');
    }
}
