import request from '@/utils/request'

export function loginByUsername(username, password) {
    const data = {
        username,
        password
    }
    return request({
        url: 'http://localhost/my-project/public/index/user',
        method: 'post',
        data
    })
}

export function logout() {
    return request({
        url: '/login/logout',
        method: 'post'
    })
}

export function getUserInfo(token) {
    return request({
        url: 'http://localhost/my-project/public/index/user/getUserInfo',
        method: 'get',
        params: { token }
    })
}

