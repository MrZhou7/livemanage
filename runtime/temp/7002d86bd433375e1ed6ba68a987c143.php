<?php /*a:1:{s:80:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\stat\market.html";i:1603250137;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>市调对标</title>
    <meta name="Description" content="现场管理" />
    <meta name="renderer" content="市调对标">
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
        <div class="layui-form search-box layui-form-sm well" action="">
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
    <script type="text/html" id="imgService">
    {{# var srr=d.service.pic.split("{|}");var txt=d.service.explanation.split("{|}");
    for(var j in srr) { srr[j] }}
    <div style="margin:0 10px; display:inline-block !important; display:inline;  max-width:70px; max-height:50px;">

        <img style=" max-width:70px; max-height:50px;" src="https://report.ouyada.com/livemanage/public/{{srr[j]}}" data-txt="{{txt[j]}}" onclick="previewImg(this)" />

    </div>
    {{# } }}
</script>
    <script type="text/html" id="imgEnviroment">
    {{# var srr=d.enviroment.pic.split("{|}");var txt=d.enviroment.explanation.split("{|}");
    for(var j in srr) { srr[j] }}
    {{# if(srr[j] != '') { }}
    <div style="margin:0 10px; display:inline-block !important; display:inline;  max-width:70px; max-height:50px;">
        <img style=" max-width:70px; max-height:50px;" src="https://report.ouyada.com/livemanage/public/{{srr[j]}}" data-txt="{{txt[j]}}" onclick="previewImg(this)" />
    </div>
    {{# } }}
    {{# } }}
</script>

    <script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">

        function previewImg(obj) {
            var imgHtml = "<img src='" + obj.src + "' width='500px' height='500px'/>" +
                "<p style='margin-bottom: 10px;line-height:50px'><span style='font-weight: bolder'>说明：</span>" + obj.dataset.txt + "</p>";
            //弹出层
            layer.open({
                type: 1,
                shade: 0.8,
                offset: 'auto',
                area: "500px",  // area: [width + 'px',height+'px']  //原图显示
                shadeClose: true,
                scrollbar: false,
                title: "查看", //不显示标题
                content: imgHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                cancel: function () {
                    //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                }
            });
        }

        layui.use(['form', 'laytpl', 'table', 'laydate'], function () {
            var layer = layui.layer
                , $ = layui.jquery
                , form = layui.form
                , table = layui.table
                , laytpl = layui.laytpl
                , laydate = layui.laydate;

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
                            getMall(value)
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
                    getMall(data.value)
                }
            });


            var tableIns = table.render({
                elem: '#tableData'
                , method: "post"
                , url: "<?php echo url('web/stat/marketList'); ?>"
                , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 1 //设定初始在第 1 页
                    , groups: 3 //只显示 1 个连续页码
                    , first: true //不显示首页
                    , last: true //不显示尾页
                }
                , limit: 20
                , cols: [[
                    { field: 'area_name', title: '所在区域', minWidth: 100 }
                    , { field: 'mall', title: '所在门店', sort: true, minWidth: 100 }
                    , { field: 'name', title: '市调人', sort: true, minWidth: 100 }
                    , { field: 'project_name', title: '市调项目名称', minWidth: 100 }
                    , { field: 'developer', title: '开发商', minWidth: 100 }
                    , { field: 'start', title: '开业时间', minWidth: 100 }
                    , { field: 'address', title: '地址', minWidth: 100 }
                    , { field: 'area', title: '经营面积', minWidth: 100 }
                    , { field: 'floor', title: '商业楼层', minWidth: 100 }
                    , { field: 'level', title: '档次定位', minWidth: 100 }
                    , { field: 'parking_num', title: '停车位数量', minWidth: 100 }
                    , { field: 'constmer_num', title: '经营商户数量', minWidth: 100 }
                    , { field: 'rent', title: '租金情况及形式', minWidth: 100 }
                    , { field: 'service', title: '顾客服务亮点图片及说明', minWidth: 260, templet: "#imgService" }
                    , { field: 'enviroment', title: '空间环境亮点图片及说明', minWidth: 260, templet: "#imgEnviroment" }
                    // ,{field:'service_pic', title: '顾客服务亮点图片', minWidth: 150,}
                    // ,{field:'service_explanation', title: '顾客服务亮点说明', minWidth: 150}
                    // ,{field:'enviroment_pic', title: '空间环境亮点图片', minWidth: 150}
                    // ,{field:'enviroment_explanation', title: '空间环境亮点说明', minWidth: 150}
                    , { field: 'enlighten', title: '启发与借鉴', minWidth: 100 }
                    , { field: 'advice', title: '对商场营运的意见与建议', minWidth: 100 }
                    , { field: 'create_time', title: '创建日期', minWidth: 100 }
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
            });

            function getMall(data) {
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