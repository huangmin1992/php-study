<?php
    namespace app\index\validate;

    use think\Validate;

    class Grade extends Validate{
        protected $rule = [
            ['name','require|max:25','姓名字符长度不能超过25个字符'],
            ['length','require|number','缺少length参数'],
            ['price','require|number','缺少price参数'],
            ['update_time','require|number','缺少update_time参数']
        ];

        protected $scene = [
            'updateGrade'    =>  ['name','length','price','update_time'],
            'addGrade'       =>  ['name','length','price','update_time']
        ];
    }
?>