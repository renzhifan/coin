<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('/favicon_new.ico')}}"/>
    <title>PalletOne testnet faucet</title>
    <link href="{{asset('/layui/css/fanfan.css')}}" rel="stylesheet">
    <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class='gcs-login'>

    <div class="gcs-login-panel">

        <div class="login-title">
            <div class="gcs-login-container">

            <p style="font-size: 40px;">PalletOne testnet faucet</p>
            </div>

        </div>
            <div class="gcs-login-container">

                <input type="text" id="toAddress" class="input" placeholder="Your testnet address" />

            </div>

            <div class="gcs-login-container">

                <div class="gcs-login-validation">

                    <input type="text" id="captcha" class="input validation-input" placeholder="Please enter the validation code"/>

                    <img  id="codeImg" class="validation-img" src="{{url('/captcha')}}" title="看不清楚？点击换一张" onclick= "changeCode()">

                </div>

            </div>

            <br />

            <br />

            <div class="gcs-login-container">

                <input type="button" value="Get PTN" class="btn-login" is_click="0" onclick="cl($(this))"/>

            </div>
        <div class="gcs-login-container">

            <p id="cpntainer-p"></p>

        </div>
        <input type="hidden" id="uniqid" value="">

        <div class="gcs-login-container">

            <input  id="returnData"  class="input" value="" style="display: none"/>

        </div>
    </div>

</div>
<script>

    function cl(obj){
        var is_click=obj.attr('is_click');
        if(is_click==0){
            obj.attr('is_click','1');
            setTimeout(function(){
                obj.attr('is_click','0');
            },3000);
        }else{
            alert('请在间隔3秒后再次点击操作');
        }
    }

    function changeCode(){
        document.getElementById("codeImg").src="/captcha?t=" + Math.random();

    }

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $("input:button").click(function () {
        var toAddress = $("#toAddress").val();
        var captcha = $("#captcha").val();
        $.ajax({
            url: "{{url('/TransferAccounts')}}",
            type: "POST",
            data: 'toAddress='+toAddress+'&captcha='+captcha,
            dataType: "json",  //返回数据的 类型 text|json|html--
            success: function (data) {	//回调函数 和 后台返回的 数据
                if(data.code==200){
                    document.getElementById("codeImg").src="/captcha?t=" + Math.random();
                    document.getElementById('uniqid').value=data.uniqid;
                    $str='<span style="color: green">success</span>';
                    $('#cpntainer-p').html($str);
                    getMessage();
                }else{
                    document.getElementById("codeImg").src="/captcha?t=" + Math.random();
                    $str='<span style="color: red">'+data.message+'</span>';
                    $('#cpntainer-p').html($str);
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
                    $('#returnData').show();
                    document.getElementById('returnData').value=data[0].data;
                }else {
                    $('#returnData').show();
                    document.getElementById('returnData').value='正在获取数据。。。';
                    setTimeout(getMessage(),5000);
                }
            }
        });
    }

</script>
</body>

</html>