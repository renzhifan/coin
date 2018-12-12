<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('/favicon_new.ico')}}"/>
    <title>Get PtnCoins</title>
    <link href="{{asset('/layui/css/fanfan.css')}}" rel="stylesheet">
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