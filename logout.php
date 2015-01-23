<?php
session_start();
$info='';
if(isset($_SESSION['user']))
{
    $_SESSION['user']='';
    $msg = '您已经成功退出，<a href="index.php">返回首页</a>';
}
else
{
    $msg = '您未登录或已经超时退出，<a href="index.php">返回首页</a>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>我的BLOG</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                我的BLOG
            </div>
            <div id="title">
                ----I have a dream....
            </div>
            <div id="left">
                <div id="blog_entry">
                    <div id="blog_title">退出登录</div>
                    <div id="blog_body">
                    <div id="blog_date"></div>
                    <?php 
                    echo  $msg;
                    ?>
                    </div>
                </div>
            </div>
            <div id="right">
                <div id="side_bar">
                    <div id="menu_title">关于我</div>
                    <div id="menu_body">我是个PHP爱好者</div>
                </div>
            </div>
        </div>
        <div id="footer">CopyRight@ 2015 01 19</div>
    </body>
</html>

