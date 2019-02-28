@extends('public/layout')

@section('title','文档列表')

@section('ext-style')
    <style>
        .top{height: 73px;padding-top:30px;}
        .keyword{border:1px solid #ccc;}
        .toc{width:100%;}
        .toc-item{word-wrap:break-word ;}
    </style>
@endsection

@section('content')

    <div class="layui-fluid">

        <div class="layui-row top">
            <div class="layui-col-md1" >
                <h1><a href="/apidocs" >文档</a></h1>
                <button class=" layui-btn layui-btn-normal layui-btn-sm" ><a href="/apidocs/create" style="color:white;"  >新增+</a></button>
            </div>
            <div class="layui-col-md2 layui-col-md-offset4" >
                <form class="layui-form" action="">
                    <div class="layui-row">
                        <div class="layui-col-md6" >
                            <input type="text" name="keyword" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input keyword" />
                        </div>
                        <div class="layui-col-md6" >
                            <button class="layui-btn layui-btn-normal" >搜索</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="layui-row content" >
            <div class="layui-col-md2 left" >
                <ul class="toc" lay-filter="test">
                    @foreach($docs as $doc)
                        <li class="layui-text toc-item" ><a href="#anchor_{{$loop->index}}"  >{{$doc->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="layui-col-md10 right" >
                <div class="layui-row api-item" >
                    <div class="layui-col-md12" >

                        <div class="layui-row" >
                            <div class="layui-col-md12" >
                                <div class="layui-card">
                                    <div class="layui-card-body">
                                        @foreach($docs as $doc)
                                            <h2><a href="/apidocs/{{$doc->id}}/edit" ><i class="layui-icon layui-icon-edit"></i></a><a href="javascript:void(0);"  data-val="{{$doc->id}}" class="del" ><i class="layui-icon layui-icon-delete" ></i></a><a href="#" name="anchor_{{$loop->index}}" >{{$doc->name}}</a></h2>
                                            <blockquote class="layui-elem-quote layui-quote-nm">{{$doc->descript}}</blockquote>
                                            <h3>请求地址</h3>
                                            <blockquote class="layui-elem-quote layui-quote-nm">{{$doc->path}}</blockquote>
                                            <h3>请求方法</h3>
                                            <blockquote class="layui-elem-quote layui-quote-nm">{{$doc->method}}</blockquote>
                                            <h3>参数列表</h3>
                                            <table class="layui-table">
                                                <colgroup>
                                                    <col width="150">
                                                    <col width="200">
                                                    <col>
                                                </colgroup>
                                                <thead>
                                                <tr>
                                                    <th>名称</th>
                                                    <th>类型</th>
                                                    <th>示例</th>
                                                    <th>描述</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($doc->params as $param)
                                                    <tr>
                                                        <td>{{$param->name}}</td>
                                                        <td>{{$param->type}}</td>
                                                        <td>{{$param->example}}</td>
                                                        <td>{{$param->descript}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <h3>请求示例</h3>
                                            <pre class="layui-code" lay-skin="eclipose" encode="true" >{{str_replace(['\n','\"'],["\n",'"'],$doc->request)}}</pre>
                                            <h3>响应示例</h3>
                                            <pre class="layui-code" lay-skin="eclipose" encode="true" >{{str_replace(['\n','\"'],["\n",'"'],$doc->response)}}</pre>
                                        @endforeach
                                        {{$docs->links('vendor/pagination/default')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('ext-script')

    <script>
        //一般直接写在一个js文件中
        layui.use(['layer', 'form','code'], function(){
            var layer = layui.layer,form = layui.form,$=layui.jquery;

            layui.code();

            $('a.del').on('click',function(){
                $.post('/apidocs/'+$(this).attr('data-val'),{ _method:'delete',_token:'{{csrf_token()}}' },function(){
                    window.location.href='/apidocs';
                });
            });


        });


    </script>

@endsection
