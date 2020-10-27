<?php /*a:1:{s:82:"G:\PhpStudy\PHPTutorial\WWW\livemanage\application\api\view\web\article\lists.html";i:1602754495;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <meta name="Description" content="现场管理"/>
    <meta name="renderer" content="文章列表">
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
        .well{
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #ecf0f1;
            border: 1px solid transparent;
            border-radius: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        }
        .btnSub{
            display: inline-block;
            height: 38px;
            line-height: 38px;
            padding: 0 18px;
            background-color: #009688;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            font-size: 14px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            margin-left: 20px;
        }
    </style>
</head>

<body>
<div class="box">

    <form class="layui-form well" action="<?php echo url('web/article/lists'); ?>">
    <div class="layui-inline">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-inline">
            <select name="column" lay-verify="required" lay-search="">
                <option value="">全部</option>
                <?php if(is_array($column) || $column instanceof \think\Collection || $column instanceof \think\Paginator): $i = 0; $__LIST__ = $column;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['id'] == $column_id): ?>
                        <option value="<?php echo htmlentities($v['id']); ?>" selected="selected"><?php echo htmlentities($v['name']); ?></option>
                    <?php else: ?>
                    <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['name']); ?></option>
                    <?php endif; if(isset($v['child'])): if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;if($c['id'] == $column_id): ?>
                            <option value="<?php echo htmlentities($c['id']); ?>" selected="selected"> ├<?php echo htmlentities($c['name']); ?></option>
                            <?php else: ?>
                            <option value="<?php echo htmlentities($c['id']); ?>"> ├<?php echo htmlentities($c['name']); ?></option>
                            <?php endif; if(isset($c['child'])): if(is_array($c['child']) || $c['child'] instanceof \think\Collection || $c['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $c['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;if($m['id'] == $column_id): ?>
                                    <option value="<?php echo htmlentities($m['id']); ?>" selected="selected"> ├<?php echo htmlentities($m['name']); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo htmlentities($m['id']); ?>"> ├<?php echo htmlentities($m['name']); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php endif; ?>

                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>

                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
        <input class="btnSub" type="submit" value="提 交">
    </form>

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
            <th>分类</th>
            <th>置顶</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr>
            <td class="id"><?php echo htmlentities($v['id']); ?></td>
            <td><?php echo htmlentities($v['title']); ?></td>
            <td><?php echo htmlentities($v['name']); ?></td>

            <?php if($v['hot'] == '1'): ?>
            <td>已置顶</td>
            <?php else: ?>
            <td>未置顶</td>
            <?php endif; ?>

            <td><?php echo htmlentities($v['sort']); ?></td>
            <td>
                <a href="<?php echo url('web/article/getInfo',['id'=>$v['id']]); ?>">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-sm edit">编 辑</button>
                </a>
                <button type="button" class="layui-btn layui-btn-danger layui-btn-sm del">删 除</button>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php echo $page; ?>
</div>

<script type="text/javascript" src="/livemanage/public/static/layui/layui.js" charset="utf-8"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate','laypage'], function(){
        var layer = layui.layer
            ,$ = layui.jquery
        $(document).on('click','.del',function(data){
            var p = $(this).parent('td').siblings('.id').text();
            var arr = {id:p,enabled:0}
            layer.open({
                content: '确定要删除吗？',
                yes: function(index, layero){
                    $.ajax({
                        type: "post",
                        url: "<?php echo url('web/article/edit'); ?>",
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
            });
        });
    });
</script>

</body>

</html>
