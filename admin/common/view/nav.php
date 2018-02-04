  <?php
  	$nav = isset($_GET['nav'])?$_GET['nav']:'0-0';
    $NAV = explode('-', $nav);
    foreach ($NAV as $key => $value) {
      $c_nav = $value;
      $p_nav = $key;
    }
  ?>
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item <?php if($p_nav == 1){echo "layui-nav-itemed";} ?>">
          <a class="" href="javascript:;">照片库</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" <?php if($c_nav == 1){echo "class='layui-this'";}  ?>>照片管理</a></dd>
            <dd><a href="/admin/upload_photo.php?nav=1-2" <?php if($c_nav == 2){echo "class='layui-this'";}  ?>>上传照片</a></dd>
            <dd><a href="javascript:;" <?php if($c_nav == 3){echo "class='layui-this'";}  ?>>相关设置</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php if($p_nav == 2){echo "layui-nav-itemed";} ?>">
          <a href="javascript:;">相册库</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" <?php if($c_nav == 5){echo "class='layui-this'";}  ?>>相册管理</a></dd>
            <dd><a href="javascript:;">新建相册</a></dd>
            <dd><a href="">相关设置</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="">垃圾桶</a></li>
        <li class="layui-nav-item"><a href="">其他</a></li>
      </ul>
    </div>
  </div>