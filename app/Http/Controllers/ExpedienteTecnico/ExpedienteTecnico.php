<?php

namespace App\Http\Controllers\ExpedienteTecnico;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpedienteTecnico extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return View('ExpedienteTecnico.index');
    }
}
