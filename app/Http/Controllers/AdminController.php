<?php

namespace App\Http\Controllers;

use App\Catelogy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    public function index(){
        return view('admin.index');
    }

    public function catelogies(){
        $catelogies = Catelogy::all();
        return view('admin.catelogies', compact('catelogies'));
    }

    public function createCatelogies(Request $request){
        $request->validate([
            'name'=>'required',
        ]);

        $catelogy = new Catelogy();
        $catelogy->name = $request['name'];
        $catelogy->save();

        return redirect()->back()->with('msg','Product has been added successfully ! ');
    }

    public function deleteCatelogies($id){
        $catelogy = Catelogy::find($id);
        $catelogy->delete();

        return redirect()->back()->with('msg','Product has been deleted successfully ! ');
    }



    //Catelogy Page

    public function catelogy(Request $request){
        if($request->ajax()){
            $data = Catelogy::latest()->get();
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

        return view('admin.catelogy');
    }

    public function catelogyStore(Request $request){
        $rules = array(
            'name'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
        );

        Catelogy::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }


}
