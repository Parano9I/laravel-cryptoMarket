import httpClient from './index';

const endPoint = '/currencies';

const getLatest = () => {
    return httpClient.get(
        endPoint + '/'
    )
};

const postTrackedCurrencies = (currencies, userId) => {
    return httpClient.post(
        endPoint + '/user/' + userId,
        {
            currencies: currencies
        }
    );
}

export {
    getLatest,
    postTrackedCurrencies,
}
