<?php

namespace App\Http\Controllers;

use App\Mail\CurrenciesEmail;
use App\Models\CurrencyHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function MongoDB\BSON\toJSON;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['userId' => Auth::user()->id]);
    }

    public function show(Request $request, $currency)
    {
        $userId = $request->user()->id;
        $hasFollowCurrency = !is_null(User::findOrFail($userId)
            ->currencies()
            ->where('name', strtoupper($currency))
            ->first());

        if (!$hasFollowCurrency) abort(404);

        return view('currency-info', ['userId' => $request->user()->id]);
    }
}
