<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BarangKeluarController extends Controller
{
    public function index(){
        return view('admin.masterData.barangKeluar');
    }
}