<div class="text-sm leading-6 text-gray-600 dark:text-gray-400">
    {{ $shelter->address }}
</div>

<dl class="grid grid-cols-2 gap-4">
    @foreach ($attributes as $attribute)
        @php
            $variables = $shelter->shelterVariables->where('shelter_attribute_id', $attribute->id)->pluck('name');
        @endphp

        @continue($variables->isEmpty())

        <div>
            <dt class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                {{ $attribute->name }}
            </dt>
            <dd>
                {{ $variables->join(', ') }}
            </dd>
        </div>
    @endforeach
</dl>
