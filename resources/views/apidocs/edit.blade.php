@extends('public/layout')

@section('title','编辑')

@section('content')
    <div class="layui-fluid">

        <div class="layui-row content" id="item-create" >

            <div class="layui-col-md6 left" >
                <div class="layui-row api-item" >
                    <div class="layui-col-md12" >

                        <div class="layui-row api-item-name" >
                            <div class="layui-col-md12" >
                                <div class="layui-card">
                                    <form class="layui-form" action="/apidocs/store">

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">api名称</label>
                                            <div class="layui-input-block">
                                                <input type="text" v-model="name" required  lay-verify="required"  autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item layui-form-text">
                                            <label class="layui-form-label">api描述</label>
                                            <div class="layui-input-block">
                                                <textarea v-model="descript"  class="layui-textarea"></textarea>
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">请求地址</label>
                                            <div class="layui-input-block">
                                                <input type="text" v-model="path" required  lay-verify="required"  autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">请求方法</label>
                                            <div class="layui-input-block">
                                                <input type="text" v-model="method" required  lay-verify="required"  autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">参数列表</label>
                                            <div class="layui-input-block">
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
                                                        <th>操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr v-for="(param,index) in params" >
                                                        <td><input type="text" v-model="param.name" required  lay-verify="required"  autocomplete="off" class="layui-input"></td>
                                                        <td><input type="text" v-model="param.type" required  lay-verify="required"  autocomplete="off" class="layui-input"></td>
                                                        <td><input type="text" v-model="param.example" required  lay-verify="required"  autocomplete="off" class="layui-input"></td>
                                                        <td><input type="text" v-model="param.descript" required  lay-verify="required"  autocomplete="off" class="layui-input"></td>
                                                        <td>
                                                            <button v-if="index==0" class="layui-btn" v-on:click="addItem" onclick="return false;" >增加</button>
                                                            <button v-else class="layui-btn layui-btn-warm" v-on:click="removeItem(index)" onclick="return false;" >删除</button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="layui-form-item layui-form-text">
                                            <label class="layui-form-label">请求示例</label>
                                            <div class="layui-input-block">
                                                <textarea v-model="request"  class="layui-textarea"></textarea>
                                            </div>
                                        </div>

                                        <div class="layui-form-item layui-form-text">
                                            <label class="layui-form-label">响应示例</label>
                                            <div class="layui-input-block">
                                                <textarea v-model="response"  class="layui-textarea"></textarea>
                                            </div>
                                        </div>


                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md6 right" >
                <div class="layui-row api-item" >
                    <div class="layui-col-md12" >

                        <div class="layui-row api-item-name" >
                            <div class="layui-col-md12" >
                                <div class="layui-card">
                                    <div class="layui-card-body">
                                        <h2><a href="#" name="posts" v-html="name" ></a></h2>
                                        <p v-html="descript"></p>
                                        <h3>请求地址</h3>
                                        <p v-html="path"></p>
                                        <h3>请求方法</h3>
                                        <p v-html="method"></p>
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="param in params" >
                                                <td v-html="param.name"></td>
                                                <td v-html="param.type"></td>
                                                <td v-html="param.example"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <h3>请求示例</h3>
                                        <pre class="layui-code" lay-skin="eclipose" encode="true" v-html="request" ></pre>
                                        <h3>响应示例</h3>
                                        <pre class="layui-code" lay-skin="eclipose" encode="true" v-html="response" ></pre>
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



        var data = JSON.parse(`{!! $doc !!}`);
        data._method = 'put';
        data._token = '{{csrf_token()}}';

        var vm = new Vue({
            el:"#item-create",
            data:function(){
                return data;
            },
            methods:{
                addItem:function(){
                    this.params.push({name:'',type:'',example:'',descript:''});
                },
                removeItem:function(index){
                    this.params.splice(index,1);
                }
            }
        });

        //一般直接写在一个js文件中
        layui.use(['layer', 'form','code'], function(){
            var layer = layui.layer,form = layui.form,$ = layui.jquery;
            form.on('submit',function(form){
                $.post("/apidocs/"+data.id,vm.$data,function(response){
                    layer.msg('修改成功');
                    window.location.href = "/apidocs";
                });
                return false;
            });
            layui.code();
        });

    </script>

@endsection

