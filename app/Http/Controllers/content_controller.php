<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class content_controller extends Controller
{
    
    public function getContentBaseResponder(Request $req)
    {
        $user = DB::select("
        Select 
        c.*,
        ur.nama as namaResponden,
        u.nama as namaUser,
        (select count(*) from comment cm where cm.id_user = u.id) as jmlComment
        from content c join user ur on c.id_responder = ur.id join user u on c.id_user = u.id  where c.id_responder = {$req->id_responder}");

        return response()->json([
            'code' => 200,
            'message' => 'Sukses',
            'data' => $user
        ]);
    }

    public function getContentBaseUserFollow(Request $req)
    {
        $user = DB::select("
        Select 
        c.*,
        ur.nama as namaResponden,
        u.nama as namaUser,
        (select count(*) from comment cm where cm.id_user = u.id) as jmlComment
        from content c join user ur on c.id_responder = ur.id join user u on c.id_user = u.id  where c.id_responder in (select id_responder from folow f where f.id_user={$req->id_user}) or c.id_user = {$req->id_user}");

        return response()->json([
            'code' => 200,
            'message' => 'Sukses',
            'data' => $user
        ]);
    }

    public function insertContent(Request $req)
    {
        $contentInsert = [
            'gambar'=>$req->id_file,
            'content'=>$req->content,
            'id_user'=>$req->id_user,
            'id_responder'=>$req->id_responder
        ];
 
         $res = DB::table('content')
         ->insert($contentInsert);
 
         return response()->json([
            'code' => 200,
            'message' => 'Sukses',
            'data' => null
        ]);
    }
}
