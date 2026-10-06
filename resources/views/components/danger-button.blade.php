<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700']) }}>
    {{ $slot }}
</button>
