<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\Role;

use Validator;

class UserController extends Controller
{
    public function me(Request $request) {
        $user = $this->CurrentUser();

        return response()->json($user, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::where('slug','user')->first();

        if(isset($input['role'])) {
            $role = Role::where('slug', $input['role'])->first();
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User;
        $user->fill($input);
        $user->save();

        $user->roles()->attach($role);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::find($id));
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
        $user = User::find($id);

        if(isset($user)) 
        {
            $fields = $request->all();
            $rules = [
                'name' => 'required',
                'email' => 'required'
            ];
    
            $messages = [
                'name.required' => 'Name is required',
                'email.required' => 'Emial is required'
            ];
    
            $validator = Validator::make($fields, $rules, $messages);
    
            if($validator->fails()) 
            {
                return response()->json(['status' => 500, 'hasError' => true, 'messages' => $validator->messages()], 500);
            }

            $user->fill($fields);

            if($user->save())
            {
                if(isset($fields['roles'])) 
                {
                    $roles = $fields['roles'];
                    foreach ($roles as $key => $value) {
                        if(!$user->hasRole($value))
                        {
                            $role = Role::where('slug', $value)->first();
                            $user->roles()->attach($role);
                        }
                    }
                }
                $user = User::find($id);
                return new UserResource($user);
            }

            return response()->json(null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(isset($user))
        {
            if(!$user->hasRole('admin'))
            {
                $user->delete();
                return response()->json(null, 204);
            }

            return response()->json(null, 422);
        }

        return response()->json(null, 404);
    }
}
