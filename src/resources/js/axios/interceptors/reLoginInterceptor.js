const reLoginInterceptor = (res, router) => {
    if (res.status === 401) {
        localStorage.clear();
        router.push({name: 'login'});
    }

    return res;
};

export default reLoginInterceptor;
