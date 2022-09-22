@props(['name', 'price', 'image'])

@php
$id = $name;
$price = number_format($price, 2);
$image = 'https://www.cryptocompare.com/media/' . $image;
@endphp

<div>
    <input type="checkbox" id="{{ $id }}-option" value="" name="{{ $id }}" class="hidden peer">
    <label for="{{ $id }}-option"
        class="flex flex-col cursor-pointer items-end justify-end sm:rounded-lg h-48 p-6 pb-2 text-white bg-no-repeat border-b-8 border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
        style="background-image: url('{{ $image }}'); background-size: 6rem; background-position: 1rem 1rem;">
        <h3 class="text-3xl font-bold">{{ $name }}</h3>
        <span class="text-2xl">${{ $price }}</span>
    </label>
</div>
