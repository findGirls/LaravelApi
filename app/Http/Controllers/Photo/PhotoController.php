<?php

namespace App\Http\Controllers\Photo;

use Validator;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        empty($request->pageNum) ? $page = 20 : $page = $request->pageNum;
        $photo = Photo::paginate($page);
        return $photo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|URL|unique:photos|max:255',
            'source' => 'required|max:255',
        ]);

        // TODO 这里应该是自定义消息，根据什么错误反馈什么消息。
        if ($validator->fails()) {
            return response()->json(['errors' => "请求参数不全或数据已存在，请返回检查", 'status' => 500], 200);
        }

        $x = new Photo();
        $x->url = $request->input('url');
        $x->source = $request->input('source');
        if (empty($request->input('tag_id'))) {
            $x->tag_id = 0;
        } else {
            $x->tag_id = $request->tag_id;
        }
        $x->save();
        return json_encode($x);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $photo = Photo::find($id);
        if (empty($photo)) {
            return response()->json([
                'message' => '没有对应的数据',
                'status' => '404',
            ]);
        }
        return json_encode($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
