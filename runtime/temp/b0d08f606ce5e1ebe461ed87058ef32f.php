<?php /*a:1:{s:81:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\column\index.html";i:1602754496;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>添加分类</title>
    <meta name="Description" content="现场管理"/>
    <meta name="renderer" content="添加分类">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/livemanage/public/static/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/livemanage/public/static/layui/css/layui.css">
    <!--[if lt IE 9]> -->
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <style type="text/css">
        body{overflow-y: scroll;}
        .box{
            margin: 20px 10px;
        }
        .formWrap{
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #ecf0f1;
            border: 1px solid transparent;
            border-radius: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        }
        .layui-form-item .layui-input-inline {
            width: 285px;
        }
    </style>
</head>

<body>
<div class="box">
    <form class="layui-form formWrap" lay-filter="formData" id="formData" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">栏目名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级名称</label>
            <div class="layui-input-inline">
                <select name="pid" lay-verify="required" lay-search="">
                    <option value="">顶级菜单</option>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['name']); ?></option>
                        <?php if(isset($v['child'])): if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($c['id']); ?>"> ├<?php echo htmlentities($c['name']); ?></option>
                                <?php if(isset($c['child'])): if(is_array($c['child']) || $c['child'] instanceof \think\Collection || $c['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $c['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($m['id']); ?>">  ├├<?php echo htmlentities($m['name']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <?php endif; ?>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php endif; ?>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <!--<div class="layui-form-item" style="display: none;">-->
            <!--<label class="layui-form-label">父级等级</label>-->
            <!--<div class="layui-input-inline">-->
                <!--<input type="text" name="level" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">-->
            <!--</div>-->
        <!--</div>-->
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提 交</button>
            </div>
        </div>
    </form>


</div>

<script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    layui.use(['form'], function(){
        var form = layui.form
            ,layer = layui.layer
            , $ = layui.$;
        //监听提交
        form.on('submit(demo1)', function(data){
            console.log(JSON.stringify(data.field))
            $.ajax({
                type: "post",
                url: "<?php echo url('web/column/add'); ?>",
                dataType: "json",
                contentType: "application/json",
                async: false,
                data: JSON.stringify(data.field)
            })
                .then(function (res) {
                    if (res.code == 0) {
                        layer.msg('提交成功');
                        $("#formData")[0].reset();
                        layui.form.render();
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

</body>

</html>
