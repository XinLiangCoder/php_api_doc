# php_api_doc

![效果图](https://ntaste.github.io/image/api_doc_1.png)

> 配置

- 将文件夹复制到到项目根目录即可。
- 设置 api_doc/config/config.php 中 SYSTEM_CLASS_DIR 。
- 赋予 api_doc/class 文件夹 777 权限。

> 方法注释

- 事例一：
```
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
```
- 事例二：
```
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
```

> 传递参数注释

- 在文件头部或底部配置每个方法的传入参数

```
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
```


> 相关备注

- 遇到问题可以关注公众号咨询。
- 也可以加入QQ群：564557094。

微信名称：IT小圈儿，微信号：ToFeelings。

![IT小圈儿](https://ntaste.github.io/image/qr.jpg)

> 打赏

![微信打赏](https://ntaste.github.io/image/wx_pay.jpg)

> 日志

- 新增支持多级目录问题
