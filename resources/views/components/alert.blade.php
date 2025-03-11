@props([
    'icon' => null,
    'color' => 'info',
    'title' => null,
    'message' => null,
])

<div
    @class([
        'flex gap-3 p-4 rounded-md',
        'bg-custom-50 dark:bg-custom-950',
    ])
    @style([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [50, 200, 300, 400, 600, 700, 800, 950],
        ),
    ])>
    @if ($icon)
        <x-dynamic-component
            :component="$icon"
            class="w-5 h-5 fill-custom-400 dark:fill-custom-600 shrink-0" />
    @endif

    <div>
        @if ($title)
            <h3 class="text-sm font-medium text-custom-800 dark:text-custom-200">
                {{ $title }}
            </h3>
        @endif

        @if ($message)
            <p class="mt-2 text-sm text-custom-700 dark:text-custom-300">
                {{ $message }}
            </p>
        @endif
    </div>
</div>
