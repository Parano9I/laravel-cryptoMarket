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

export {
    getLatest,
    postTrackedCurrencies,
    getTrackedCurrencies,
}

