<?php
    include_once('config/config.php'); //加载配置文件
    //判断文件夹是否存在
    if (!is_dir(SYSTEM_CLASS_DIR)) {
        die('config.php 中 SYSTEM_CLASS_DIR 设置有误。');
    }
    //获取某目录下所有文件、目录名
    function my_scandir($dir)
    {
        $files = array();
        if ( $handle = opendir($dir) ) {
            while ( ($file = readdir($handle)) !== false ) {
                //过滤隐藏文件
                $ArrFileName = explode('.', $file);
                if ( $file != ".." && $file != "." && $ArrFileName[0]) {
                    if (is_dir($dir . "/" . $file) ) {
                        $files['name'][] = empty($_GET['d']) ? $file : $_GET['d'].'/'.$file ;
                        $files['time'][] = @filemtime(SYSTEM_CLASS_DIR.$file);
                        $files['type'][] = 'dir';
                        my_scandir($dir . "/" . $file);
                    } else {
                        $ext = substr($file, strrpos($file, '.') + 1); //获取后缀
                        if ($ext == 'php') {
                            $files['name'][] = empty($_GET['d']) ? $file : $_GET['d'].'/'.$file ;
                            $files['time'][] = @filemtime(SYSTEM_CLASS_DIR.$file);
                            $files['type'][] = 'file';
                        }
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }

    if (!empty($_GET['d'])) {
        $files = my_scandir(SYSTEM_CLASS_DIR.'/'.$_GET['d']);
    } else {
        $files = my_scandir(SYSTEM_CLASS_DIR);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>文件列表<?php echo ' | '.PRODUCT_NAME;?></title>
    <link rel="stylesheet" href="assets/css/semantic.min.css">
    <link rel="stylesheet" href="assets/css/icon.min.css">
</head>
<body>
<div class="ui large top fixed menu transition visible" style="display: flex !important;">
    <div class="ui container">
        <div class="header item">API_DOC<code>(1.0)</code></div>
        <a class="active item" href="list_class.php">文件列表</a>
        <a class="item">接口列表</a>
        <a class="item">文档详情</a>
        <a class="item" href="wiki.php">使用说明</a>
    </div>
</div>
<div class="ui text container" style="max-width: none !important;margin-top: 50px;">
    <div class="ui floating message">
        <h1 class="ui header">文件列表</h1>
        <table class="ui black celled striped table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>文件名称</th>
                    <th>最后修改时间</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($files)) {
                    $num = 1;
                    foreach ($files['name'] as $k => $v) {
                        $NO = $num++;
                        echo '<tr>';
                        echo '<td>'.$NO.'</td>';
                        echo '<td>';
                        if ($files['type'][$k] == 'file') {
                            echo '<i class="file icon"></i> <a href="list_method.php?f='.$v.'">'.$v.'</a>';
                        } elseif ($files['type'][$k] == 'dir') {
                            echo '<i class="folder icon"></i> <a href="list_class.php?d='.$v.'">'.$v.'</a>';
                        }
                        echo '</td>';
                        echo '<td>'.date('Y-m-d H:i:s', $files['time'][$k]).'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
    <p><?php echo COPYRIGHT?><p>
</div>
</body>
</html>
