<?php
$login=FALSE;
session_start();

if(!empty($_SESSION['user']) && $_SESSION['user']=='admin')
    $login=TRUE;

$file_array=array();
$folder_array=array();

$dir='contents';
$dh=  opendir($dir);

if($dh)
{
    $filename=  readdir($dh);
    
    while($filename)
    {
        if($filename != '.' && $filename !='..')
        {
            $folder_name=$filename;
            array_push($folder_array, $folder_name);
        }
        $filename=  readdir($dh);
    }
}
rsort($folder_array);

$post_data=array();
foreach ($folder_array as $folder)  //处理个目录下文件
{
    $dh = opendir($dir.'/'.$folder);
    while(($filename = readdir($dh)) !== FALSE)  //注意运算符优先级
    {
        if(is_file($dir.'/'.$folder.'/'.$filename))
        {
            $file=$filename;
            $file_name=$dir.'/'.$folder.'/'.$file;
            
            if(file_exists($file_name))
            {
                $fp=@fopen($file_name, 'r');
                if($fp)
                {
                    flock($fp,LOCK_SH);
                    $result=  fread($fp, filesize($file_name));
                }
                flock($fp, LOCK_UN);
                fclose($fp);
            }
        $temp_data=array();
        $content_array=  explode('|', $result);
        
        $temp_data['SUBJECT'] = $content_array[0];
        $temp_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]);
        $temp_data['CONTENT'] = $content_array[2];
        $file = substr($file, 0,9);
        $temp_data['FILENAME'] = $folder.'-'.$file;
        array_push($post_data, $temp_data);
        }
    }
}
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
                <?php  
                foreach ($post_data as $post)
                {
                ?>
                <div id="blog_entry">
                    <div id="blog_title"><?php echo $post['SUBJECT']; ?></div>
                    <div id="blog_body">
                    <div id="blog_date"><?php echo $post['DATE']; ?></div>
                    <?php echo $post['CONTENT']; ?>
                    <?php
                    if($login)
                    {
                        echo '<a href="edit.php?entry='.$post['FILENAME'].'">编辑</a>   &nbsp;&nbsp;&nbsp; <a href="delete.php?entry='.$post['FILENAME'].'">删除</a>';  //输出 编辑和删除的链接
                    }
                    ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div id="right">
                <div id="side_bar">
                    <div id="menu_title">关于我</div>
                    <div id="menu_body">我是个PHP爱好者
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
        </div>
        <div id="footer">CopyRight@ 2015 01 19</div>
    </body>
</html>
<?php   closedir($dh); ?>

