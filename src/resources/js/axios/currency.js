import httpClient from './index';
import generateQueryParams from "../helpers/generateQueryParams";

const endPoint = '/currencies';

const getCurrencies = ($queryParams) => {
    const queryParamsStr = $queryParams
        ? generateQueryParams($queryParams)
        : '';

    return httpClient.get(
        endPoint + '/' + queryParamsStr
    )
};


export {
    getCurrencies,
}

