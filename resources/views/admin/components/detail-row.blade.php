<div class="flex items-start">
    <div class="w-1/3 font-medium text-dark-tower flex items-center">
        <i class="{{ $icon }} mr-2 text-accent-tower w-4"></i> {{ $label }}
    </div>
    <div class="w-2/3 break-words">
        : {{ $value ?? '-' }}
    </div>
</div>
