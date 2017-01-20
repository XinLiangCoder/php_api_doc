<?php
/**
 * 广告位管理
 *
 * PHP Version 5
 *
 * @category  Xin
 * @package   AD
 * @author    caoyunxiao <caoyunxiao@xin.com>
 * @time      2016/03/01 18:53
 * @copyright 2016 优信拍（北京）信息科技有限公司
 * @license   http://www.xin.com license
 * @link      caoyunxiao@xin.com
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * AD space
 *
 * @category Xin
 * @package  AD
 * @author   caoyunxiao <caoyunxiao@xin.com>
 * @license  http://www.xin.com/ license
 * @link     caoyunxiao@xin.com
 */
class Action {
    private $_per_page = 10;

    public function view()
    {
        $get = $this->input->get();
        $get   = $get ? $get : array();
        $page  = max(1, intval($get['page']));
        $limit = array(($page-1)*$this->_per_page, $this->_per_page);

        $this->load->model("action_model");
        $list  = $this->action_model->getList($get, '', $limit, 'data');
        foreach ($list as $k => $v) {
            $list[$k]['hash_id'] = fn::hashEncryption($v['id']);
        }
        
        $total = $this->action_model->getList($get, '', '', 'count');
        $this->_page($total, $this->_per_page);

        $this->_assign('list', $list);
        $this->_assign('get', $get);
        $this->_assign('nav', '权限管理 > 权限列表');
        $this->_display();
    }

    public function add()
    {
        $post = $this->input->post();
        if ($post['op'] == 'add') {
            
            $this->load->model('action_model');
            if (!preg_match('/^[0-9a-z_-]{3,32}$/i', $post['classid']) || !preg_match('/^[0-9a-z_-]{3,32}$/i', $post['functionid'])){
                $this->_output_json(['code'=>'no', 'msg'=>'类名和方法名填写不正确!']);
            }
            if ($this->action_model->check_action_exists($post['classid'], $post['functionid'])){
                $this->_output_json(['code'=>'no', 'msg'=>'权限已经存在!']);
            }

            $action['classid'] = $post['classid'];
            $action['functionid'] = $post['functionid'];
            $action['actionname'] = $post['actionname'];
            $action['ismenu'] = $post['ismenu'];

            //添加功能权限
            $rs = $this->action_model->add_action($action);
            if ($rs) {
                $this->_log('新增功能ID='.$rs);
                $this->_output_json(['code'=>'ok', 'msg'=>'操作成功']);
            } else {
                $this->_output_json(['code'=>'no', 'msg'=>'操作失败,请重试!']);
            }

        } else {
            $this->load->config('rbac_config');
            $rbac_class = $this->config->item('rbac_class');
            $this->smarty->assign('class', $rbac_class);
            $this->_assign('nav', '权限管理 > 创建权限');
            $this->_display();
        }
    }

    //编辑
    public function edit()
    {
        $this->load->model('action_model');
        $post = $this->input->post();
        if ($post['op'] == 'edit'){
            if (!preg_match('/^[0-9a-z_-]{3,32}$/i', $post['classid']) || !preg_match('/^[0-9a-z_-]{3,32}$/i', $post['functionid'])){
                $this->_output_json(['code'=>'no', 'msg'=>'类名和方法名填写不正确!']);
            }
            if ($this->action_model->check_action_exists($post['classid'], $post['functionid'],$post['actionid'])){
                $this->_output_json(['code'=>'no', 'msg'=>'权限已经存在!']);
            }
            //修改权限
            $result = $this->action_model->edit_action($post, $post['actionid']);
            if ($result){
                $this->_log('编辑功能ID='.$post['actionid']);
                $this->_output_json(['code'=>'ok', 'msg'=>'操作成功!']);
            }else{
                $this->_output_json(['code'=>'no', 'msg'=>'抱歉，修改失败，请稍候重试!']);
            }
        }else{
                
            $get = $this->input->get();
            $actionid = intval($get['actionid']);
            $info = $this->action_model->get_action_by_id($actionid);
            //print_r($info);exit();
            $this->_assign('info', $info);
            $this->load->config('rbac_config');
            $rbac_class = $this->config->item('rbac_class');
            $this->smarty->assign('class', $rbac_class);
            $this->_assign('nav', '权限管理 > 编辑权限');
            $this->_display();
        }
    }

    /**
     * 删除方法
     * @return array
     */
    public function delete()
    {
        $post = $this->input->post();
        $actionid = intval($post['actionid']);
        if (!empty($actionid)) {
            $this->load->model('action_model');
            $rs = $this->action_model->delete_action($actionid);
            if (!empty($rs)) {
                $this->_log('删除功能ID='.$actionid);
                $this->_output_json(['code'=>'ok', 'msg'=>'操作成功']);
            } else {
                $this->_output_json(['code'=>'no', 'msg'=>'服务器繁忙']);
            }
        } else {
            $this->_output_json(['code' => 'no', 'msg' => '缺少参数ID']);
        }
    }
}
