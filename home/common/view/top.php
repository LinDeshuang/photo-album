<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <a href="/index.php"><div class="layui-logo">简易电子相册</div></a>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
    </ul>
    <ul class="layui-nav layui-layout-right">
    
      <?php

        if(isset($_SESSION['user'])){
            echo "<li class='layui-nav-item'>
                    <a href='javascript:;'>
                      <img src='{$_SESSION['user_photo']}' class='layui-nav-img'>
                      {$_SESSION['user_nick_name']}
                    </a>
                    <dl class='layui-nav-child'>
                      <dd><a href='/admin/index.php'>后台管理</a></dd>
                      <dd><a href='/home/logout.php'>退了</a></dd>
                    </dl>
                  </li>";
        }else{
            echo "<li class='layui-nav-item'><a href='/home/login.php'>登录</a></li>
                <li class='layui-nav-item'><a href='/home/register.php'>注册</a></li>";
        }
      ?>
    </ul>
  </div>
</div>