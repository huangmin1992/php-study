<?php
    namespace app\index\validate;

    use think\Validate;

    class Student extends Validate{
        protected $rule = [
            ['name','require|max:25','姓名字符长度不能超过25个字符'],
            ['sex','require','性别是必须的'],
            ['age','require|between:1,120','年龄必须在1~120之间'],
            ['start_time','require|number','缺少入学时间参数'],
            ['grade_id','require|number','缺少班级参数'],
            ['mobile','require|number|length:11','手机号码格式不正确'],
            ['email','email','缺少邮箱参数']
        ];

        protected $scene = [
            'updateStudent'    =>  ['name','sex','age','start_time','grade_id','mobile','email'],
            'addStudent'    =>  ['name','sex','age','start_time','grade_id','mobile','email'],
        ];
    }
?>