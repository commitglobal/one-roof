@if ($locales->count() > 1)
    <x-filament::dropdown
        placement="left-start"
        teleport>
        <x-slot name="trigger">
            <x-filament::dropdown.list.item icon="heroicon-o-language">
                @lang('app.language.actions.select')
            </x-filament::dropdown.list.item>
        </x-slot>

        <x-filament::dropdown.list>
            @foreach ($locales as $locale)
                <x-filament::dropdown.list.item
                    :color="$locale->isCurrent() ? 'primary' : null"
                    :action="route('preferred-locale', ['locale' => $locale->code])"
                    method="post"
                    tag="form">
                    {{ $locale->native_name }}
                </x-filament::dropdown.list.item>
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>
@endif
