<?php
    include_once('config/config.php'); //加载配置文件
    //判断文件夹是否存在
    if (!is_dir(SYSTEM_CLASS_DIR)) {
        die('config.php 中 SYSTEM_CLASS_DIR 设置有误。');
    }
    //获取某目录下所有文件、目录名（不包括子目录下文件、目录名）
    $handler = opendir(SYSTEM_CLASS_DIR);
    while (($filename = readdir($handler)) !== false) {
        //过滤隐藏文件
        $ArrFileName = explode('.', $filename);
        if ($filename != "." && $filename != ".." && $ArrFileName[0]) {
            $ext = substr($filename, strrpos($filename, '.') + 1); //获取后缀
            if ($ext == 'php') {
                $files['name'][] = $filename ;
                $files['time'][] = filemtime(SYSTEM_CLASS_DIR.$filename);
            }
        }
    }
    closedir($handler);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>文件列表<?php echo ' | '.PRODUCT_NAME;?></title>
    <link rel="stylesheet" href="assets/css/semantic.min.css">
</head>
<body>
<div class="ui large top fixed menu transition visible" style="display: flex !important;">
    <div class="ui container">
        <div class="header item">API_DOC<code>(1.0)</code></div>
        <a class="active item">文件列表</a>
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
                        echo '<td><a href="list_method.php?f='.$v.'">'.$v.'</a></td>';
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
