@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'dark:text-gray-300']) }}>
