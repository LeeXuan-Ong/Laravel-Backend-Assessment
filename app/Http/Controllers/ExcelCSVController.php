<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\AccountResource;
use App\Http\Requests\ExcelCSVRequest;
use App\Http\Controllers\AccountController;
use App\Models\User;
use Hash;

class ExcelCSVController extends Controller
{
    // bulk create users
    public function importExcelCSV(ExcelCSVRequest $request){

        Excel::import(new UsersImport,$request->file('file'));

        return 'Import Success...';
    }

    // bulk create users
    public function CreateUser(ExcelCSVRequest $request){
        $result_array = [];
        $array = Excel::toArray(new UsersImport, $request->file('file'));
        // return var_dump($array);
        $result_array = $array[0];
        foreach($result_array as $new_array){
            $user = User::create([
                'name'=> (string) $new_array['name'],
                'email'=>(string) $new_array['email'],
                'password'=> (string) Hash::make($new_array['password']),
            ]);
        }
        return 'Success';
        
    }

    // bulk edit users
    public function editUser(ExcelCSVRequest $request){
        
        $result_array = [];
        $array = Excel::toArray(new UsersImport, $request->file('file'));
        
        
        $result_array = $array[0];
        foreach($result_array as $new_array){
            $password = Hash::make($new_array['password']);
            $name = $new_array['name'];
            $email = $new_array['email'];
            $id = $new_array['id'];
            $user = User::find($id);
            $user->update([
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
            ]);
            }
        return 'success';
        }
    
    // bulk delete users
    public function deleteUser(ExcelCSVRequest $request){
        $result_array = [];
        $array = Excel::toArray(new UsersImport, $request->file('file'));
        
        
        $result_array = $array[0];
        foreach($result_array as $new_array){
            $array = [];
            $name = $new_array['name'];
            $email = $new_array['email'];
            $id = $new_array['id'];
            $user = User::find($id);
            $user->delete();
            }
        return 'success';
    }
}