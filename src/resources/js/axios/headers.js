
const authHeader = () => {
    const token = JSON.parse(localStorage.getItem('token'));

    if (token) {
        return {
            Authorization: 'Bearer ' + token.token,
        };
    } else return {};
}


export {
    authHeader,
}
