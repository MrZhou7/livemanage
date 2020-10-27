<?php /*a:1:{s:81:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\column\lists.html";i:1602754496;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>分类列表</title>
    <meta name="Description" content="现场管理"/>
    <meta name="renderer" content="分类列表">
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
        .layui-input-block {
             margin-left: 0px;
        }
    </style>
</head>

<body>
<div class="box">


        <div class="layui-inline">
            <div class="layui-input-block">
                <a href="<?php echo url('web/column/index'); ?>"><button class="layui-btn" lay-submit="" lay-filter="demo1">新增</button></a>
            </div>
        </div>


    <table class="layui-table" lay-even="articleDom" lay-skin="row" lay-filter="articleDom">
        <!--<colgroup>-->
            <!--<col width="150">-->
            <!--<col width="150">-->
            <!--<col width="200">-->
            <!--<col>-->
        <!--</colgroup>-->
        <thead>
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>层级</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td class="id"><?php echo htmlentities($v['id']); ?></td>
                    <td><?php echo htmlentities($v['name']); ?></td>
                    <td><?php echo htmlentities($v['level']); ?></td>
                    <td><?php echo htmlentities($v['sort']); ?></td>
                    <td>
<!--                        <a href="<?php echo url('web/column/getinfo',['id'=>$v['id'],'type'=>'get']); ?>"><button type="button" class="layui-btn layui-btn-sm detail">查 看</button></a>-->
                        <a href="<?php echo url('web/column/getinfo',['id'=>$v['id'],'type'=>'edit']); ?>"><button type="button" class="layui-btn layui-btn-normal layui-btn-sm edit">编 辑</button></a>
                        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm del">删 除</button>
                    </td>
                </tr>
                        <?php if(isset($v['child'])): if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td class="id"><?php echo htmlentities($c['id']); ?></td>
                            <td>——<?php echo htmlentities($c['name']); ?></td>
                            <td><?php echo htmlentities($c['level']); ?></td>
                            <td><?php echo htmlentities($c['sort']); ?></td>
                            <td>
<!--                                <a href="<?php echo url('web/column/getinfo',['id'=>$v['id'],'type'=>'get']); ?>"><button type="button" class="layui-btn layui-btn-sm detail">查 看</button></a>-->
                                <a href="<?php echo url('web/column/getinfo',['id'=>$c['id'],'type'=>'edit']); ?>"><button type="button" class="layui-btn layui-btn-normal layui-btn-sm edit">编 辑</button></a>
                                <button type="button" class="layui-btn layui-btn-danger layui-btn-sm del">删 除</button>
                            </td>
                        </tr>

                            <?php if(isset($c['child'])): if(is_array($c['child']) || $c['child'] instanceof \think\Collection || $c['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $c['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <td class="id"><?php echo htmlentities($m['id']); ?></td>
                                    <td>————<?php echo htmlentities($m['name']); ?></td>
                                    <td><?php echo htmlentities($m['level']); ?></td>
                                    <td><?php echo htmlentities($m['sort']); ?></td>
                                    <td>
<!--                                        <a href="<?php echo url('web/column/getinfo',['id'=>$v['id'],'type'=>'get']); ?>"><button type="button" class="layui-btn layui-btn-sm detail">查 看</button></a>-->
                                        <a href="<?php echo url('web/column/getinfo',['id'=>$m['id'],'type'=>'edit']); ?>"><button type="button" class="layui-btn layui-btn-normal layui-btn-sm edit">编 辑</button></a>
                                        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm del">删 除</button>
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php endif; ?>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,table = layui.table
            ,$ = layui.jquery

        $(document).on('click','.del',function(data){
            var p = $(this).parent('td').siblings('.id').text();
            var arr = {id:p,enabled:0}
            layer.open({
                content: '确定要删除吗？',
                yes: function (index, layero) {
                    $.ajax({
                        type: "post",
                        url: "<?php echo url('web/column/edit'); ?>",
                        dataType: "json",
                        contentType: "application/json",
                        async: false,
                        data: JSON.stringify(arr)
                    })
                        .then(function (res) {
                            if (res.code == 0) {
                                layer.msg('删除成功');
                                window.location.reload()
                            } else {
                                layer.msg(res.msg);
                            }
                        })
                        .fail(function (err) {
                            layer.msg(err.msg);
                        });
                }
            })
        });

    });
</script>

</body>

</html>
