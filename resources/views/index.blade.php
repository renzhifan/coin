<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}"  media="all">
    <link rel="stylesheet" href="{{asset('/layui/css/fanfan.css')}}"  media="all">
    <script src="{{asset('/layui/layui.js')}}" charset="utf-8"></script>
    <script src="{{asset('/layui/jquery.min.js')}}" charset="utf-8"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<div class="login-form">
    <div class="login-header" style="text-align: center;">
        <a href="javascript:;" title="关闭" class="login-close close">×</a>
        <h3 class="loginlabel" style="margin-right: auto; margin-left: auto;">{{trans('header.login_header')}}</h3>
    </div>
    <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
        <form action="{{url('/loginPost')}}" method="post">
            {{ csrf_field() }}
            <div class="input" style="min-width: 300px;display: block;margin-bottom: 30px;">
                <label>{{trans('header.login_username')}}</label>
                <input type="text" class="uname" id="uname" name="username" autocomplete="off" spellcheck="false"
                       placeholder="{{trans('header.login_user_message')}}"
                       style="min-width: 300px;min-height: 30px;">
            </div>
            <div class="input" style="min-width: 300px;display: block;margin-bottom: 30px;">
                <label>{{trans('header.login_pwd')}}</label>
                <input type="password" class="upwd" id="upwd" name="pwd" autocomplete="off" spellcheck="false"
                       placeholder="{{trans('header.login_pwd_message')}}"
                       style="min-width: 300px;min-height: 30px;">
            </div>
            <div class="form-group">
                <button style="background-color: #5177f2;
    border-color: #5177f2;" type="submit"
                        class="btn btn-info btn-lg btn-block">{{trans('header.header_login')}}</button>
            </div>
        </form>
    </div>
</div>
<div class="login-form-mask"></div>
<script>
    //设置登录页面弹出效果
    jQuery(document).ready(function ($) {
        $('#nav-login').click(function () {
            $('.login-form-mask').fadeIn(100);
            $('.login-form').slideDown(200);
        })
        $('#nav_login').click(function () {
            $('.login-form-mask').fadeIn(100);
            $('.login-form').slideDown(200);
        })
        $('.login-close').click(function () {
            $('.login-form-mask').fadeOut(100);
            $('.login-form').slideUp(200);
        })
    })
</script>

</body>
</html>