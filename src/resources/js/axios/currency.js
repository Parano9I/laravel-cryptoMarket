import httpClient from './index';
import  {authHeader} from "./headers";

const endPoint = '/currencies';

const getLatest = () => {
    return httpClient.get(
        endPoint + '/'
    )
};

const postTrackedCurrencies = (currencies, userId) => {
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

export {
    getLatest,
    postTrackedCurrencies,
}
