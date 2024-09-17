<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::where('public', 1)->orderby('id', 'DESC')->paginate(5);

        return response()->json($data);
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
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'type' => 'required',
            'concern' => 'required',
            'detail' => 'required'
        ]);

        $data = new Post();
        $data->name = $request['name'];
        $data->lastname = $request['lastname'];
        if (!empty($request['email'])) {
            $data->email = $request['email'];
        }
        $data->type = $request['type'];
        $data->concern = $request['concern'];
        $data->detail = $request['detail'];
        $data->stat = 1;
        $data->public = 0;
        $data->forward_dep = null;

        $data->save();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Post::find($id);

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
