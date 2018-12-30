<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;
use Validator;

use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoleCollection(Role::all());
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

        if($validator->fails()) 
        {
            return response()->json(['status' => 500, 'hasError' => true, 'messages' => $validator->messages()], 500);
        }

        $role = new Role;
        $role->fill($fields);
        $role->save();

        if($role->save())
        {
            return new RoleResource($role);
        }

        return response()->json(['status' => 403, 'hasError' => false, 'messages' => []], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RoleResource(Role::find($id));
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
        $role = Role::find($id);

        if(isset($role))
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
    
            if($validator->fails()) 
            {
                return response()->json(['status' => 500, 'hasError' => true, 'messages' => $validator->messages()], 500);
            }

            $role->fill($fields);

            if($role->save())
            {
                return new RoleResource($role);
            }

            return response()->json(null, 500);
        }
        
        return response()->json(['hasError' => true], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if(isset($role)) {
            $role->delete();

            return response()->json(null, 204);
        }

        return response()->json(null, 404);
    }
}
