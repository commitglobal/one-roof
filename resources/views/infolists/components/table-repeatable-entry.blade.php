@php
    use Filament\Support\Enums\Alignment;

    $isContained = $isContained();
    $striped = $getStriped();
    $showIndex = $getShowIndex();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div
        {{ $attributes->merge(['id' => $getId()], escape: false)->merge($getExtraAttributes(), escape: false)->class([
                'fi-in-table-repeatable overflow-x-auto relative',
                'bg-white dark:bg-gray-900',
                'shadow-sm rounded-xl border border-gray-200 dark:border-white/10' => $isContained,
            ]) }}>
        <x-filament::grid
            :default="$getGridColumns('default')"
            :sm="$getGridColumns('sm')"
            :md="$getGridColumns('md')"
            :lg="$getGridColumns('lg')"
            :xl="$getGridColumns('xl')"
            :two-xl="$getGridColumns('2xl')"
            class="gap-4">
            <table
                class="w-full divide-y divide-gray-200 shadow table-auto filament-table-repeatable text-start dark:divide-white/5 rounded-xl ">
                <thead>
                    <tr>
                        @if ($showIndex)
                            <th
                                class="filament-table-repeateable-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                            </th>
                        @endif
                        @foreach ($getColumnLabels() as $label)
                            @php
                                $alignment = $label['alignment'];
                                if (!$alignment instanceof Alignment) {
                                    $alignment = filled($alignment)
                                        ? Alignment::tryFrom($alignment) ?? $alignment
                                        : null;
                                }
                            @endphp
                            <th
                                @class([
                                    'it-table-repeateable-header-cell text-gray-950 dark:text-white text-start py-3.5',
                                    'text-sm font-medium leading-6',
                                    'sm:first-of-type:ps-3 sm:last-of-type:pe-3' => $isContained,
                                    'pt-0' => !$isContained,
                                    match ($alignment) {
                                        Alignment::Start => 'text-start',
                                        Alignment::Center => 'text-center',
                                        Alignment::End => 'text-end',
                                        Alignment::Left => 'text-left',
                                        Alignment::Right => 'text-right',
                                        Alignment::Justify, Alignment::Between => 'text-justify',
                                        default => $alignment,
                                    },
                                    match ($alignment) {
                                        Alignment::Start, Alignment::Left => 'justify-start',
                                        Alignment::Center => 'justify-center',
                                        Alignment::End, Alignment::Right => 'justify-end',
                                        Alignment::Between, Alignment::Justify => 'justify-between',
                                        default => null,
                                    },
                                ])>{{ $label['name'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                    @foreach ($getChildComponentContainers() as $item)
                        <tr class="{{ $striped ? ($loop->index % 2 == 0 ? 'bg-gray-50 dark:bg-white/5' : '') : '' }}">
                            @if ($showIndex)
                                <td
                                    @class([
                                        'p-0 py-2 text-center it-table-repeateable-cell-label',
                                        'text-sm leading-6 text-gray-950 dark:text-white',
                                        'first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3' => $isContained,
                                    ])>
                                    {{ $loop->index }}</td>
                            @endif

                            @foreach ($item->getComponents() as $component)
                                <td
                                    @class([
                                        'p-0 py-2 text-center it-table-repeateable-cell',
                                        'text-sm leading-6 text-gray-950 dark:text-white',
                                        'first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3' => $isContained,
                                    ])>
                                    {{ $component }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::grid>
    </div>
</x-dynamic-component>
