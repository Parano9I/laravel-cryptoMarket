const auth = ({next}) => {
    const isAuth = localStorage.getItem('token');

    if(!isAuth){
        return next({
            name: 'login'
        });
    }

    return next();
};

export default auth;
