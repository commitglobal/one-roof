@php
    $locales = active_locales();
@endphp

<nav
    class="flex max-w-full p-2 mt-4 overflow-x-auto bg-white shadow-sm fi-tabs gap-x-2 rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    @foreach ($locales as $locale)
        <button wire:click="setLocale(@js($locale->code))"
            class="flex items-center justify-center px-3 py-2 text-sm font-medium transition duration-75 rounded-lg outline-none fi-tabs-item group gap-x-2 whitespace-nowrap "
            x-bind:class="{
                'hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5': @js(!$locale->isCurrent()),
                'fi-active fi-tabs-item-active bg-gray-50 dark:bg-white/5': @js($locale->isCurrent()),
            }">

            <span
                x-bind:class="{
                    'text-gray-500 group-hover:text-gray-700 group-focus-visible:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200 dark:group-focus-visible:text-gray-200': @js(!$locale->isCurrent()),
                    'text-primary-600 dark:text-primary-400': @js($locale->isCurrent()),
                }"
                class="transition duration-75 fi-tabs-item-label ">
                {{ $locale->native_name }}
            </span>
        </button>
    @endforeach
</nav>
