<?php

namespace App\Http\Controllers;

use App\Actions\PreferencesStoreAction;
use App\Models\CurrencyHistory;
use Illuminate\Http\Request;


class PreferencesController extends Controller
{
    /**
     * Render page.
     *
     * @return \Illuminate\View\View
     */

    public function index(CurrencyHistory $currencyHistory)
    {
        $currencies = $currencyHistory->getLastedData();
        return view('preferences', ['currencies' => $currencies]);
    }

    public function store(Request $request, PreferencesStoreAction $action)
    {
        $currenciesName = collect($request->except('_token'))->keys();
        $userId = request()->user()->id;

        if (empty($currenciesName)) {
            return redirect(route('preferences'));
        }

        $action->handle($currenciesName, $userId);

        return redirect(route('dashboard'));
    }
}
