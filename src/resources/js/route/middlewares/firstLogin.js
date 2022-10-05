const firstLogin = ({next, to}) => {
    const isFirstLogin = JSON.parse(localStorage.getItem('user')).first_login;

    if(isFirstLogin) {
        return next(to.path);
    }

    return next();

};

export default firstLogin;
