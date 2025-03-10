<x-filament-panels::page.simple>

    @if ($this->recentlySuccessful)
        <div class="p-4 rounded-md bg-green-50">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="text-green-400 size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Order completed</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid pariatur, ipsum similique
                            veniam.</p>
                    </div>

                </div>
            </div>
        </div>
    @else
        <x-filament-panels::form wire:submit="handle">
            {{ $this->form }}

            <div class="flex justify-between w-full gap-4">
                <div>
                    @session('error')
                        <div class="p-4 border-l-4 border-danger-400 bg-danger-50">
                            <div class="flex gap-3">
                                {{-- <x-heroicon-s-exclamation class="w-5 h-5 text-danger-400 shrink-0" /> --}}

                                <p class="text-sm text-danger-700">
                                    {{ $value }}
                                </p>
                            </div>
                        </div>
                    @endsession
                </div>

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()" />
            </div>
        </x-filament-panels::form>
    @endif
</x-filament-panels::page.simple>
