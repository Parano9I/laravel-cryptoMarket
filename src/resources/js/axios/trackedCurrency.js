import httpClient from './index';
import {authHeader} from "./headers";
import generateQueryParams from "../helpers/generateQueryParams";

const endPoint = '/currencies/user';

const postTrackedCurrencies = (currencies) => {
    return httpClient.post(
        endPoint + '/',
        {
            currencies: currencies
        },
        {
            headers: authHeader(),
        }
    );
}

const getTrackedCurrencies = () => {
    return httpClient.get(
        endPoint + '/',
    );
};

const getTrackedCurrenciesHistory = ($paramsObj) => {

    const paramsStr = generateQueryParams($paramsObj);

    return httpClient.get(
        endPoint.concat('/history/', paramsStr),
        {
            headers: authHeader(),
        }
    )
        ;
};

export {
    getTrackedCurrencies,
    getTrackedCurrenciesHistory,
    postTrackedCurrencies
}
