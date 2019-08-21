<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\ApiDoc;
use App\ApiDocsParam;

class ApiDocs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = ApiDoc::with('params')->when($request->has('keyword'),function($query)use($request){
            $keyword = $request->get('keyword');
            return $query->where('name','like','%'.$keyword)->orwhere('name','like',$keyword.'%');
        })->simplePaginate(15);
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
            $docs = $request->post();
            $params = $docs['params'];
            unset($docs['params']);
            $apidoc = ApiDoc::create($docs);
            foreach($params as $k=>$param)
                $params[$k] = new ApiDocsParam($param);
            $apidoc->params()->saveMany($params);
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
        $doc = ApiDoc::with('params')->find($id);
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
            $apidoc = ApiDoc::find($id);
            foreach($doc as $k=>$v)
                $apidoc[$k] = $v;
            $apidoc->save();
            ApiDocsParam::where('api_docs_id',$apidoc->id)->delete();
            foreach($params as $k=>$param)
            {
                $param['api_docs_id'] = $apidoc->id;
                ApiDocsParam::create($param);
            }
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
           ApiDoc::where('id',$id)->delete();
           ApiDocsParam::where('api_docs_id',$id)->delete();
        });
    }
}
