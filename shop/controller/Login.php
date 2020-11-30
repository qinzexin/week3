<?php

namespace app\shop\controller;

use app\shop\model\User;
use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller
{
    /**
     * 显示登录页面
     *
     * @return \think\Response
     */
    public function index()
    {
        return  view("login");
    }
    /**
     * 接收登录参数
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收参数
        $param = $request->param();
        //验证参数
        $result = $this->validate(
            $param,
            [
                'name'  => 'require',
                'pwd'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            dump($result);
        }
        $data = model("User")
            ->where('name',$param['name'])
            ->where('pwd',$param['pwd'])
            ->find();
        if ($data){
            session_start();
            Session::set('user',$data);
            return $this->redirect('shop/Goods/index');;
        }else{
            return 2;
        }
    }
}
