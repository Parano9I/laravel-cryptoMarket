<x-app-layout>
    <x-slot name="importFiles">
        @vite(['resources/js/dataTable.js'])
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
                        <input type="date" id="date-select" value="{{ date('Y-m-d') }}"/>
                    </div>
                    <table id="currency" class="display">
                        <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Diff</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
