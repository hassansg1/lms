<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SeeAssetController extends Controller
{
    //

    public function view($locationId, $nodeId = null)
    {
        Session::put('asset_location_id', $locationId);
        Session::put('node_id', $nodeId);
        if ($nodeId == 0)
            return redirect()->back();
        return redirect()->to(url('asset_lending_page/' . $locationId . '/' . $nodeId));
    }
}
