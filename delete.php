<?php

session_start();
$login=FALSE;

if(empty($_SESSION['user']) ||  $_SESSION['user']!='admin')
{
    echo '请<a href="login.php">登录</a>后执行该操作';
    exit();
}

if(!isset($_GET['entry']))
{
    if(!isset($_POST['id']))
    {
        $login = true;
        $msg = '请求参数错误！<a href="index.php">返回首页</a>';
    }
 else 
    {
    //删除操作
        $path= substr($_POST['id'], 0,6);
        $entry=  substr($_POST['id'], 7,9);
        $file_name='contents/'.$path.'/'.$entry.'.txt';
            if(unlink($file_name))
        {
            $login = TRUE;
            $msg = '该日志删除成功！<a href="index.php">返回首页</a>';
        }
            else
            {
                $login = TRUE;
                $msg = '该日志删除失败！<a href="index.php">返回首页</a>';
            }
    }
}
else
{
    $form_data='';
    $path= substr($_GET['entry'], 0,6);
    $entry=  substr($_GET['entry'], 7,9);
    $file_name='contents/'.$path.'/'.$entry.'.txt';
    if(file_exists($file_name))
    {
        $form_data='<input type="hidden" name="id" value="'.$_GET['entry'].'">';
    }
    else
    {
        $login = TRUE;
        $msg = '所要删除的日志不存在！<a href="index.php">返回首页</a>';
    }
}
?>
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
                 <h1>我的BLOG</h1>
            </div>
            <div id="title">
                ----I have a dream....
            </div>
            <div id="left">
                <div id="blog_entry">
                    <div id="blog_title">删除日志</div>
                    <div id="blog_body">
                        <?php if($login == FALSE)
                        {
                        ?>
                    <div id="blog_date"></div>
                
                        <form method="post" action="delete.php">
                            <font color="red">删除的日志无法恢复，确定要删除吗？</font><br/>
                            <input type="submit" value="确定"/>
                            <?php echo $form_data;?>
                        </form>
                        <?php } ?>
                    <?php if($login == true){ echo $msg;}?>
                     </div> 
                </div>
            </div>    
            <div id="right">
                <div id="side_bar">
                    <div id="menu_title">关于我</div>
                    <div id="menu_body">我是个PHP爱好者</div>
                    <br/><br/>
                        <?php  
                        if($login)
                        {
                            echo '<a href="logout.php">退出</a>';
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


