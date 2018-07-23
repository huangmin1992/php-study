<?php
    namespace app\index\controller;
    use think\Request;
    use think\Controller;
    use think\Db;
    use app\index\model\Student as StudentModel;
    use think\Validate;

    class Student extends Controller
    {
        public function index()
        {
            // header('Access-Control-Allow-Origin:*');     
            // header('Access-Control-Allow-Methods:*');  
            // header('Access-Control-Allow-Headers:*');
            // header('Access-Control-Allow-Credentials:false');
            $request = request();
            $resData = $request->param();
            $page = isset($resData['page'])?$resData['page']:1;
            $limit = isset($resData['limit'])?$resData['limit']:10;
            $search = isset($resData['title'])?$resData['title']:'';
            $sort = isset($resData['sort'])?$resData['sort']:"desc";
            //获取所有学生数据
            $studentList = StudentModel::where('name','like','%'.$search.'%')
            ->order('update_time '.$sort)
            ->paginate($limit);
            // dump($studentList);

            //给结果集对象数组中的每个模板对象添加班级关联数据,非常重要
            foreach ($studentList as $value) {
                // dump($value->grade);
              $value -> grade = $value -> grade -> name;
            }

            // dump($studentList);
            // die($studentList);

            // $res = Db::table('student')
            // ->where('name','like','%'.$search.'%')
            // ->page($page,$limit)
            // ->order('update_time '.$sort)
            // ->select();
            $data['content'] = $studentList;
            $data['total'] = Db::name('student')->count();
            return json_encode($studentList);
        }
        //编辑
        public function updateStudent(){
            $request = request();
            $resData = $request->param();
            $validate = validate('Student');
            try{
                if(!$validate->scene('updateStudent')->check($request->param())){
                    exception($validate->getError(),400);
                }
            }catch(\Exception $e){
                $res['errorMsg'] = $e->getMessage();
                return json($res,400);
            }
            $res = Db::table('student')
            ->where('id',$request->param('id'))
            ->update([
                'name'  => $request->param('name'),
                'sex'   => $request->param('sex'),
                'age'   => $request->param('age'),
                'start_time' => $request->param('start_time'),
                'mobile'    => $request->param('mobile'),
                'email'     => $request->param('email'),
                'grade_id' => $request->param('grade_id')
            ]);
            $data['message'] = '修改成功';
            return json_encode($data);
        }
        //删除
        public function deleteStudent(){
            $request = request();
            dump($request->param());
            Db::table('student')
                ->where('id',$request->param('id'))
                ->delete();
            $data['message'] = '删除成功';
            return json_encode($data);
        }
        //新增
        public function addStudent(){
            $request = request();
            $data = new StudentModel($request->param());
            $validate = validate('Student');
            try{
                if(!$validate->scene('addStudent')->check($request->param())){
                    exception($validate->getError(), 400);
                }
            }catch(\Exception $e){
                $res['errorMsg'] = $e->getMessage();
                return json($res,400);
                // return $validate->getError();
            }
            $data->allowField(true)->save();
            // $res = Db::table('student')
            // ->page(1,10)
            // ->order('update_time desc')
            // ->select();
            //获取所有学生数据
            $studentList = StudentModel::order('update_time desc')
                        ->paginate(10);
            //给结果集对象数组中的每个模板对象添加班级关联数据,非常重要
            foreach ($studentList as $value) {
              $value -> grade = $value -> grade -> name;
            }
            return json_encode($studentList);
        }
        //搜索
        public function searchStudent(){
            $request = request();
            $resData = $request->param();
            $title = $resData['title'];
            $res = Db::table('student')
                ->where('title','like','%'.$title.'%')
                ->select();
                dump($res);
        }

    }
?>