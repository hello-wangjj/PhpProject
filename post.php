<?php
$login=FALSE;
session_start();

if(!empty($_SESSION['user']) && $_SESSION['user']=='admin')
    $login=TRUE;

if(!isset($_GET['entry']))
{
    echo '请求参数错误';
    exit();
}
$path= substr($_GET['entry'], 0,6);
$entry=  substr($_GET['entry'], 7,9);

$file_name='contents/'.$path.'/'.$entry.'.txt';
if(file_exists($file_name))
{
    $fp=@fopen($file_name, 'r');
    if($fp)
    {
        flock($fp,LOCK_SH);
        $result=  fread($fp, 1024);
    }
    flock($fp, LOCK_UN);
    fclose($fp);
}
//将result的内容按|分割后存入数组
$temp_data=array();
$content_array=  explode('|', $result);
$temp_data['SUBJECT'] = $content_array[0];
$temp_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]);
$temp_data['CONTENT'] = $content_array[2];
//$file = substr($entry, 0,9);
$temp_data['FILENAME'] = $path.'-'.$entry;
//以下代码将内容输出至浏览器
//echo '<h1>我的Blog</h1>';
//echo '<b>日志标题：</b>'.$content_array[0];
//echo '<br/><b>发布时间：</b>'.date('Y-m-d H:i:s',$content_array[1]);
//echo '<hr/>';
//echo $content_array[2];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Blog</title>
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
                    <div id="blog_title"><?php echo $content_array[0]; ?></div>
                    <div id="blog_body">
                    <div id="blog_date"><?php echo date('Y-m-d H:i:s',$content_array[1]); ?></div>
                    <?php echo $content_array[2]; ?>
                    <div>
                    <?php
                    if($login)
                    {
                        echo '<a href="edit.php?entry='.$temp_data['FILENAME'].'">编辑</a>   &nbsp;&nbsp;&nbsp; <a href="delete.php?entry='.$temp_data['FILENAME'].'">删除</a>';  //输出 编辑和删除的链接
                    }
                    ?>
                    </div>
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

