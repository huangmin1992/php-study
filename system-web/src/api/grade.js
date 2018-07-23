import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'http://localhost/my-project/public/index/grade',
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
    url: 'http://localhost/my-project/public/index/grade/addGrade',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: 'http://localhost/my-project/public/index/grade/updateGrade',
    method: 'post',
    data
  })
}

//删除

export function deletArticle(data){
  return request({
    url:'http://localhost/my-project/public/index/grade/deleteGrade',
    method:'delete',
    data
  })
}

//获取老师列表

export function getTeacher(data){
	return request({
		url:'http://localhost/my-project/public/index/teacher',
	    method:'get',
	    data
	})
}