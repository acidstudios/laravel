<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return response()->json($permissions, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->all();
        $rules = [
            'slug' => 'required',
            'name' => 'required'
        ];

        $messages = [
            'slug.required' => 'Slug is required',
            'name.required' => 'Name is required'
        ];

        $validator = Validator::make($fields, $rules, $messages);

        if($validator->fails()) {
            return response()->json(['status' => 500, 'hasError' => true, 'messages' => $validator->messages()], 500);
        }

        $permission = new Permission;
        $permission->fill($fields);
        $permission->save();

        return response()->json(['status' => 200, 'hasError' => false, 'messages' => []]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
