  <?php
  //选择导航栏处理
  	$nav = isset($_GET['nav'])?$_GET['nav']:'0-0';
    $NAV = explode('-', $nav);
      $c_nav = $NAV[1];
      $p_nav = $NAV[0];
  ?>
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item <?php  if($p_nav == 1){echo "layui-nav-itemed";} ?>">
          <a class="" href="javascript:;"><i class="layui-icon">&#xe634;</i>&nbsp;&nbsp;图片库</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/manage_photo.php?nav=1-1" <?php if($c_nav == 1){echo "class='layui-this'";}  ?>>照片管理</a></dd>
            <dd><a href="/admin/upload_photo.php?nav=1-2" <?php if($c_nav == 2){echo "class='layui-this'";}  ?>>上传图片</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php if($p_nav == 2){echo "layui-nav-itemed";} ?>">
          <a href="javascript:;"><i class="layui-icon">&#xe637;</i>&nbsp;&nbsp;相册库</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/manage_album.php?nav=2-4" <?php if($c_nav == 4){echo "class='layui-this'";}  ?>>相册管理</a></dd>
            <dd><a href="/admin/create_album.php?nav=2-5" <?php if($c_nav == 5){echo "class='layui-this'";}  ?>>新建相册</a></dd>
            <dd><a href="/admin/manage_tag.php?nav=2-6" <?php if($c_nav == 6){echo "class='layui-this'";}  ?>>相册标签</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php if($p_nav == 3){echo "layui-nav-itemed";} ?>" >
          <a href="javascript:;"><i class="layui-icon">&#xe640;</i>&nbsp;&nbsp;回收站</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/recycle_photo.php?nav=3-8" <?php if($c_nav == 8){echo "class='layui-this'";}  ?>>图片</a></dd>
            <dd><a href="/admin/recycle_album.php?nav=3-9" <?php if($c_nav == 9){echo "class='layui-this'";}  ?>>相册</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>