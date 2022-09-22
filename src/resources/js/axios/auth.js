import httpClient from './index.js';

const endPoint = '/auth';

const login = (email, password) => {
    return httpClient.post(
        endPoint + '/login',
        {
            email,
            password
        }
    )
};

const register = (data) => {
    return httpClient.post(
        endPoint + '/registration',
        data
    )
};

const refresh = () => {
    const token = JSON.parse(localStorage.setItem('token'));

}

const logout = () => {
    return httpClient.get(
        endPoint + '/logout',
        {
            headers: {
                'Bearer': JSON.parse(localStorage.getItem('token')).token,
            }
        }
    )
};


export {
    login,
    register,
    logout,
    refresh
};
