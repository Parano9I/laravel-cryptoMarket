<x-guest-layout>
    <div class="h-screen flex flex-col sm:justify-center items-center p-6 bg-gray-900">
        <div
            class="lg:container lg:mx-auto h-full sm:max-w-md mt-6 px-6 py-6 pb-8 overflow-scroll sm:rounded-lg bg-gray-100">
            <h1 class="font-mono font-bold text-4xl">Preferences</h1>
            <h2 class="font-mono text-1xl mb-3">Select the currency you want to track</h2>
            <hr>
            <form action="{{ route('preferences') }}" method="post">
                @csrf
                <ul class="grid grid-cols-5 gap-4 auto-rows-fr py-6 overflow-y-scroll">
                    @foreach ($currencies as $currencyData)
                            <x-crypto-card id="{{ $currencyData->currency->id }}" price="{{ $currencyData->amount }}"
                                name="{{ $currencyData->currency->name }}"
                                image="{{ $currencyData->currency->image_url }}" />
                        </li>
                    @endforeach
                </ul>
                <x-button class="justify-self-end self-end">
                    {{ __('Accept') }}
                </x-button>
            </form>
        </div>
    </div>
















</x-guest-layout>
