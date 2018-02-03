  <?php
  	$nav = isset($_GET['nav'])?$_GET['nav']:0;
  ?>
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item">
          <a class="" href="javascript:;">所有商品</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" <?php if($nav == 1){echo "class='layui-this'";}  ?>>列表一</a></dd>
            <dd><a href="javascript:;" <?php if($nav == 2){echo "class='layui-this'";}  ?>>列表二</a></dd>
            <dd><a href="javascript:;" <?php if($nav == 3){echo "class='layui-this'";}  ?>>列表三</a></dd>
            <dd><a href="" <?php if($nav == 4){echo "class='layui-this'";}  ?>>超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">解决方案</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" <?php if($nav == 5){echo "class='layui-this'";}  ?>>列表一</a></dd>
            <dd><a href="javascript:;">列表二</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="">云市场</a></li>
        <li class="layui-nav-item"><a href="">发布商品</a></li>
      </ul>
    </div>
  </div>