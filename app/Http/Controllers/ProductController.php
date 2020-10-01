<?php

namespace App\Http\Controllers;

use App\Catelogy;

use App\Exports\ProductExport;
use App\Gender;
use App\Imports\ProductImport;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $catelogies = Catelogy::all();
        $genders = Gender::all();

        if($request->ajax())
        {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm rounded">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm rounded">Delete</button>';
                    return $button;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('catelogy_id', function ($data) {
                    return $data->catelogy->name;
                })
                ->editColumn('gender_id', function ($data) {
                    return $data->gender->object;
                })
                ->editColumn('description', function ($data) {
                    return Str::limit($data->description,20,'...') ;
                })
                ->editColumn('price', function ($data) {
                    return '$ '.number_format($data->price , 0, ',', '.');;
                })
                ->rawColumns(['action','created_at'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.product',compact('catelogies','genders'));
    }

    public function store(Request $request){
        $rules = array(
            'name'    =>  'required',
            'description' =>'required',
            'price' => 'required|numeric',
            'image' => 'required',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->hasFile('image')){
            $image = $request->image;
            $fullname = uniqid().'_'.$image->getClientOriginalname();
            $image->move('upload',$fullname);
        }


        $form_data = array(
            'catelogy_id' =>$request->catelogy,
            'gender_id' =>$request->gender,
            'name'        =>  $request->name,
            'description' =>$request->description,
            'price' =>$request->price,
            'image' => $fullname,
        );

        Product::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }


    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

//    public function update(Request $request, Product $product)
//    {
//
//        $rules = array(
//            'name'    =>  'required',
//            'description' =>'required',
//            'price' => 'required|numeric',
//
//        );
//
//        $error = Validator::make($request->all(), $rules);
//
//        if($error->fails())
//        {
//            return response()->json(['errors' => $error->errors()->all()]);
//        }
//
//        if($request->hasFile('image')){
//            if(file_exists(public_path('upload/').$product->image)){
//                unlink(public_path('upload/').$product->image);
//            }
//
//            $image =$request->image;
//            $fullname = uniqid().$image->getClientOriginalname();
//            $image->move('upload',$fullname);
//
//        }
//
//        $form_data = array(
//            'catelogy_id' =>$request->catelogy,
//            'gender_id' =>$request->gender,
//            'name'        =>  $request->name,
//            'description' =>$request->description,
//            'price' =>$request->price,
//            'image' => $fullname,
//        );
//
//        Product::whereId($request->hidden_id)->update($form_data);
//
//        return response()->json(['success' => 'Data is successfully updated']);
//    }

    public function update(Request $request)
    {
        $product = Product::find($request->hidden_id);

        $rules = array(
            'name'    =>  'required',
            'description' =>'required',
            'price' => 'required|numeric',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }


        if($request->hasFile('image')){
            if(file_exists(public_path('upload/').$product->image)){
                unlink(public_path('upload/').$product->image);
            }

            $image =$request->image;
            $fullname = uniqid().'_'.$image->getClientOriginalname();
            $image->move('upload',$fullname);
            $product->image = $fullname;

        }

//        $form_data = array(
//            'catelogy_id' =>$request->catelogy,
//            'gender_id' =>$request->gender,
//            'name'        =>  $request->name,
//            'description' =>$request->description,
//            'price' =>$request->price,
//            'image' => $fullname,
//        );

        $product->catelogy_id =$request->catelogy;
        $product->gender_id =$request->gender;
        $product->name =$request->name;
        $product->description =$request->description;
        $product->price =$request->price;

        $product->save();

//        Product::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        unlink(public_path('upload/').$data->image);
        $data->delete();
    }

    public function import()
    {
        Excel::import(new ProductImport, request()->file('file'));

        return redirect()->back()->with('msg','Import Successfully!');
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'catelogy.xlsx');
    }
}
