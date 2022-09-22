<body>
<table align="center" width="400">
    @foreach($currencies as $currency)
    <tr>
        <tr>
            <th colspan="3">{{$currency[0]->currency->name}}</th>
        </tr>
        @foreach($currency as $history)
            <tr>
                <td colspan="1">{{$history->amount}}<td>
                <td colspan="1">{{$history->created_at}}<td>
            </tr>
        @endforeach
    </tr>
    @endforeach
</table>
</body>
