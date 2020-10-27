<?php /*a:1:{s:102:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\evaluation\month_clean_assessment.html";i:1603683118;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>月度保洁质量评定表</title>
    <meta name="Description" content="现场管理" />
    <meta name="renderer" content="月度保洁质量评定表">
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

        .box {
            padding: 20px;
            background-color: #ecf0f1;
        }

        .wrap {
            border: 1px solid #e6e6e6;
            padding-left: 10px;
        }

        .prompt {
            padding: 10px 50px;
            color: #CF1322;
        }

        .newWidth {
            width: 180px;
        }

        h3 {
            text-align: center;
            color: #CF1322;
        }

        h6 {
            text-align: center;
            font-size: 12px;
        }

        .weekInput {
            text-align: center;
            font-size: 12px;
            color: #CF1322;
        }

        .layui-label-required::before {
            content: "*";
            color: #ff0000;
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
                    <button class="layui-btn" id="btnPop">修改合同信息</button>
                    <button class="layui-btn" id="export">导出</button>
                </div>
            </div>
        </div>
        <div id="export_content">
            <h3>保洁月度结算汇总</h3>
            <h6>(商管部对每日评分结果及保洁考勤结果负责，门店财务部对保洁费用结算金额负责。)</h6>
            <table class="layui-hide" id="tableDataTwo"></table>
            <table class="layui-hide" id="tableData"></table>
            <div class="layui-row wrap">备注: </div>
            <div class="layui-row wrap" style="border-top:none">
                <div class="layui-col-xs3">
                    <div class="grid-demo grid-demo-bg1">保洁经理签字：</div>
                </div>
                <div class="layui-col-xs3">
                    <div class="grid-demo">商管经理签字：</div>
                </div>
                <div class="layui-col-xs3">
                    <div class="grid-demo grid-demo-bg1">财务经理签字：</div>
                </div>
                <div class="layui-col-xs3">
                    <div class="grid-demo">商场总经理签字：</div>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.bootcss.com/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdn.bootcss.com/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

    <script id="tplDate" type="text/html">
    <form class="layui-form box">
        <div class="layui-form-item">
            <label class="layui-form-label newWidth layui-label-required">本月合同金额</label>
            <div class="layui-input-inline">
                <input type="num" name="money" lay-nullText="合同金额不能为空"
                       placeholder="请输入本月合同金额" onblur="onlyNumber(this)"
                       class="layui-input layui-input-md" lay-verify="required" id="money">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label newWidth layui-label-required">应到人数(合同日均至少)</label>
            <div class="layui-input-inline">
                <input type="num" name="num" lay-nullText="应到人数不能为空"
                       placeholder="请输入应到人数" onblur="onlyNumber(this,8)"
                       class="layui-input layui-input-md" lay-verify="required" id="num">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label newWidth">本月无需服务日期(带薪)</label>
            <div class="layui-input-inline">
                <input type="text" name="week_day" placeholder="日期"
                class="layui-input" id="week_day">
            </div>
        </div>
        <p class="weekInput">输入本月无需服务日，用英文逗号分隔，例如: 7,8,9,10</p>
    </form>
    <div class="prompt">
        如春节期间，当月自然月30天，放假3天，实际服务天数27天，将无需服务的日期选中，即为带薪无需服务日。其余无特殊情况无需选择此项。
    </div>
</script>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        layui.use(['form', 'laytpl', 'table', 'laydate', 'layer'], function () {
            var layer = layui.layer
                , $ = layui.jquery
                , form = layui.form
                , table = layui.table
                , laytpl = layui.laytpl
                , laydate = layui.laydate

            laydate.render({
                elem: '#date'
                , format: 'yyyy-MM'
                , type: 'month'
                , max: 0
                , value: new Date()
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
                , url: "<?php echo url('web/Evaluation/monthCleanAssessmentReport'); ?>"
                , limit: 9999
                , where: {
                    area_id: $("select[name='area']").val(),
                    mall_id: $("select[name='mall']").val(),
                    date: $('#date').val()
                }
                , parseData: function (res) { //res 即为原始返回的数据
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "data": res.data.list //解析数据列表
                    };
                }
                , cols: [[
                    { field: 'day', title: '日期', width: 80, align: 'center' }
                    , { field: 'week', title: '星期', width: 100, align: 'center' }
                    , { field: 'arrived_morning', title: '实际到岗人数(上午)', width: 180, align: 'center' }
                    , { field: 'arrived_afternoon', title: '实际到岗人数(下午)', width: 180, align: 'center' }
                    , { field: 'num_morning', title: '晨巡扣分', width: 100, align: 'center' }
                    , { field: 'num_afternoon', title: '午巡扣分', width: 100, align: 'center' }
                    , { field: 'average', title: '当日晨巡午巡平均扣分((晨巡扣分+午巡扣分)/2)', width: 330, align: 'center' }
                    , { field: 'fee', title: '扣费比例', width: 90, align: 'center' }
                    , { field: 'day_lock', title: '保洁质量当日扣款(每日服务费*扣费比例)', width: 290, align: 'center' }
                ]]

            });

            var tableInsTwo = table.render({
                elem: '#tableDataTwo'
                , method: "post"
                , url: "<?php echo url('web/Evaluation/monthCleanAssessmentReport'); ?>"
                , limit: 9999
                , where: {
                    area_id: $("select[name='area']").val(),
                    mall_id: $("select[name='mall']").val(),
                    date: $('#date').val()
                }
                , parseData: function (res) { //res 即为原始返回的数据
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "data": [res.data.main] //解析数据列表
                    };
                }
                , cols: [[
                    { field: 'service_day', title: '本月服务天数', width: 120, align: 'center' }
                    , { field: 'money', title: '本月合同金额', width: 120, align: 'center' }
                    , { field: 'num', title: '应到人数(合同日均至少)', width: 190, align: 'center' }
                    , { field: 'lock', title: '月平均缺岗人数', width: 130, align: 'center' }
                    , { field: 'month_attend_rate', title: '当月考勤率', width: 110, align: 'center' }
                    , { field: 'day_unit', title: '人均每日单价', width: 120, align: 'center' }
                    , { field: 'day_money', title: '每日服务费', width: 100, align: 'center' }
                    , { field: 'dec_money1', title: '保洁人员应扣款小计', width: 160, align: 'center' }
                    , { field: 'dec_money2', title: '保洁质量应扣款小计', width: 160, align: 'center' }
                    , { field: 'dec_money', title: '本月合计扣款', width: 120, align: 'center' }
                    , { field: 'money_all', title: '实际结算金额', width: 120, align: 'center' }
                ]]
            });

            $(document).on('click', '#btn', function () {
                tableIns.reload({
                    where: { //设定异步数据接口的额外参数，任意设
                        area_id: $("select[name='area']").val(),
                        mall_id: $("select[name='mall']").val(),
                        date: $('#date').val()
                    }
                });
                tableInsTwo.reload({
                    where: { //设定异步数据接口的额外参数，任意设
                        area_id: $("select[name='area']").val(),
                        mall_id: $("select[name='mall']").val(),
                        date: $('#date').val()
                    }
                });
            })

            $(document).on('click', '#btnPop', function () {
                if (!$('#date').val() || !$("select[name='mall']").val()) {
                    layer.msg("请选择门店和日期");
                    return false;
                }
                layer.open({
                    type: 1,
                    title: '请完善信息，计算表格',
                    btn: ['保存', '取消'],
                    area: ['500px', '400px'],
                    content: $('#tplDate').html(),
                    resize: false,
                    scrollbar: false,
                    shadeClose: false,
                    shade: [0.3, '#000'],
                    success: function () {
                        $.ajax({
                            type: "post",
                            url: "<?php echo url('web/Evaluation/getContractInfo'); ?>",
                            dataType: "json",
                            contentType: "application/json",
                            async: false,
                            data: JSON.stringify({ date: $('#date').val(), mall_id: $("select[name='mall']").val() })
                        })
                            .then(function (res) {
                                if (res.code == 0) {
                                    if (Object.keys(res.data) != 0) {
                                        $("input[name='money']").val(res.data.money)
                                        $("input[name='num']").val(res.data.num)
                                        $("input[name='week_day']").val(res.data.week_day)
                                    }
                                } else {
                                    layer.msg(res.msg);
                                }
                            })
                            .fail(function (err) {
                                layer.msg(err.msg);
                            });
                    },
                    yes: function (index) {
                        let data = {
                            mall: $("#mall").find("option:selected").text(),
                            mall_id: $("select[name='mall']").val(),
                            date: $('#date').val(),
                            money: $("input[name='money']").val(),
                            num: $("input[name='num']").val(),
                            week_day: $("input[name='week_day']").val()
                        }
                        if (!data.money || !data.num) {
                            layer.msg("请完善表单内容");
                            return;
                        }
                        if (data.week_day) {
                            var v = week_day.value.split(',');
                            for (let index = 0; index < v.length; index++) {
                                if (v[index] > 31) {
                                    layer.msg('请输入正确的日期');
                                    return false;
                                }
                            }
                        }
                        $.ajax({
                            type: "post",
                            url: "<?php echo url('web/Evaluation/saveContractInfo'); ?>",
                            dataType: "json",
                            contentType: "application/json",
                            async: false,
                            data: JSON.stringify(data)
                        })
                            .then(function (res) {
                                if (res.code == 0) {
                                    layer.msg("保存成功");
                                    layer.close(index);
                                } else {
                                    layer.msg(res.msg);
                                }
                            })
                            .fail(function (err) {
                                layer.msg(err.msg);
                            });
                    }
                });
            })
            window.onlyNumber = function (obj, num) {
                //先把非数字的都替换掉，除了数字.
                obj.value = obj.value.replace(/[^\d\.]/g, '');
                //必须保证第一个为数字而不是.
                obj.value = obj.value.replace(/^\./g, '');
                //保证只有出现一个.而没有多个.
                obj.value = obj.value.replace(/\.{2,}/g, '.');
                //保证.只出现一次，而不能出现两次以上
                obj.value = obj.value.replace('.', '$#$').replace(/\./g, '').replace('$#$', '.');
                //保证小数点后只有1位
                if (num == 8 && obj.value.indexOf('.') != -1) {
                    var v = obj.value.split('.');
                    if (v[1].length > 1) {
                        obj.value = v[0] + '.' + v[1].substring(0, 1)
                    }
                }
            };
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
            $("#export").click(function(){
                const that = this;
                html2canvas(
                    document.getElementById("export_content"),
                    {
                        dpi: 172, // 导出pdf清晰度
                        onrendered: function (canvas) {
                            var contentWidth = canvas.width;
                            var contentHeight = canvas.height;

                            // 一页pdf显示html页面生成的canvas高度;
                            var pageHeight = contentWidth / 592.28 * 841.89;
                            // 未生成pdf的html页面高度
                            var leftHeight = contentHeight;
                            // pdf页面偏移
                            var position = 0;
                            // html页面生成的canvas在pdf中图片的宽高（a4纸的尺寸[595.28,841.89]）
                            var imgWidth = 595.28;
                            var imgHeight = 592.28 / contentWidth * contentHeight;

                            var pageData = canvas.toDataURL('image/jpeg', 1.0);
                            var pdf = new jsPDF('', 'pt', 'a4');

                            // 有两个高度需要区分，一个是html页面的实际高度，和生成pdf的页面高度(841.89)
                            // 当内容未超过pdf一页显示的范围，无需分页
                            if (leftHeight < pageHeight) {
                                pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight);
                            } else {
                                while (leftHeight > 0) {
                                    pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                                    leftHeight -= pageHeight;
                                    position -= 841.89;
                                    // 避免添加空白页
                                    if (leftHeight > 0) {
                                        pdf.addPage();
                                    }
                                }
                            }
                            pdf.save($("#mall").find("option:selected").text() + '月度保洁质量评定表.pdf');
                        },
                        // 背景设为白色（默认为黑色）
                        background: '#fff'
                    })
            });
        });
    </script>
    <script type="text/html" id="index">
    {{d.LAY_TABLE_INDEX+1}}
</script>

</body>

</html>