<?php /*a:1:{s:80:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\login\index.html";i:1602754495;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="/livemanage/public/static/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/livemanage/public/static/layui/css/font.css">
    <link rel="stylesheet" href="/livemanage/public/static/layui/css/layui.css?">
	<link rel="stylesheet" href="/livemanage/public/static/layui/css/weadmin.css">

</head>
<body class="login-bg">

    <div class="login">
        <div class="message">现场管理登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" >
            <input name="name" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input class="loginin" value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
    <script src="/livemanage/public/static/layui/layui.js"></script>
    <script type="text/javascript">
            layui.use(['form'], function(){
              var form = layui.form
                  ,$ = layui.jquery
              //监听提交
              form.on('submit(login)', function(data){
                  console.log(data.field)
                  $.ajax({
                      type: "post",
                      url: "<?php echo url('web/Login/checkLogin'); ?>",
                      dataType: "json",
                      contentType: "application/json",
                      async: false,
                      data: JSON.stringify(data.field)
                  })
                      .then(function (res) {
                          if (res.code == 0) {
                              layer.msg('登录成功');
                              location.href='<?php echo url('web/index/index'); ?>'
                          } else {
                              layer.msg(res.msg);
                          }
                      })
                      .fail(function (err) {
                          layer.msg(err.msg);
                      });
                  return false;
              });
            });
    </script>
    <!-- 底部结束 -->
</body>
</html>
