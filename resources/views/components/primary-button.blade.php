<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-aether-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-aether-soft focus:bg-aether-soft active:bg-aether-ink focus:outline-none focus:ring-2 focus:ring-aether-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
