<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\ConfigurationResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\ConfigurationResource;
use App\Filament\Shelter\Resources\ConfigurationResource\Concerns\HasConfigurationMount;
use App\Models\Shelter\Attribute;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class EditAttributes extends EditRecord
{
    use DisablesBreadcrumbs;
    use HasConfigurationMount;

    protected static string $resource = ConfigurationResource::class;

    public function form(Form $form): Form
    {
        $schema = Attribute::query()
            ->whereAttribute()
            ->get()
            ->map(
                fn (Attribute $attribute, int $index) => CheckboxList::make("$index.$attribute->name")
                    ->label($attribute->name)
                    ->relationship(
                        'variables',
                        'name',
                        fn (Builder $query) => $query->where('attribute_id', $attribute->getKey())
                    )
            )
            ->all();

        return $form
            ->schema([
                Section::make(Str::ucfirst(__('app.attribute.label.plural')))
                    ->columns(3)
                    ->schema($schema),
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index', [
            'tab' => '-attributes-tab',
        ]);
    }
}
