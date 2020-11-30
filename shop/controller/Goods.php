<?php

namespace app\shop\controller;

use think\Controller;
use think\Request;

class Goods extends Controller
{
    /**
     * 查询资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = model("Goods")->select();
//        dump($data);
        return view("goods",['data'=>$data]);
    }

}
