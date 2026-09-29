@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-aether-primary focus:ring-aether-primary rounded-md shadow-sm']) }}>
