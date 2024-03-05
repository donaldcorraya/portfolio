<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Projects::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validate = Validator::make($request->all(),[
                'name'                  =>'min:3|max:256',
                'url'                   =>'min:3',
                'thumbnail'             =>'min:5',
                'heading'               =>'min:3',
                'short_description'     =>'min:3',
                'long_description'      =>'min:3',
            ]);

            if($validate->fails()){
                return response()->json(['error' => 'Validation error']);
            }


            Projects::create([
                'name'                  => $request->name,
                'url'                   => $request->url,
                'thumbnail'             => $request->thumbnail,
                'heading'               => $request->heading,
                'short_description'     => $request->short_description,
                'long_description'      => $request->long_description,
            ]);

           return response()->json(['success' => 'Data added Successfully']);

        }catch(Exception $e){
            return response()->json(['error' => 'Fail']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Projects::find($id);
        return response()->json([$data, 200]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){

        try{
            $validate = Validator::make($request->all(),[
                'name'                  =>'required|string|min:3|max:256',
                'url'                   =>'required',
                'thumbnail'             =>'required',
                'heading'               =>'required',
                'short_description'     =>'required',
                'long_description'      =>'required',
            ]);


            if ($validate->fails()) {
                return response()->json(['error' => 'Validation error']);
            }

            $data = Projects::find($id);

            $data->update([
                'name'                  => $request->name,
                'url'                   => $request->url,
                'thumbnail'             => $request->thumbnail,
                'heading'               => $request->heading,
                'short_description'     => $request->short_description,
                'long_description'      => $request->long_description,
            ]);
            return response()->json(['success' => 'Data update Successfully']);
        }catch(Exception $e){
            return response()->json(['error' => 'Fail']);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        $data = Projects::destroy($id);

        if(!$data){
            return response()->json(['error' => 'Fail']);
        }

        return response()->json(['success' => 'Data delete Successfully']);
    }
}
