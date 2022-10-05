const guest = ({next, from}) => {

    if(localStorage.getItem('token')){
        return next(from.path);
    }

    return next();
};

export default guest;
