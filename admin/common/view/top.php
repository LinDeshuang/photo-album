<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <a href="/admin/index.php"><div class="layui-logo">后台管理</div></a>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
    	<li class="layui-nav-item"><a href="/index.php">回到首页</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src='<?php echo $_SESSION['user_photo']; ?>' class="layui-nav-img">
          <?php echo $_SESSION['user_nick_name'];?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user.php">基本资料</a></dd>
          <dd><a href="account.php">帐号设置</a></dd>
          <dd><a href="/home/logout.php">退了</a></dd>       
        </dl>
      </li>
    </ul>
  </div>
  