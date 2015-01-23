<?php
$login=FALSE;
session_start();

if(!empty($_SESSION['user']) && $_SESSION['user']=='admin')
    $login=TRUE;


if(isset($_POST['title'])&&isset($_POST['content']))  //判断变量
{
    $login=true;
    $title=trim($_POST['title']);
    $content=  trim($_POST['content']);
    $date=  time();
    $blog_str=$title.'|'.$date.'|'.$content;
    
    $ym=  date('Ym', time());   //获取当前年月
    $d=  date('d', time());     //获取当前日
    $time=  date('His', time());    //获取日期中的时间
    
    $folder ='contents/'.$ym;   //根据年和月来设置目录名
    $file=$d.'-'.$time.'.txt';//获取时间和日来设置文件名
    $filename=$folder.'/'.$file;
    $entry= $ym.'-'.$d.'-'.$time;
    
    if(file_exists($folder)==FALSE)
    {
        if(!mkdir($folder))
        {
            //$login=false;
            //$msg='<font color=red>创建目录失败</font>';
        }
    }
    
    $fp=@fopen($filename, 'w');
    if($fp)
    {
        flock($fp, LOCK_EX);
        $result=  fwrite($fp, $blog_str);
        $lock=  flock($fp, LOCK_UN);
        fclose($fp);
    }
    if(strlen($result))
    {
        //$login=true;
        $msg='日志添加成功，<a href="post.php?entry='.$entry.'">查看该日志文章</a>';
        echo $msg;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>我的BLOG</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>我的BLOG</h1>
            </div>
            <div id="title">
                ----I have a dream....
            </div>
            <div id="left">
                <div id="blog_entry">
                    <div id="blog_title">添加一篇新日志</div>
                    <div id="blog_body">
                    <div id="blog_date"></div>
                    <table border="0">
                        <form method="post" action="add.php">
                            <tr><td>日志标题：</td></tr>
                            <tr><td><input type="text" name="title" size="50"/></td></tr>
                            <tr><td>日志内容：</td></tr>
                            <tr><td><textarea name="content" cols="49" rows="10"></textarea></td></tr>
                            <?php
                            if($login)
                            {
                            echo '<tr><td><input type="submit" value="提交"/></td></tr>';
                            }
                            else {
                                echo '<tr><td><a href="login.php">请先登录</a></td></tr>';
                            }
                            ?>
                        </form>
                    </table>
                    </div>
                </div>
            </div>
            <div id="right">
                <div id="side_bar">
                    <div id="menu_title">关于我</div>
                    <div id="menu_body">我是个PHP爱好者</div>
                    <br/>
                        <?php  
                        if($login)
                        {
                            echo '<a href="logout.php">退出</a>'.'&nbsp;&nbsp;&nbsp'.'<a href="index.php">返回首页</a>';
                        }
                        else
                        {
                            echo '<a href="login.php">登录</a>';
                        }
                        ?>
                </div>
            </div>
        </div>
        <div id="footer">CopyRight@ 2015 01 19</div>
    </body>
</html>
