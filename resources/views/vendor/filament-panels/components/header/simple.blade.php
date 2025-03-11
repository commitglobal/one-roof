@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

<header class="flex flex-col items-center fi-simple-header">
    @if ($logo)
        <x-filament-panels::logo class="mb-4" />
    @endif

    @if (filled($heading))
        <h1
            class="text-2xl font-bold tracking-tight text-center fi-simple-header-heading text-gray-950 dark:text-white">
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p
            class="mt-2 text-sm text-center text-gray-500 fi-simple-header-subheading dark:text-gray-400">
            {{ $subheading }}
        </p>
    @endif

    @if ($this instanceof \App\Contracts\TranslatablePage)
        <x-locale-switcher.public />
    @endif
</header>
