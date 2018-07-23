<?php
namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use think\Validate;

class Index extends Controller
{
    public function index()
    {
        header('Access-Control-Allow-Origin:*');     
    	header('Access-Control-Allow-Methods:*');  
        header('Access-Control-Allow-Headers:*');
        header('Access-Control-Allow-Credentials:false');
        
        // $rule = [
        //     'name'  => 'require|max:25',
        //     'age'   => 'number|between:1,120',
        //     'email' => 'email',
        // ];
        
        // $msg = [
        //     'name.require' => '名称必须',
        //     'name.max'     => '名称最多不能超过25个字符',
        //     'age.number'   => '年龄必须是数字',
        //     'age.between'  => '年龄只能在1-120之间',
        //     'email'        => '邮箱格式错误',
        // ];
        
        // $data = [
        //     'name'  => 'thinkphp',
        //     'age'   => 150,
        //     'email' => 'thinkphp@qq.com',
        // ];
        
        // $validate = new Validate($rule, $msg);
        // $result   = $validate->batch()->check($data);
        // if(!$validate->check($data)){
        //     dump($validate->getError());
        // }
        // $res['msg'] = $result;
        // return json_encode($res);



    }
}
