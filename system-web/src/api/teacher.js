import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'http://localhost/my-project/public/index/teacher',
    method: 'get',
    params: query
  })
}


export function fetchPv(pv) {
  return request({
    url: '/article/pv',
    method: 'get',
    params: { pv }
  })
}

//新增
export function createArticle(data) {
  return request({
    url: 'http://localhost/my-project/public/index/teacher/addTeacher',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: 'http://localhost/my-project/public/index/teacher/updateTeacher',
    method: 'post',
    data
  })
}

//删除

export function deletArticle(data){
  return request({
    url:'http://localhost/my-project/public/index/teacher/deleteTeacher',
    method:'delete',
    data
  })
}

//获取班级列表

export function getGrade(data){
	return request({
		url:'http://localhost/my-project/public/index/grade',
	    method:'get',
	    data
	})
}