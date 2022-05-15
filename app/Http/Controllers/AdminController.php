<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Homework;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = Group::where('admin_id','=',auth()->user()->id)->get(['id'])->toArray();
        $homeworks = Homework::where('group_id','=',$groups)->where('start','<=',date('Y-m-d'))->where('end','>=',date('Y-m-d'))->get();
        return view('admin/home',compact('homeworks'));
    }
}
