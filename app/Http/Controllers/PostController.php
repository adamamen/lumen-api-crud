<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
// use App\M_Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        $post = DB::select("SELECT * FROM post");

        return response()->json([
            'success' => true,
            'message' => 'List Semua Post',
            'data'    => $post
        ], 200);
    }

    public function insert(Request $request)
    {
        $timestamp = Carbon::now()->toDateTimeString();
        $validator = Validator::make($request->all(), [
            'image'   => 'required',
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $post = DB::insert("INSERT INTO `post` (image, title, content, created_at, updated_at) values ('$request->image', '$request->title', '$request->content', '$timestamp', '$timestamp')");

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                    'data'    => $post
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $timestamp = Carbon::now()->toDateTimeString();
        $validator = Validator::make($request->all(), [
            'image'   => 'required',
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $post = DB::select("SELECT * FROM post WHERE id = $id");

            if ($post) {
                $update = DB::update("UPDATE post SET image = '$request->image', title = '$request->title', content = '$request->content', updated_at = '$timestamp' WHERE id = $id ");

                if ($update) {
                    return response()->json([
                        'success' => true,
                        'message' => 'ID Berhasil Diupdate!',
                        'data'    => [],
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'ID Gagal Diupdate!',
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Tidak Ditemukan, Silahkan coba lagi',
                ], 400);
            }
        }
    }

    public function delete($id)
    {
        $post = DB::select("SELECT * FROM post WHERE id = $id");

        if ($post) {
            $delete = DB::delete("DELETE FROM post WHERE id = $id");

            if ($delete) {
                return response()->json([
                    'success' => true,
                    'message' => 'ID Berhasil Dihapus!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Gagal Di Delete, Silahkan coba lagi',
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ID Tidak Ditemukan, Silahkan coba lagi',
            ], 400);
        }
    }
}
