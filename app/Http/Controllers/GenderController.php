<?php

namespace App\Http\Controllers;


use App\Exports\GenderExport;
use App\Gender;
use App\Imports\GenderImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class GenderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Gender::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm rounded">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm rounded">Delete</button>';
                    return $button;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['action','created_at','ordinal'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.gender');
    }

    public function store(Request $request){
        $rules = array(
            'object'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'object'        =>  $request->object,
        );

        Gender::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Gender::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Gender $gender)
    {
        $rules = array(
            'object'        =>  'required',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'object'    =>  $request->object,
        );

        Gender::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Gender::findOrFail($id);
        $data->delete();
    }

    public function import()
    {
        Excel::import(new GenderImport, request()->file('file'));

        return redirect()->back()->with('msg','Import Successfully!');
    }

    public function export()
    {
        return Excel::download(new GenderExport, 'gender.xlsx');
    }
}
