import DataTable from "datatables.net-dt";
import jQuery from "jquery";

window.$ = window.jQuery = jQuery;

DataTable();

const datePicker = $('#date-select');
const date = datePicker.val();
const userId = $('#userId').text();

const table = $('#currency').DataTable({
    columns: [
        {
            title: 'Icon',
            render: (img) => {
                return `<img src="https://www.cryptocompare.com/media/${img}" width="40px">`;
            }
        },
        {title: 'Name'},
        {
            title: 'Price',
            render: (value) => {
                return new Intl.NumberFormat(
                    'en-US',
                    {
                        style: 'currency',
                        currency: 'USD'
                    }
                ).format(value);
            }
        },
        {
            title: 'Diff',
            render: (value) => {
                const colorText = value < 0 ? 'rgb(153 27 27)' : 'rgb(63 98 18)';
                return `<span style="color: ${colorText}">${value}%</span>`;
            }
        }
    ],
});

const fetchCurrencies = async (date, userId) => {
    const url = `/api/currencies/user/${userId}?date=${date}`;
    const res = await fetch(url);
    const data = res.json();
    return data;
};

const formatedData = (data) => {
    return data.data.map((currency) => {
        const lastValue = currency.data[0].price;
        const oldValue = currency.data.at(-1).price;
        const diff = ((((oldValue - lastValue) / oldValue) * 100).toFixed(2));
        console.log(lastValue);
        console.log(oldValue);
        console.log(diff);



        return [
            currency.image,
            currency.name,
            lastValue,
            diff,
        ];
    });
};

const renderRowsTable = (table, data) => {
    table.clear();
    table.rows.add(data);
    table.draw();

    table.on('click', 'tbody tr', function () {
        const currencyName = table.row(this).data()[1].toLowerCase();
        window.location.href = '/dashboard/' + currencyName;
    });

    $('tr').css('cursor', 'pointer');
    $('#currency_length').css('display', 'none');
}

fetchCurrencies(date, userId)
    .then((res) => formatedData(res))
    .then((data) => renderRowsTable(table, data));

datePicker.change((event) => {
    const date = event.target.value;
    fetchCurrencies(date, userId)
        .then((res) => formatedData(res))
        .then((data) => {
            renderRowsTable(table, data);
        });
});




