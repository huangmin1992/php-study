<?php
    namespace app\index\controller;
    
    use think\Db;
    use think\Controller;
    use think\Request;

    use app\index\model\Teacher as TeacherModel;

    class Teacher extends Controller{
        public function index(){
            $request = request();
            $resData = $request->param();
            $page = isset($resData['page'])?$resData['page']:1;
            $limit = isset($resData['limit'])?$resData['limit']:10;
            $sort = isset($resData['sort'])?$resData['sort']:"desc";
            $search = isset($resData['title'])?$resData['title']:'';
            $teacher = TeacherModel::where('name','like','%'.$search.'%')
                ->order('update_time '.$sort)
                ->paginate($limit);
            foreach($teacher as $value){
                $value->grade = $value->grade->name;
            }
            return json_encode($teacher);
        }

        //编辑
        public function updateTeacher(){
            $request = request();
            dump($request->param());
            $teacher = new TeacherModel;
            $teacher->where('id',$request->param('id'))
                ->update([
                    'name'  =>  $request->param('name'),
                    'degree'=>  $request->param('degree'),
                    'school'=>  $request->param('school'),
                    'hiredate'=> $request->param('startTime'),
                    'mobile'=>  $request->param('mobile'),
                    'grade_id'=>$request->param('grade_id')
                ]);
            $data['message'] = '编辑成功';
            return json_encode($data);
        }

        //删除
        public function deleteTeacher(){
            $request = request();
            $teacher = new TeacherModel;
            $teacher->where('id',$request->param('id'))->delete();
        }
        
        //新增
        public function addTeacher(){
            $request = request();
            $teacher = new TeacherModel($request->param());
            $teacher->allowField(true)->save();

            $teacherList = TeacherModel::order('update_time desc')
                ->paginate(10);

            foreach($teacherList as $value){
                $value->grade = $value->grade->name;
            }

            return json_encode($teacherList);

        }
    }

?>