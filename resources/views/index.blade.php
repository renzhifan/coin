<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('/favicon_new.ico')}}"/>
    <title>Get PtnCoins</title>

    <style type="text/css">

        * {

            padding: 0;

            margin: 0;

            font-family: "微软雅黑";

        }

        /*右边登陆框开始*/

        .gcs-login {

            position: absolute;

            right: 0px;

            box-sizing: border-box;

            width: 100%;

            height: 100%;

            background-color: #E6E6E6;

            z-index: 100;

        }

        .gcs-login .gcs-login-panel{

            height: 360px;

            position:absolute;

            margin:auto;

            left: 0;

            right: 0;

            top:0;

            bottom: 0;

        }

        .gcs-login .login-title {

            text-align: center;

            color: #62a8ea;

        }

        .gcs-login .login-title h2 {

            letter-spacing: 10px;

        }

        .gcs-login-container {

            width: 100%;

            box-sizing: border-box;

            width: 100%;

            margin: 20px 0 0;

            text-align: center;

        }

        .gcs-login .input {

            border: 1px solid white;

            display: inline-block;

            box-sizing: border-box;

            width: 80%;

            height: 46px;

            padding-left: 10px;

            margin: 0 auto;

            font-size: 14px;

            outline: none;

            color:  #76838f;

        }

        .gcs-login .gcs-login-validation{

            width:80%;

            margin: 0 auto;

            position: relative;

        }

        .gcs-login .validation-input{

            position: absolute;

            width: 250px;

            left: 0px;

        }

        .gcs-login img.validation-img{

            position: absolute;

            cursor:pointer;

            width: 125px;

            height: 45px;
            left :350px;

            /*right: 0px;*/

        }

        .gcs-login .input:focus {

            outline: none;

            border: 1px solid #62a8ea;

        }

        .gcs-login .btn-login {

            background-color: #62a8ea;

            border: none;

            width: 80%;

            height: 45px;

            line-height: 45px;

            color: white;

            cursor: pointer;

            font-size: 16px;

            font-weight: bold;

        }

        .gcs-login .btn-login:hover{

            opacity: 0.9;

        }

        /*右边登陆框结束*/

    </style>

</head>

<body>

<div class='gcs-login'>

    <div class="gcs-login-panel">

        <div class="login-title">

            <h2>PTN</h2>

        </div>
        <form  action="{{url('/TransferAccounts')}}" method="post" >
            {{ csrf_field() }}
            <div class="gcs-login-container">

                <input type="text" name="address" class="input" placeholder="请输入交易地址" />

            </div>

            <div class="gcs-login-container">

                <div class="gcs-login-validation">

                    <input type="text" name="captcha" class="input validation-input" placeholder="请输入验证码"/>

                    <img  id="codeImg" class="validation-img" src="{{url('/captcha')}}" title="看不清楚？点击换一张" onclick= "changeCode()">

                </div>

            </div>

            <br />

            <br />

            <div class="gcs-login-container">

                <input type="submit" value="Get PtnCoins" class="btn-login" />

            </div>
        </form>
    </div>

</div>
<script>
    function changeCode(){
        document.getElementById("codeImg").src="/captcha?t=" + Math.random();

    }

</script>
</body>

</html>