<div class="layui-layout layui-layout-admin">
  <div class="home-header layui-bg-black">
    <div class="layui-container">
    <a href="/index.php"><h2 class="layui-logo"><i class='layui-icon'>&#xe857;</i>&nbsp;简易电子相册</h2></a>
    <!-- 头部区域 -->
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
                      <dd><a href='/admin/index.php'>个人中心</a></dd>
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
</div>
<div class="layui-container">
  <div class="layui-tab layui-tab-brief" style="text-align: center;margin:60px auto;margin-bottom: 5px;padding: 10px;background-color: #fff; ">
        <ul class="layui-tab-title">
          <li><a href="/index.php">最新相册</a></li>
          <li><a href="/home/hot_album.php">最热相册</a></li>
          <li><a href="/home/all_album.php">所有相册</a></li>
          <li class="layui-layout-right">
            <form class="layui-form layui-form-pane"  method="get" action="/home/search_album.php">
              <label class="layui-form-label">相册搜索</label>
              <div class="layui-input-inline">
                <select name="search_type">
                <option value="album_name">相册名</option>
                <option value="album_intro">相册简介</option>
              </select>     
              </div>
              <div class="layui-input-inline">
                <input type="text" name="search_val" lay-verify="required" placeholder="输入想搜索的内容" class="layui-input">  
              </div>
              <div class="layui-input-inline">
                <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
                  <i class="layui-icon">&#xe615;</i>
                </button>  
              </div>
            </form>
          </li>
        </ul>
      </div>
</div>