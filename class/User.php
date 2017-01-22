<?php

class User {
    /**
     * 接口参数
     * @return array
     */
    public function getRules() {
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

    /**
     * 获取用户基本信息
     * @desc 用于获取单个用户基本信息
     * @return int code 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return int info.id 用户ID
     * @return string info.name 用户名字
     * @return string info.note 用户来源
     * @return string msg 提示信息
     */
    public function getBaseInfo() {
        return [];
    }

    /**
     * 批量获取用户基本信息
     * @desc 用于获取多个用户基本信息
     * @return int code 操作码，0表示成功
     * @return array list 用户列表
     * @return int list[].id 用户ID
     * @return string list[].name 用户名字
     * @return string list[].note 用户来源
     * @return string msg 提示信息
     */
    public function getMultiBaseInfo() {
        return [];
    }
}
