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

        /*************************************************** function ส่ง Notify ************************************************************** */
        
        function line_notify($text)
        {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            date_default_timezone_set("Asia/Bangkok");

            $sToken = 'FmZBskCUkntr5bmgN9bGbgolxSdwrxS0p167ElTlQ3d';
            $sMessage = 'ระบบแจ้งเตือน : ส่งต่อข้อร้องเรียนไปยังกลุ่มงาน --> ' . $text . ' | https://libvoc.msu.ac.th';

            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);

            //Result error 
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {
                $result_ = json_decode($result, true);
                echo "status : " . $result_['status'];
                echo "message : " . $result_['message'];
            }

            curl_close($chOne);
        }

        /*************************************************** Laravel ************************************************************** */

        $request->validate([
            'refID' => 'required',
            'detail' => 'required',
            'forward' => 'required',
        ]);

        $res = Post::find($request['refID'])->detail;
        $dep_title = Dep::find(Auth::user()->dep)->dep_title;
        $forward_title = Dep::find($request['forward'])->dep_title;

        $data = new Comment();
        $data->ref_id = $request['refID'];
        $data->name = Auth::user()->name;
        $data->surname = Auth::user()->surname;
        $data->dep = Auth::user()->dep;
        $data->dep_title = $dep_title;
        $data->detail = $request['detail'];
        $data->forward = $request['forward'];
        $data->forward_title = $forward_title;
        $data->status = 1;

        $data->save();

        $result = Post::find($request['refID']);
        $result->stat = 3;
        $result->forward_dep = $request['forward'];
        $result->update();

        /*************************************************** Array to Send Notify ************************************************************** */

        $arr = [];
        $arr['dep'] = $dep_title;
        $arr['title'] = "เรื่อง '" . $res . "'";
        $text = implode(" | ", $arr);

        line_notify($text);

        /*************************************************** Success ************************************************************** */

        return response()->json($data);
    }

    public function complete(Request $request)
    {

        /*************************************************** function ส่ง Notify ************************************************************** */
        /*
        function line_notify($text)
        {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            date_default_timezone_set("Asia/Bangkok");

            $sToken = 'FmZBskCUkntr5bmgN9bGbgolxSdwrxS0p167ElTlQ3d';
            $sMessage = '' . $text . ' | --> https://copper.msu.ac.th/office/';

            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);

            //Result error 
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {
                $result_ = json_decode($result, true);
                echo "status : " . $result_['status'];
                echo "message : " . $result_['message'];
            }

            curl_close($chOne);
        }
*/
        /*************************************************** Laravel ************************************************************** */

        $request->validate([
            'refID' => 'required',
            'detail' => 'required',
        ]);

        $dep_title = Dep::find(Auth::user()->dep)->dep_title;
        // $forward_title = Dep::find($request['forward'])->dep_title;

        $data = new Comment();
        $data->ref_id = $request['refID'];
        $data->name = Auth::user()->name;
        $data->surname = Auth::user()->surname;
        $data->dep = Auth::user()->dep;
        $data->dep_title = $dep_title;
        $data->detail = $request['detail'];
        // $data->forward = $request['forward'];
        // $data->forward_title = $forward_title;
        $data->status = 2;

        $data->save();

        $result = Post::find($request['refID']);
        $result->stat = 4;
        $result->update();

         /*************************************************** Array to Send Notify ************************************************************** */

        // $arr = [];
        // $arr['name'] = showName($data->uid);
        // $arr['type'] = showLeaveType($data->code);
        // $arr['start'] = 'เริ่ม ' . formatThai($data->start);
        // $arr['end'] = 'ถึง ' . formatThai($data->end);
        // $arr['total'] = 'จำนวน ' . $data->total . ' วัน';
        // $text = implode(" | ", $arr);

        //line_notify($text);

        /*************************************************** Success ************************************************************** */

        return response()->json($data);
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
