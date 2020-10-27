<?php /*a:1:{s:82:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\article\index.html";i:1602754495;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>添加文章</title>
    <meta name="Description" content="现场管理"/>
    <meta name="renderer" content="添加文章">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=devic  e-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
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
        .layui-form-item {
             margin-bottom: 0px;
        }
        #container{
            width:80%;
        }
        .layui-form-item .layui-input-inline {
            width: 285px;
        }
        .layui-form-selected dl {
            z-index: 1000;
        }
    </style>
</head>

<body>
<div class="box">
    <form class="layui-form" action="">
        <table class="layui-table" lay-even="">
            <!--<colgroup>-->
                <!--<col width="150">-->
                <!--<col width="150">-->
                <!--<col width="200">-->
                <!--<col>-->
            <!--</colgroup>-->
            <tbody>
            <tr>
                <td>分类</td>
                <td>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <select name="column" lay-verify="required" lay-search="">
                                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['name']); ?></option>
                                <?php if(isset($v['child'])): if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($c['id']); ?>"> ├<?php echo htmlentities($c['name']); ?></option>
                                <?php if(isset($c['child'])): if(is_array($c['child']) || $c['child'] instanceof \think\Collection || $c['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $c['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($m['id']); ?>"> ├├<?php echo htmlentities($m['name']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <?php endif; ?>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <?php endif; ?>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>标题</td>
                <td>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" name="sort" lay-verify="title" autocomplete="off" placeholder="请输入排序" class="layui-input">
                        </div>
                    </div>
                </td>
            </tr>


            <tr>
                <td>置顶</td>
                <td>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="checkbox" name="hot" lay-skin="switch" lay-text="ON|OFF">
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>内容</td>
                <td>
                    <div id="test7" class="demo-tree"></div>
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="content" type="text/plain"></script>
                    <!-- 配置文件 -->
                    <script type="text/javascript" charset="utf-8" src="/livemanage/public/static/ueditor/ueditor.config.js"></script>
                    <!-- 编辑器源码文件 -->
                    <script type="text/javascript" charset="utf-8" src="/livemanage/public/static/ueditor/ueditor.all.js"></script>
                    <script type="text/javascript" charset="utf-8" src="/livemanage/public/static/ueditor/lang/zh-cn/zh-cn.js"></script>
                </td>
            </tr>

            </tbody>
        </table>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container', {
        toolbars: [
            ['fullscreen', 'source', 'undo', 'redo'],
            ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset',
                'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','horizontal',
                'fontsize','simpleupload','insertimage','directionalityltr','tolowercase','justifyleft','justifyright','justifycenter','justifyjustify'
            ]
        ],
        autoHeightEnabled: true,
        autoFloatEnabled: true
    });
    ue.ready(function() {
        ue.setHeight(400);
    });


    layui.use(['form'],function(){
        var form = layui.form
            ,$ = layui.jquery;
        //监听提交
        form.on('submit(demo1)', function(data){
            if(data.field.hot == 'on'){
                data.field.hot = 1
            }else{
                data.field.hot = 0
            }
            // layer.alert(JSON.stringify(data.field), {
            //     title: '最终的提交信息'
            // })
            console.log(data.field);
            $.ajax({
                type: "post",
                url: "<?php echo url('web/article/add'); ?>",
                dataType: "json",
                contentType: "application/json",
                async: false,
                data: JSON.stringify(data.field)
            })
                .then(function (res) {
                    if (res.code == 0) {
                        layer.msg('提交成功');
                        window.location.href = "<?php echo url('web/article/lists'); ?>";
                    } else {
                        layer.msg(res.msg);
                    }
                })
                .fail(function (err) {
                    layer.msg(err.msg);
                });
            return false;
        });
    })


</script>

</body>

</html>
