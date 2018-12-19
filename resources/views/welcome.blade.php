<head>
    <script language="JavaScript" type="text/JavaScript">
        <!--
        var refreshtime = 1000;
        function refpage(values){
            document.getElementById("showmsg").innerHTML='<br>请稍候...';

            var url = "refreshpage.asp?id="+values;
            request.open("POST", url, false);
            request.send();
//接收返回数据并更新内容
            var retVal = request.responseText;
//数据处理(略)
//内容显示
            document.getElementById("showmsg").innerHTML='......';
        }

        function focusbody(){
//本窗口被显示,定时发送信息;
            refreshtime=90000;
            show2()
        }

        function show2(){
            if(refreshtime>0){
                sendstate(1); //假设的参数
                setTimeout("show2()",refreshtime); //循环计数
            }
        }
        //-->
    </script>
</head>
<body onload="focusbody();">
.....网页内容
</body>
</html>