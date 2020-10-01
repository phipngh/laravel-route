<?php

namespace App\Http\Controllers;

use App\Catelogy;
use App\Exports\CatelogyExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Imports\CatelogyImport;
use Maatwebsite\Excel\Facades\Excel;

class CatelogyController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Catelogy::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm rounded">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm rounded">Delete</button>';
                    return $button;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['action','created_at'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.catelogys');
    }

    public function store(Request $request){
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

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Catelogy::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Catelogy $catelogy)
    {
        $rules = array(
            'name'        =>  'required',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'    =>  $request->name,
        );

        Catelogy::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Catelogy::findOrFail($id);
        $data->delete();
    }

    public function import()
    {
        Excel::import(new CatelogyImport, request()->file('file'));

        return redirect()->back()->with('msg','Import Successfully!');
    }

    public function export()
    {
        return Excel::download(new CatelogyExport, 'catelogy.xlsx');
    }



}
