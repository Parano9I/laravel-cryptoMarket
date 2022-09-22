import Chart from 'chart.js/auto';
import jQuery from "jquery";

window.$ = window.jQuery = jQuery;

const ctx = $('#currency-chart');
const dFromSelect = $('#date-from-select').val();
const dToSelect = $('#date-to-select').val();
const userId = $('#userId').text();
const currencyName = window.location.pathname.substring(1).split('/')[1];
let chart;


const fetchCurrency = async (dateDiapason, currency, userId) => {
    const url = `/api/currencies/${currency}/user/${userId}?dfrom=${dateDiapason[0]}&dto=${dateDiapason[1]}`;
    const res = await fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    });
    const data = res.json();

    return data;
};

const formatedData = (data) => {
    return data.reduce(
        (acc, curr) => {
            const obj = {
                x: new Date(curr.date).toLocaleString(),
                y: curr.price
            }

            acc.push(obj);

            return acc;
        }, []
    );
};

const updateDataChart = (chart, data) => {
    chart.data.datasets[0].data = data;
    chart.update();
}

const renderChart = (data) => {

    if (chart) {
        updateDataChart(chart, data);
        return 0;
    }

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'SOL',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
            }]
        },
    });
}

const renderErrorMsg = (msg) => {
    $('#error')
        .text(msg)
        .show();
}

fetchCurrency(
    [dFromSelect, dToSelect],
    currencyName,
    userId
)
    .then((res) => formatedData(res.data))
    .then((data) => renderChart(data))


$('#chart-date-form').submit(function (e) {
    e.preventDefault();

    const dFromSelect = $('#date-from-select').val();
    const dToSelect = $('#date-to-select').val();

    $('#errror').remove();
    fetchCurrency(
        [dFromSelect, dToSelect],
        currencyName,
        userId
    )
        .then((res) => formatedData(res.data))
        .then((data) => renderChart(data))
});

