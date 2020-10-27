<?php /*a:1:{s:80:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\stat\advice.html";i:1603250454;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>意见建议</title>
    <meta name="Description" content="现场管理"/>
    <meta name="renderer" content="意见建议">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/livemanage/public/static/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/livemanage/public/static/layui/css/layui.css">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]> -->
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>

    <style type="text/css">
        body{overflow-y: scroll;}
        .box{
            margin: 20px 10px;
        }
    </style>
</head>

<body>
<div class="box">
    <table class="layui-hide" id="tableData"></table>
</div>
<script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">

    layui.use(['table'], function(){
        var table = layui.table

        table.render({
            elem: '#tableData'
            ,method: "post"
            ,url:"<?php echo url('web/Stat/adviceList'); ?>"
            ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                //,curr: 1 //设定初始在第 1 页
                ,groups: 3 //只显示 1 个连续页码
                ,first: true //不显示首页
                ,last: true //不显示尾页
            }
            ,limit:20
            ,cols: [[
                {field:'mall',  title: '门店', minWidth: 150}
                ,{field:'area',  title: '区域', sort: true, minWidth: 150}
                // ,{field:'name',  title: '姓名', minWidth: 150}
                ,{field:'advice', title: '建议', sort: true, minWidth: 300}
                ,{field:'create_time', title: '创建时间', minWidth: 150}
            ]]
        });

    });
</script>

</body>

</html>
