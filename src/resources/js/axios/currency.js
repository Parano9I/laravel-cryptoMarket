import httpClient from './index';
import {authHeader} from "./headers";

const endPoint = '/currencies';

const getLatest = () => {
    return httpClient.get(
        endPoint + '/'
    )
};

const postTrackedCurrencies = (currencies) => {
    return httpClient.post(
        endPoint + '/user',
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
        endPoint + '/user',
    );
};

const getTrackedCurrenciesHistory = (currencies = [], dates = []) => {
    const params = {
        currencies: '?cs=' + currencies.join(','),
        dateFrom: '&dfrom=' + dates?.startDate,
        dateTo: '&dto=' + dates?.endDate,
    };

        return httpClient.get(
        endPoint + '/user'
        + (currencies ? params.currencies : '')
        + (dates ? params.dateFrom + params.dateTo : ''),
        {
            headers: authHeader(),
        }
    );
};

const getTrackedCurrencyHistories = (findCurrency = null, dates = []) => {
    const params = {
        currency: findCurrency ? findCurrency : '',
        dateFrom: dates.startDate ? '&dfrom=' + dates?.startDate : '',
        dateTo: dates.endDate ? '&dto=' + dates?.endDate : '',
    };

    return httpClient.get(
        endPoint
            + '/user/currency/'
            + params.currency
            + '?'
            + params.dateFrom
            + params.dateTo,
        {
            headers: authHeader(),
        }
    )
};

export {
    getLatest,
    postTrackedCurrencies,
    getTrackedCurrencies,
    getTrackedCurrencyHistories,
    getTrackedCurrenciesHistory
}

