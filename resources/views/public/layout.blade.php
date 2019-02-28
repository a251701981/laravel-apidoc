<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title','请 设置标题')</title>

    <link rel="stylesheet" href="{{$ROOT_PATH}}layui/css/layui.css">
    @yield('ext-style');
</head>
<body>

@section('content')

@show


<script src="{{$ROOT_PATH}}layui/layui.js"></script>
<script src="{{$ROOT_PATH}}js/vue.min.js"></script>
@yield('ext-script')

</body>
</html>
