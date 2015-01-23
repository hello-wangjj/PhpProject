<?php
$login=FALSE;
if(!isset($_GET['ym']) || empty($_GET['ym']))
{
    $login=TRUE;
    $msg = '请求参数错误！<a href="index.php">返回首页</a>';
}

$folder_array=array();
$dir = 'contents';
$folder=$_GET['ym'];
if(!is_dir($dir.'/'.$folder))
{
    $ok = true;
    $msg = '请求参数错误！<a href="index.php">返回首页</a>';
}

$dh = opendir($dir);
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
        //以下是文件中的日志信息
        $temp_data['SUBJECT'] = $content_array[0];
        $temp_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]);
        $temp_data['CONTENT'] = $content_array[2];
        //$file = substr($file, 0,9);
        //$temp_data['FILENAME'] = $folder.'-'.$file;
        array_push($post_data, $temp_data);
        }
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
                <h1>我的BLOG</h1>
            </div>
            <div id="title">
                ----I have a dream....
            </div>
            <div id="left">
                <?php
                if($login==false)
                {
                foreach ($post_data as $post)
                {
                ?>
                <div id="blog_entry">
                    <div id="blog_title"><?php echo $post['SUBJECT']; ?></div>
                    <div id="blog_body">
                    <div id="blog_date"><?php echo $post['DATE']; ?></div>
                    <?php echo $post['CONTENT']; ?>
                    </div>
                </div>
                <?php }
                }
                else{
                    echo $msg;
                }
                ?>
            </div>
            <div id="right">
                <div id="side_bar">
                    <div id="menu_title">关于我</div>
                    <div id="menu_body">我是个PHP爱好者
                        <br/><br/>
                       <a href="login.php">登录</a>
                    </div>
                </div>
                <br/>
              <div id="side_bar">
                    <div id="menu_title">日志归档</div>
                    <?php 
                        foreach ($folder_array as $ym) {
                            $entry = $ym;
                            $ym = substr($ym, 0,4).'-'.substr($ym, 4,2);
                            echo '<div id="menu_body"><a href="archives.php?ym='.$entry.'">'.$ym.'</a></div>';
                        }
                    ?>
                    
              </div>
            </div>
        </div>
        <div id="footer">CopyRight@ 2015 01 19</div>
    </body>
</html>
<?php   closedir($dh); ?>

