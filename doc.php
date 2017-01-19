<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User.GetBaseInfo - 在线接口文档</title>
    <link rel="stylesheet" href="assets/css/semantic.min.css">
</head>
<body>
<br />
<div class="ui text container" style="max-width: none !important;">
    <div class="ui floating message">
        <h2 class='ui header'>接口：User.GetBaseInfo</h2><br/>
        <span class='ui teal tag label'> 获取用户基本信息</span>

        <div class="ui raised segment">
            <span class="ui red ribbon label">接口说明</span>
            <div class="ui message">
                <p> 用于获取单个用户基本信息</p>
            </div>
        </div>

        <h3>接口参数</h3>
        <table class="ui red celled striped table" >
            <thead>
                <tr>
                    <th>参数名字</th>
                    <th>类型</th>
                    <th>是否必须</th>
                    <th>默认值</th>
                    <th>其他</th>
                    <th>说明</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>user_id</td>
                    <td>整型</td>
                    <td><font color="red">必须</font></td>
                    <td></td>
                    <td> 最小：1</td>
                    <td>用户ID</td>
                </tr>
            </tbody>
        </table>

        <h3>返回结果</h3>
        <table class="ui green celled striped table" >
            <thead>
                <tr>
                    <th>返回字段</th>
                    <th>类型</th>
                    <th>说明</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>code</td>
                    <td>整型</td>
                    <td>操作码，0表示成功， 1表示用户不存在</td>
                </tr>
                <tr>
                    <td>info</td>
                    <td>对象</td>
                    <td>用户信息对象</td>
                </tr>
                <tr>
                    <td>info.id</td>
                    <td>整型</td>
                    <td>用户ID</td>
                </tr>
                <tr>
                    <td>info.name</td>
                    <td>字符串</td>
                    <td>用户名字</td>
                </tr>
                <tr>
                    <td>info.note</td>
                    <td>字符串</td>
                    <td>用户来源</td>
                </tr>
                <tr>
                    <td>msg</td>
                    <td>字符串</td>
                    <td>提示信息</td>
                </tr>
            </tbody>
        </table>

        <div class="ui blue message">
            <strong>温馨提示：</strong> 此接口参数列表根据后台代码自动生成，可将 ?service= 改成您需要查询的接口/服务
        </div>
    </div>
</div>
</body>
</html>