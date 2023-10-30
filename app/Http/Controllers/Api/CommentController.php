<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Dep;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    public function forward(Request $request)
    {

        function getDep($code) {
            $res = Dep::find($code)->dep_title;
            return $res;
        }

        $request->validate([
            'refID' => 'required',
            'detail' => 'required',
            'forward' => 'required',
        ]);

        $data = new Comment();
        $data->ref_id = $request['refID'];
        $data->name = Auth::user()->name;
        $data->surname = Auth::user()->surname;
        $data->dep = Auth::user()->dep;
        $data->dep_title = getDep(Auth::user()->dep);
        $data->detail = $request['detail'];
        $data->forward = $request['forward'];
        $data->forward_title = getDep($request['forward']);
        $data->status = 1;

        $data->save();

        $result = Post::find($request['refID']);
        $result->stat = 3;
        $result->update();

        return response()->json($data);

        dd($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Comment::orderBy('id', 'ASC')->where('ref_id', $id)->get();

        return response()->json($data);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
