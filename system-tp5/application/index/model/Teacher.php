<?php
    namespace app\index\model;

    use think\Model;

    class Teacher extends Model{
        // 设置当前模型对应的完整数据表名称
        protected $table = 'teacher';
        protected $autoWriteTimestamp = true;
        protected $field = true;
        
        // 设置当前模型的数据库连接
        protected $connection = [
            // 数据库类型
            'type'        => 'mysql',
            // 服务器地址
            'hostname'    => '127.0.0.1',
            // 数据库名
            'database'    => 'shop_data',
            // 数据库用户名
            'username'    => 'root',
            // 数据库密码
            'password'    => 'root',
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => '',
            // 数据库调试模式
            'debug'       => false,
        ];

        //老师关联班级
        public function grade(){
            return $this->belongsTo('grade');
        }
    }
?>