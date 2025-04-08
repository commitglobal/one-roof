@php
    $gridDirection = $getGridDirection() ?? 'column';
    $id = $getId();
    $isDisabled = $isDisabled();
    $isInline = $isInline();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-filament::grid
        :default="$getColumns('default')"
        :sm="$getColumns('sm')"
        :md="$getColumns('md')"
        :lg="$getColumns('lg')"
        :xl="$getColumns('xl')"
        :two-xl="$getColumns('2xl')"
        :is-grid="! $isInline"
        :direction="$gridDirection"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'fi-fo-radio gap-4',
                    '-mt-4' => (! $isInline) && ($gridDirection === 'column'),
                    'flex flex-wrap' => $isInline,
                ])
        "
    >
        @foreach ($getOptions() as $value => $label)
            <label @class([
                'relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none',
                'bg-white dark:bg-gray-900 dark:border-white/10',
                'break-inside-avoid pt-4' => (! $isInline) && ($gridDirection === 'column'),
            ])>


                <div class="flex items-start flex-1">
                    <div class="grid text-sm leading-6 gap-y-2">
                        <span class="block font-medium text-gray-900 dark:text-white">
                            {{ $label }}
                        </span>

                        @if ($hasDescription($value))
                            <div class="text-gray-500 dark:text-gray-400 contents">
                                {{ $getDescription($value) }}
                            </div>
                        @endif
                    </div>
                </div>

                <x-filament::input.radio
                    :valid="! $errors->has($statePath)"
                    :attributes="
                        \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                            ->merge([
                                'disabled' => $isDisabled || $isOptionDisabled($value, $label),
                                'id' => $id . '-' . $value,
                                'name' => $id,
                                'value' => $value,
                                'wire:loading.attr' => 'disabled',
                                $applyStateBindingModifiers('wire:model') => $statePath,
                            ], escape: false)
                            ->class(['mt-1 sr-only peer'])
                    "
                />

                <x-heroicon-s-check-circle class="invisible size-5 text-primary-600 peer-checked:visible" />

                <span class="absolute border-2 border-transparent rounded-lg pointer-events-none -inset-px peer-checked:border-primary-600" aria-hidden="true"></span>
            </label>
        @endforeach
    </x-filament::grid>
</x-dynamic-component>
