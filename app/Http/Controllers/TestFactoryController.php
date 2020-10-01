<?php

namespace App\Http\Controllers;

use App\TestFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function foo\func;

class TestFactoryController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = TestFactory::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['action','created_at'])
                ->make(true);
        }

        return view('admin.testfactory');


    }


//    public function index(Request $request){
//        if($request->ajax())
//        {
//            $data = TestFactory::latest()->get();
//            return DataTables::of($data)
//                ->addColumn('action', function($data){
//                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
//                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
//                    return $button;
//                })
//                ->rawColumns(['action'])
//                ->make(true);
//        }
//        return view('admin.testfactory');
//    }





}
