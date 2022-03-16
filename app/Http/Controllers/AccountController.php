<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use App\Models\User;

class AccountController extends Controller
{
    // show specific user filter by name and email
    public function show($user){
        
        return AccountResource::collection(User::where('name', 'LIKE', "%{$user}%")->orwhere('name', 'LIKE', "%{$user}%")->paginate(10));
        
        
    }
    // show all users
    public function index(){
        
        return AccountResource::collection(User::paginate(10));
    }
    // create user
    public function store(AccountRequest $request){
        $user = User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);
        return 'Successful Create';
    }
    // edit users
    public function update(AccountRequest $request,User $user){
        
        $user->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
        ]);

        return new AccountResource($user);
        
    }
    // delte user
    public function destroy(User $user){
        $user->delete();
        return response(null,204);
    }

    
}
