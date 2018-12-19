<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('/favicon_new.ico')}}"/>
    <title>Get PtnCoins</title>
    <link href="{{asset('/layui/css/fanfan.css')}}" rel="stylesheet">
    <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class='gcs-login'>

    <div class="gcs-login-panel">

        <div class="login-title">

            <h2>PTN</h2>

        </div>
            <div class="gcs-login-container">

                <input type="text" id="fromAddress" class="input" placeholder="请输入转账地址" />

            </div>
            <div class="gcs-login-container">

                <input type="text" id="toAddress" class="input" placeholder="请输入要转账到的地址" />

            </div>

            <div class="gcs-login-container">

                <div class="gcs-login-validation">

                    <input type="text" id="captcha" class="input validation-input" placeholder="请输入验证码"/>

                    <img  id="codeImg" class="validation-img" src="{{url('/captcha')}}" title="看不清楚？点击换一张" onclick= "changeCode()">

                </div>

            </div>

            <br />

            <br />

            <div class="gcs-login-container">

                <input type="button" value="Get PtnCoins" class="btn-login" />

            </div>
        <div class="gcs-login-container">

            <p id="cpntainer-p"></p>

        </div>
        <input type="hidden" id="uniqid" value="">

        <div class="gcs-login-container">

            <input type="text" id="returnData" class="input" value=""/>

        </div>
    </div>

</div>
<script>
    function changeCode(){
        document.getElementById("codeImg").src="/captcha?t=" + Math.random();

    }
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $("input:button").click(function () {
        var fromAddress = $("#fromAddress").val();
        var toAddress = $("#toAddress").val();
        var captcha = $("#captcha").val();
        $.ajax({
            url: "{{url('/TransferAccounts')}}",
            type: "POST",
            data: 'fromAddress='+fromAddress+'&toAddress='+toAddress+'&captcha='+captcha,
            dataType: "json",  //返回数据的 类型 text|json|html--
            success: function (data) {	//回调函数 和 后台返回的 数据
                if(data.code==200){
                    document.getElementById('uniqid').value=data.uniqid;
                    $str='<span style="color: green">success</span>';
                    $('#cpntainer-p').html($str);
                    getMessage();
                }else{
                    $str='<span style="color: red">'+data.message+'</span>';
                    $('#cpntainer-p').html($str);
                    document.getElementById("codeImg").src="/captcha?t=" + Math.random();
                }

            }
        });

    });
    function getMessage() {
        var uniqid=document.getElementById('uniqid').value;
        $.ajax({
            url: "{{url('/getTransferRecord')}}",
            type: "POST",
            data: 'uniqid='+uniqid,
            dataType: "json",  //返回数据的 类型 text|json|html--
            success: function (data) {	//回调函数 和 后台返回的 数据
                if(data[0].data){
                    console.log(data[0].data);
                    document.getElementById('returnData').value=data[0].data;
                }else {
                    document.getElementById('returnData').value='正在获取数据。。。';
                    setTimeout(getMessage(),5000);
                }
            }
        });
    }

</script>
</body>

</html>