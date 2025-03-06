<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        @php
            $file = $getFile();
        @endphp

        @if ($file)
            @switch($file->type)
                @case('image')
                    <img
                        src="{{ $file->getFullUrl() }}"
                        alt="{{ $file->name }}"
                        class="w-full" />
                @break

                @case('pdf')
                    <iframe
                        src="{{ $file->getFullUrl() }}"
                        title="{{ $file->name }}"
                        class="w-full h-screen">
                    </iframe>
                @break

                @default
                    <x-filament-tables::empty-state
                        icon="heroicon-o-eye-slash"
                        :heading="__('app.documents.empty_state.no_preview.header')"
                        :description="__('app.documents.empty_state.no_preview.description')" />
            @endswitch
        @else
            <x-filament-tables::empty-state
                icon="heroicon-o-eye-slash"
                :heading="__('app.documents.empty_state.no_file.header')"
                :description="__('app.documents.empty_state.no_file.description')" />
        @endif
    </div>
</x-dynamic-component>
