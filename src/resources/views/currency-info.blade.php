<x-app-layout>
    <x-slot name="importFiles">
        @vite(['resources/js/currencyChart.js'])
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <span id="userId" style="display: none">{{$userId}}</span>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div>
                        <h3 class="mb-4 text-lg font-bold">Select date diapason</h3>
                        <form action="POST" id="chart-date-form">
                            <input type="date" id="date-from-select" value="{{ date('Y-m-d') }}"/>
                            <span>/</span>
                            <input type="date" id="date-to-select" value="{{ date('Y-m-d') }}"/>
                            <input class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
                                   type="submit"
                                   value="Accept"
                                   id="chart-date-submit"
                            >
                        </form>
                        <h2 class="mt-4 p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            id="error"
                            style="display: none"
                        >
                        </h2>
                    </div>
                    <canvas id="currency-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>