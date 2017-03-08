<?php

    $file = $_GET['f'];

    if (empty($file)) {
        die('缺少参数:f');
    }

    include_once('config/config.php'); //加载配置文件

    $fileData = _make_file($file); //通过原来的类文件生成新的类文件

    if (isset($_GET['reload']) && $_GET['reload'] == '1') {
        //重新加载
        if (empty($_GET['m'])) {
            die('缺少参数:m');
        }
        header('Location: doc.php?f='.$file.'&m='.$_GET['m']);
        exit;
    }

    include_once(CURRENT_CLASS_DIR.$fileData['file_name']); //包含文件

    $methods = _get_method_data($fileData['class_name']); //通过类名获取方面数据

    /**
     * 生成文件
     * @param string $file 文件名
     * @return array
     */
    function _make_file($file = '')
    {
        //步骤:分析原来的类文件,将继承去掉并获取类名
        $path = SYSTEM_CLASS_DIR.$file;
        $php_content = file_get_contents($path);
        if (empty($php_content)) {
            die('empty:'.$path);
        }
        $check_extends = strstr($php_content, 'extends');
        if ($check_extends) {
            //表示存在 继承 关系
            $start = 'extends';
            $end   = '({|\n{)';
            $pattern = "/".$start.".*".$end."/";
            preg_match_all($pattern, $php_content, $matches);
            $php_content = str_replace($matches[0], '{', $php_content);
        }
        $check_namespace = strstr($php_content, 'namespace');
        if ($check_namespace) {
            $start = 'namespace';
            $end   = ';';
            $pattern = "/".$start.".*".$end."/";
            preg_match_all($pattern, $php_content, $matches);
            $php_content = str_replace($matches[0], '', $php_content);
        }
        //获取类名
        $start = 'class';
        $end   = '{';

        $pattern = "/".$start.".*".$end."/";
        preg_match_all($pattern, $php_content, $matches);
        $class_name = str_replace($start, '', $matches[0]);
        $class_name = str_replace($end, '', $class_name[0]);
        $class_name = str_replace(' ', '', $class_name);

        //生成新文件
        $new_file_name = $class_name.'.php';
        if (file_exists(CURRENT_CLASS_DIR.$new_file_name)) {
            unlink(CURRENT_CLASS_DIR.$new_file_name) or die ('删除文件:'.CURRENT_CLASS_DIR.$new_file_name.'失败');
        }
        file_put_contents(CURRENT_CLASS_DIR.$new_file_name, $php_content) or die ('写入文件:'.CURRENT_CLASS_DIR.$new_file_name.'失败');
        return [
            'file_name'  => $new_file_name,
            'class_name' => $class_name
        ];
    }

    /**
     * 通过文件名获取类名
     * @param string $filename 文件名
     * @return string
     */
    function _get_class_name($filename = '')
    {
        $class = explode('.', $filename);
        return $class[0];
    }

    /**
     * 获取类中的方法数据
     * @param string $class 类名
     * @return mixed
     */
    function _get_method_data($class = '')
    {
        $method = get_class_methods($class);
        $arrApi = [];
        if (!empty($method)) {
            foreach ($method as $mValue) {
                $rMethod = new Reflectionmethod($class, $mValue);
                if (!$rMethod->isPublic() || strpos($mValue, '__') === 0 || $mValue == 'getRules') {
                    continue;
                }

                $title = '//请检测函数注释';
                $desc  = '//请使用@desc 注释';

                $docComment = $rMethod->getDocComment(); //获取评论
                if ($docComment !== false) {
                    $docCommentArr = explode("\n", $docComment);
                    $comment       = trim($docCommentArr[1]);
                    $title         = trim(substr($comment, strpos($comment, '*') + 1));

                    foreach ($docCommentArr as $comment) {
                        $pos = stripos($comment, '@desc');
                        if ($pos !== false) {
                            $desc = substr($comment, $pos + 5);
                        }
                    }
                }

                $service = $class . '.' . $mValue;

                $arrApi[$service] = [
                    'service' => $service,
                    'title'   => $title,
                    'desc'    => $desc,
                ];
            }
        }
        return $arrApi;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>在线接口列表<?php echo ' | '.PRODUCT_NAME;?></title>
    <link rel="stylesheet" href="assets/css/semantic.min.css">
</head>
<body>
<div class="ui large top fixed menu transition visible" style="display: flex !important;">
    <div class="ui container">
        <div class="header item">API_DOC<code>(1.0)</code></div>
        <a class="item" href="list_class.php">文件列表</a>
        <a class="active item">接口列表</a>
        <a class="item">文档详情</a>
        <a class="item" href="wiki.php">使用说明</a>
    </div>
</div>
<div class="ui text container" style="max-width: none !important; margin-top: 50px;">
    <div class="ui floating message">
        <h1 class="ui header">接口列表</h1>
        <table class="ui black celled striped table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>接口服务</th>
                    <th>接口名称</th>
                    <th>更多说明</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $num = 1;
                    if (!empty($methods)) {
                        foreach ($methods as $key => $item) {
                            $NO = $num++;
                            echo '<tr>';
                            echo '<td>'.$NO.'</td>';
                            echo '<td><a href="doc.php?f='.$file.'&m='.$item['service'].'">'.$item['service'].'</a></td>';
                            echo '<td>'.$item['title'].'</td>';
                            echo '<td>'.$item['desc'].'</td>';
                            echo "</tr>";
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
