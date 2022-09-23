import httpClient from './index.js';
import {authHeader} from "./headers";

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

const logout = () => {
    return httpClient.get(
        endPoint + '/logout',
        {
            headers: {
                ...authHeader
            },
        }
    )
};

const checkValidToken = () => {
    return httpClient.get(
        endPoint + '/check',
        {
            headers: {
                authHeader
            }
        }
    );
};


export {
    login,
    register,
    logout,
    checkValidToken,
};
