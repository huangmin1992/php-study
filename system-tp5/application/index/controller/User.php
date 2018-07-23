<?php
    namespace app\index\controller;

    use think\Db;
    use think\Controller;
    use think\Request;
    use app\index\model\User as UserModel;

    class User extends Controller{
        public function index(){
            // dump(new UserModel);
            $request = request();
            $resData = $request->param();
            $username = isset($resData['username'])?$resData['username']:'';
            $password = isset($resData['password'])?$resData['password']:'';
            $user = new UserModel;
            $res = $user->where('name',$username)
                ->where('password',md5($password))
                ->find();
            if($res === NULL){
                $data['message'] = '账户或密码错误';
                return json_encode($data);
            }else{
                $api_token = md5('UserControllerIndex'.time().'123456');
                $data['token'] = $api_token;
                $user->where('name',$username)
                    ->update([
                        'token' => $api_token
                    ]);
                return json_encode($data);
            }
        }

        public function getUserInfo(){
            $request = request();
            $token = $request->param('token');
            $user = new UserModel;
            if($token){
                // $data['roles'] = 'admin';
                $res = $user->where('token',$token)
                    ->find();
                $data['name'] = $res['name'];
                $data['roles'][] = $res['role'];
                $data['introduction'] = $res['introduction'];
                $data['avatar'] = $res['avatar'];
            }else{
                return '还没登录';
            }
            return json_encode($data);
        }
        
    }

?>