import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'http://localhost/my-project/public/index/student',
    method: 'get',
    params: query
  })
}

export function fetchArticle(id) {
  return request({
    url: '/article/detail',
    method: 'get',
    params: { id }
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
    url: 'http://localhost/my-project/public/index/student/addStudent',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: 'http://localhost/my-project/public/index/student/updateStudent',
    method: 'post',
    data
  })
}

//删除

export function deletArticle(data){
  return request({
    url:'http://localhost/my-project/public/index/student/deleteStudent',
    method:'delete',
    data
  })
}
//班级获取
export function getGrade(data){
  return request({
    url:'http://localhost/my-project/public/index/grade',
    method:'get',
    data
  })
}