@props(['disabled' => false])

<input type="file" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100',
]) !!}>
