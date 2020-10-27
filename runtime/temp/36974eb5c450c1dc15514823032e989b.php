<?php /*a:1:{s:79:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\stat\scene.html";i:1603250403;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>人员统计</title>
    <meta name="Description" content="现场管理" />
    <meta name="renderer" content="我在现场">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/livemanage/public/static/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/livemanage/public/static/layui/css/layui.css">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]> -->
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>

    <style type="text/css">
        body {
            overflow-y: scroll;
        }

        .layui-row {
            padding: 10px 0;
        }

        .well {
            min-height: 20px;
            margin: 20px 0;
            margin-bottom: 20px;
            background-color: #ecf0f1;
            border: 1px solid transparent;
            border-radius: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="layui-fluid">
        <div class="layui-form well" action="">
            <div class="layui-row">
                <div class="layui-col-sm4" id="area"></div>
                <div class="layui-col-sm4">
                    <label class="layui-form-label">选择门店</label>
                    <div class="layui-input-block">
                        <select name="mall" lay-filter="mall" id="mall"></select>
                    </div>
                </div>
                <div class="layui-col-sm4">
                    <label class="layui-form-label">请选择日期</label>
                    <div class="layui-input-block">
                        <input type="text" class="layui-input" id="date" placeholder="日期">
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <label class="layui-form-label"></label>
                <div class="layui-inline">
                    <button class="layui-btn" id="btn">查 询</button>
                </div>
            </div>
        </div>

        <table class="layui-hide" id="tableData"></table>
    </div>

    <script id="formArea" type="text/html">
        <label class="layui-form-label">选择区域</label>
        <div class="layui-input-block">
            <select name="area"  lay-filter="area">
                {{# layui.each(d,function(index,item){ }}
                <option value="{{item.id}}">{{item.subcompanyname}}</option>
                {{#});}}
            </select>
        </div>
</script>

    <script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">

        layui.use(['form', 'laytpl', 'table', 'laydate'], function () {
            var layer = layui.layer
                , $ = layui.jquery
                , form = layui.form
                , table = layui.table
                , laytpl = layui.laytpl
                , laydate = layui.laydate

            laydate.render({
                elem: '#date'
                , range: '~'
                , max: 0
            });

            $.ajax({
                type: "post",
                url: "<?php echo url('web/stat/getQuyu'); ?>",
                dataType: "json",
                contentType: "application/json",
                async: false
            })
                .then(function (res) {
                    if (res.code == 0) {
                        console.log(res)
                        var formMenu = document.getElementById("formArea").innerHTML; var view = document.getElementById("area");
                        laytpl(formMenu).render(res.data, function (html) {
                            view.innerHTML = html;
                            let value = $("select[name='area']").val();
                                geiMall(value)
                            form.render();
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                })
                .fail(function (err) {
                    layer.msg(err.msg);
                });

            form.on('select(area)', function (data) {
                if ($("select[name='area']").val() != '') {
                    geiMall(data.value)
                }
            });

            var tableIns = table.render({
                elem: '#tableData'
                , method: "post"
                , url: "<?php echo url('web/stat/sceneList'); ?>"
                , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 1 //设定初始在第 1 页
                    , groups: 3 //只显示 1 个连续页码
                    , first: true //不显示首页
                    , last: true //不显示尾页
                }
                , limit: 20
                , cols: [[
                    { field: 'mall', title: '门店', minWidth: 150 }
                    , { field: 'area', title: '区域', sort: true, minWidth: 150 }
                    , { field: 'name', title: '姓名', minWidth: 150 }
                    , { field: 'holiday', title: '请假天数', sort: true, minWidth: 150 }
                    , { field: 'count', title: '我在现场数量', minWidth: 150 }
                    , { field: 'record', title: '事项记录数量', minWidth: 150 }
                    , { field: 'help', title: '寻求帮助数量', minWidth: 150 }
                ]]
            });

            $(document).on('click', '#btn', function () {
                var list = $('#date').val().split("~");
                tableIns.reload({
                    where: { //设定异步数据接口的额外参数，任意设
                        area_id: $("select[name='area']").val(),
                        mall_id: $("select[name='mall']").val(),
                        start: list[0],
                        end: list[1]
                    }
                });
            })

            function geiMall(data) {
                    $.ajax({
                        type: "post",
                        url: "<?php echo url('web/stat/getMall'); ?>",
                        dataType: "json",
                        contentType: "application/json",
                        async: false,
                        data: JSON.stringify({ area_id: data })
                    })
                        .then(function (res) {
                            if (res.code == 0) {
                                var mallInfo = '';
                                for (var i in res.data) {
                                    mallInfo += "<option value='" + res.data[i].id + "'>" + res.data[i].subcompanyname + "</option>"
                                }
                                $("select[name='mall']").html(mallInfo);
                                form.render();
                            } else {
                                layer.msg(res.msg);
                            }
                        })
                        .fail(function (err) {
                            layer.msg(err.msg);
                        });
                }
        });
    </script>

</body>

</html>