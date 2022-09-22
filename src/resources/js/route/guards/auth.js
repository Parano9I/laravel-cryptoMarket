export default (to, from, next) => {
    const isAuth = localStorage.getItem('token');

    if (isAuth) {
        if (['login', 'register'].includes(to.name)) {
            next(from.path);
        } else {
            next();
        }
    } else {
        if (to.meta.auth) {
            next('login');
        } else {
            next();
        }
    }
};
