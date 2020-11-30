<?php

namespace app\shop\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Cart extends Controller
{
    /**
     * 加购方法
     *
     * @return \think\Response
     */
    public function index($id)
    {
//        判断是否先登录
//        if (empty(session("user"))){
//            return "请先登录";
//        }
        $goods = model("Goods")->where('goods_id',$id)->find()->toArray();
        $goods['number'] = 1;
        $user_id = Session('user.user_id');
        $goods['user_id'] = $user_id;
//        dump($goods);
//        die;
        $cart = model("Cart")->allowField(true)->save($goods);
//        dump($cart);
//        die;
        if ($cart){
          return  $this->redirect('shop/Cart/cart');
        }else{
            return 123;
        }
    }

    /**
     * 显示购物车列表页.
     *
     * @return \think\Response
     */
    public function cart()
    {
        //查出用户id
       $user_id= Session::get('user')['user_id'];
//        dump($user_id);
//        die;
        //  从表中读取所有数据
        $data = model("cart")->where('user_id',$user_id)->select();
//        dump($data);die;
         if ($data){
             return view("cart",['data'=>$data]);
         }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        return 123;
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        $param = $request->param();
        $spec_id = $param['id'];
        if (empty(session('user'))){
            //如果未登录，那么修改cookie中的商品数量
            $cart = cookie("cart");
            //修改数量
            $cart[$spec_id]['number'] = $param['number'];
            //更新后重新赋值cookie
            cookie("cart",$cart);
        }else{
            //已登录，直接修改数据表中的数量
            $user_id = session('user.id');
            $id = model("Cart")->where('user_id',$user_id)
                ->where('spec_goods_id',$spec_id)
                ->value('id');
            $data =\model("Cart")->save(['number'=>$param['number']],['id'=>$id]);
//            dump($data);
//            die;
            if ($data){
                return json(['code'=>200,'msg'=>'修改成功','data'=>[]]);
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {

    }
}
