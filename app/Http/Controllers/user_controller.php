<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class user_controller extends Controller
{
    public function login(Request $req)
    {
        $res =  DB::table('user')
        ->select('user.id','user.nama','user.telpon','user.email','user.role as roleId', 'role.role as roleName', 'user.tgl_lahir')
        ->join('role', 'user.role', '=','role.id')
        ->where('email', $req->email)
        ->where('password', $req->password)
        ->get();

        if (count($res)==0) {

            return response()->json([
                'code' => 200,
                'message' => 'Username atau Password Salah',
                'data' => null
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Sukses',
                'data' => $res
            ]);
        }
    }

    public function registerUser(Request $req)
    {
        try {
        

            $user = DB::table('user')
            ->where('email', $req->email)
            ->get();
            

            if (count($user)==0) { 
                

                if($req->password==$req->cnfrm_password){
                    $userInsert = [
                        'nama'=>$req->nama,
                        'telpon'=>$req->telpon,
                        'email'=>$req->email,
                        'role'=>$req->role,
                        'tgl_lahir'=>$req->tgl_lahir,
                        'password'=>$req->password
                    ];
             
                     $res = DB::table('user')
                     ->insert($userInsert);
             
                     return response()->json([
                        'code' => 200,
                        'message' => 'Sukses',
                        'data' => null
                    ]);
                } else {
                    return response()->json([
                        'code' => 200,
                        'message' => 'Password tidak sama',
                        'data' => null
                    ]);
                }

             } else {
                return response()->json([
                    'code' => 200,
                    'message' => 'User sudah ada',
                    'data' => $user
                ]);
             }

            
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
        
    }

    public function searchUser(Request $request)
    {
        $user = DB::select("
        Select 
        user.id, user.nama, user.telpon,user.email,user.role as roleId, role.role as roleName, user.tgl_lahir, (select count(*) from content c where c.id_responder = user.id) as jmlAduan 
        From user user join role role on user.role = role.id where nama like '%{$request->name}%' and user.role = 3");

        return response()->json([
            'code' => 200,
            'message' => 'Sukses',
            'data' => $user
        ]);
    }

    public function getUser(Request $request)
    {
        $user = DB::select("
        Select 
        user.id, user.nama, user.telpon,user.email,user.role as roleId, role.role as roleName, user.tgl_lahir, 
        (select count(*) from content c where c.id_responder = user.id) as jmlAduan,
        (select count(*) from folow f where f.id_responder = user.id) as jmlFollower,
        (select count(*) from folow f where f.id_responder = user.id and f.id_user = {$request->id_user}) as isFollow
        From user user join role role on user.role = role.id where user.id ={$request->id_responder}");

        return response()->json([
            'code' => 200,
            'message' => 'Sukses',
            'data' => $user
        ]);
    }

    public function followResponder(Request $request){
        if (DB::table('folow')->where('id_responder', $request->id_responder)->where('id_user', $request->id_user)->doesntExist()) {
            $followInsert = [
                'id_responder'=>$request->id_responder,
                'id_user'=>$request->id_user,
            ];

            $res = DB::table('folow')
                     ->insert($followInsert);
             
                     return response()->json([
                        'code' => 200,
                        'message' => 'Sukses',
                        'data' => null
                    ]);

        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Sudah mengikuti',
                'data' => null
            ]);
        }
    }
    
}
