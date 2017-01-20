<?php
    include_once('config/config.php'); //加载配置文件
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WIKI<?php echo ' | '.PRODUCT_NAME;?></title>
    <link rel="stylesheet" href="assets/css/semantic.min.css">
</head>
<body>
    <div class="ui large top fixed menu transition visible" style="display: flex !important;">
        <div class="ui container">
            <div class="header item">API_DOC<code>(1.0)</code></div>
            <a class="item" href="list_class.php">文件列表</a>
            <a class="item">接口列表</a>
            <a class="item">文档详情</a>
            <a class="active item">使用说明</a>
        </div>
    </div>

    <div class="ui text container" style="max-width: none !important; margin-top: 50px;">
        <div class="ui floating message">
            <span class='ui teal tag label'>配置</span>
            <div class="ui message">
                <p>1. 将文件夹复制到到项目根目录即可。</p>
                <p>2. 设置 api_doc/config/config.php 中 SYSTEM_CLASS_DIR 。</p>
                <p>3. 赋予 api_doc/class 777 权限。</p>
            </div>

            <span class='ui teal tag label'>方法注释</span>
            <div class="ui message">
                事例一：
                <pre>
/**
* 批量获取用户基本信息
* @desc 用于获取多个用户基本信息
* @return int    code 操作码，0表示成功
* @return array  list 用户列表
* @return int    list[].id 用户ID
* @return string list[].name 用户名字
* @return string list[].note 用户来源
* @return string msg 提示信息
*/
public function getMultiBaseInfo()
{
    return [];
}
                </pre>
                事例二：
                <pre>
/**
 * 获取用户基本信息
 * @desc 用于获取单个用户基本信息
 * @return int    code 操作码，0表示成功， 1表示用户不存在
 * @return object info 用户信息对象
 * @return int    info.id 用户ID
 * @return string info.name 用户名字
 * @return string info.note 用户来源
 * @return string msg 提示信息
 */
public function getBaseInfo()
{
    return [];
}
                </pre>
            </div>

            <span class='ui teal tag label'>传递参数注释</span>
            <div class="ui message">
                在文件头部或底部配置每个方法的传入参数
                <pre>
/**
 * API_DOC 设置方法传参
 * @return array
 */
public function getRules()
{
    return [
        'getBaseInfo' => [
            'userId' => [
                'name'    => 'user_id',
                'type'    => 'int',
                'min'     => 1,
                'require' => true,
                'desc'    => '用户ID'
            ],
        ],

        'getMultiBaseInfo' => [
            'userIds' => [
                'name'    => 'user_ids',
                'type'    => 'array',
                'format'  => 'explode',
                'require' => true,
                'default' => '10',
                'range'   => [10,100],
                'desc'    => '用户ID，多个以逗号分割'
            ],
        ],
    ];
}
                </pre>
            </div>
        </div>

        <p><?php echo COPYRIGHT?><p>

    </div>
</body>
</html>