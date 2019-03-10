<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function listView(Request $request)
    {
        return view('list');
    }

    public function createValue(Request $request)
    {

    }

    public function editValue(Request $request)
    {

    }

    public function deleteValue(Request $request)
    {

    }
}
