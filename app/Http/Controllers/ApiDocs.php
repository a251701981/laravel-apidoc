<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class ApiDocs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = DB::table('api_docs')
                ->when($request->has('keyword'),function($query)use($request){
                    $keyword = $request->get('keyword');
                    return $query->where('name','like','%'.$keyword)->orwhere('name','like',$keyword.'%');
                })

                ->simplePaginate(15);
        $ids = [];
        foreach($docs as $k=>$doc)
        {
            $ids[$doc->id] = &$docs[$k];
            $docs[$k]->params = [];
        }

        $params = DB::table('api_docs_params')->whereIn('api_docs_id',array_keys($ids))->get();
        foreach($params as $param)
            $ids[$param->api_docs_id]->params[] = $param;
        return view('apidocs/list',['docs'=>$docs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('apidocs/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function ()use($request) {

            $docs = $request->except('_token');
            $params = $docs['params'];
            unset($docs['params']);
            $myfilter = function($str){
                $str = addslashes($str);
                $str = str_replace(["\r","\n"],["\\r","\\n"],$str);
                return strip_tags($str);
            };
            foreach($params as $k=>$param)
                $params[$k] = array_map($myfilter,$param);
            $docs = array_map($myfilter,$docs);

            $id = DB::table('api_docs')->insertGetId($docs);
            foreach($params as $k=>$param)
                $params[$k]['api_docs_id'] = $id;

            DB::table('api_docs_params')->insert($params);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doc = DB::table('api_docs')->where('id',$id)->first();
        $params = DB::table('api_docs_params')->where('api_docs_id',$doc->id)->get();
        $doc->params = $params;
        return view('apidocs/edit',['doc'=>json_encode($doc)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function ()use($request,$id) {
            $doc = $request->except(['_token','_method']);
            $params = $doc['params'];
            unset($doc['params']);

            $myfilter = function($str){
                $str = addslashes($str);
                $str = str_replace(["\r","\n"],["\\r","\\n"],$str);
                return strip_tags($str);
            };
            foreach($params as $k=>$param)
                $params[$k] = array_map($myfilter,$param);
            $doc = array_map($myfilter,$doc);

            DB::table('api_docs')->where('id',$id)->update($doc);
            foreach($params as $k=>$param)
                $params[$k]['api_docs_id'] = $id;
            DB::table('api_docs_params')->where('api_docs_id',$id)->delete();
            DB::table('api_docs_params')->insert($params);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function()use($id){
           DB::table('api_docs')->where('id',$id)->delete();
           DB::table('api_docs_params')->where('api_docs_id',$id)->delete();
        });
    }
}
