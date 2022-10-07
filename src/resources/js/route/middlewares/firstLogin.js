const firstLogin = ({next, to, from}) => {
    const isFirstLogin = JSON.parse(localStorage.getItem('user')).first_login;

    if (isFirstLogin) {
        console.log('1')
        return next(to.path);

    }else if (to.path.includes('/preferences')) {
        console.log(from.path)
        return next(from.path);

    }

    return next();

};

export default firstLogin;
