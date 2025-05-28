<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Concern;
use App\Models\Type;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getPost()
    {
        $data = Post::where('public', 1)->orderBy('id', 'DESC')->limit(2)->get();

        return response()->json($data);
    }

    public function getConcern()
    {
        $arr = [];
        $i = 0;
        $data = Post::where('public', 1)->get();
        $res = Concern::all();

        foreach($res AS $r) {
            $arr[$i]['title'] = $r->concern_title;
            $arr[$i]['count'] = $data->where('concern', $r->id)->count();

            $i++;
        }

        return response()->json($arr);

    }

    public function getType()
    {
        $arr = [];
        $i = 0;
        $data = Post::where('public', 1)->get();
        $res = Type::all();

        foreach($res AS $r) {
            $arr[$i]['title'] = $r->type_title;
            $arr[$i]['count'] = $data->where('concern', $r->id)->count();

            $i++;
        }

        return response()->json($arr);
    }

    // public function getPost()
    // {
    //     $data = array(
    //         [
    //             'BIBID' => 'b00163678',
    //             'TITLE' => 'จิตวิทยาการรู้คิด / พาสนา จุลรัตน์',
    //             'LANG' => 'tha'
    //         ],
    //     );

    //     return response()->json($data);
    // }

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
