export default (objParams) => {
    let paramsStr = '';

    if (objParams) {
        paramsStr = '?';

        for (let [param, value] of Object.entries(objParams)) {

            if(value){

                if (Array.isArray(value)) {
                    value = value.join(',');
                }

                paramsStr = paramsStr.concat(param, '=', value, '&');
            }

        }

        return paramsStr.slice(0, -1);
    }

    return paramsStr;
};
