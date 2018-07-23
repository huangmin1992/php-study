<?php
    namespace app\index\controller;
    use think\Db;
    use think\Request;
    use think\Controller;
    use app\index\model\Grade as GradeModel;
    
    class Grade extends Controller{
        public function index(){
            $request = request();
            $resData = $request->param();
            $page = isset($resData['page'])?$resData['page'] : 1;
            $limit = isset($resData['limit'])?$resData['limit'] : 15;
            $search = isset($resData['title'])?$resData['title']:'';
            $sort = isset($resData['sort'])?$resData['sort']:'desc';

            $grade = GradeModel::where('name','like','%'.$search.'%')
                ->  order('update_time '.$sort)
                ->  paginate($limit);
            $name = array('name' => '暂无老师','grade_id' => 0);
            foreach($grade as $value){
                $value->teacher = isset($value->teacher->name) ? $value->teacher->name : $name;
            }
            // $grade = new Grade();
            // $res = Db::table('grade')
            //     ->where('name','like','%'.$search.'%')
            //     ->page($page,$limit)
            //     ->order('update_time '.$request->param('sort'))
            //     ->select();
            // $data['content'] = $grade;
            // $data['total'] = Db::table('grade')->count();
            return json_encode($grade);
        }
        //编辑
        public function updateGrade(){
            $request = request();
            $resData = $request->param();
            $validate = validate('Grade');
            if(!$validate->scene('updateGrade')->check($request->param())){
                $res['errorMsg'] = $validate->getError();
                $res['statusCode'] = 400;
                return json_encode($res);
            }
            $grade = new GradeModel;
            $grade->where('id',$request->param('id'))
                ->update([
                    'name'  =>  $request->param('name'),
                    'length'=>  $request->param('length'),
                    'price'=>   $request->param('price'),
                ]);
            $data['message'] = "编辑成功";
            return json_encode($data);
        }
        //删除
        public function deleteGrade(){
            $request = request();
            $grade = new GradeModel;
            $grade->where('id',$request->param('id'))
                ->delete();
            $data['message'] = '删除成功';
            return json_encode($data);
        }
        //新增
        public function addGrade(){
            $request = request();
            $grade = new GradeModel($request->param());
            $validate = validate('Grade');
            if(!$validate->scene('addGrade')->check($request->param())){
                $res['errorMsg'] = $validate->getError();
                $res['statusCode'] = 400;
                return json_encode($res);
            }
            $grade->allowField(true)->save();
            $res = Db::table('grade')
                ->page(1,15)
                ->order('update_time desc')
                ->select();
            $data['content'] = $res;
            $data['total'] = GradeModel::count();
            return json_encode($data);
        }

    }

?>