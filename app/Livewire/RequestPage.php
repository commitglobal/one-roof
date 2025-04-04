<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Concerns\HasTranslatablePage;
use App\Contracts\TranslatablePage;
use App\Enums\Gender;
use App\Enums\SpecialNeed;
use App\Forms\Components\TableRepeater;
use App\Models\Country;
use App\Models\Request;
use App\Models\Shelter;
use Awcodes\TableRepeater\Header;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RequestPage extends SimplePage implements TranslatablePage
{
    use InteractsWithFormActions;
    use WithRateLimiting;
    use HasTranslatablePage;

    protected static string $layout = 'components.layout.public';

    protected bool $hasTopbar = false;

    protected bool $recentlySuccessful = false;

    protected static string $view = 'livewire.request-page';

    public ?array $data = [];

    public function getTitle(): string
    {
        return __('app.form.type.request');
    }

    public function getMaxWidth(): MaxWidth
    {
        return MaxWidth::FourExtraLarge;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function handle()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.title'))
                ->body(__('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->danger()
                ->send();

            return null;
        }

        Request::create($this->form->getState());
        $this->recentlySuccessful = true;
    }

    public function form(Form $form): Form
    {
        $shelters = Shelter::query()
            ->whereListed()
            ->get(['id', 'name', 'address']);

        return $form
            ->schema([
                Section::make()
                    ->columns()
                    ->schema([
                        Checkbox::make('somebody_else')
                            ->label(__('app.field.request_somebody_else'))
                            ->live(),

                        Checkbox::make('for_group')
                            ->label(__('app.field.request_group'))
                            ->live(),

                    ]),

                Section::make(__('app.field.requester'))
                    ->columns(3)
                    ->visible(fn (Get $get) => ($get('somebody_else')))
                    ->schema([
                        TextInput::make('requester.name')
                            ->label(__('app.field.name'))
                            ->maxLength(200)
                            ->required(),

                        TextInput::make('requester.email')
                            ->label(__('app.field.email'))
                            ->maxLength(200)
                            ->nullable()
                            ->email(),

                        TextInput::make('requester.phone')
                            ->label(__('app.field.phone'))
                            ->tel(),
                    ]),

                Section::make(__('app.field.beneficiary'))
                    ->columns(3)
                    ->schema([
                        TextInput::make('beneficiary.name')
                            ->label(__('app.field.name'))
                            ->required(),

                        TextInput::make('beneficiary.email')
                            ->label(__('app.field.email'))
                            ->email()
                            ->required(),

                        TextInput::make('beneficiary.phone')
                            ->label(__('app.field.phone'))
                            ->tel()
                            ->required(),

                        Select::make('gender')
                            ->label(__('app.field.gender'))
                            ->options(Gender::options())
                            ->enum(Gender::class)
                            ->required(),

                        TextInput::make('age')
                            ->label(__('app.field.age'))
                            ->minValue(0)
                            ->integer()
                            ->required(),

                        Select::make('departure_country_id')
                            ->label(__('app.field.departure_country'))
                            ->options(fn () => static::getCountries())
                            ->searchable()
                            ->required(),

                        Select::make('nationality_id')
                            ->label(__('app.field.nationality'))
                            ->options(fn () => static::getCountries())
                            ->searchable()
                            ->required(),
                    ]),

                Section::make(__('app.field.request_shelter'))
                    ->schema([
                        Radio::make('shelter_id')
                            ->label(__('app.field.request_shelter'))
                            ->columns()
                            ->hiddenLabel()
                            ->options($shelters->mapWithKeys(fn (Shelter $shelter) => [$shelter->id => $shelter->name]))
                            ->descriptions($shelters->mapWithKeys(fn (Shelter $shelter) => [$shelter->id => $shelter->address]))
                            ->required(),
                    ]),

                Section::make(__('app.field.group'))
                    ->visible(fn (Get $get) => $get('for_group'))
                    ->schema([
                        TableRepeater::make('group')
                            ->label(__('app.field.group'))
                            ->hiddenLabel()
                            ->minItems(1)
                            ->reorderable(false)
                            ->headers([
                                Header::make(__('app.field.name'))
                                    ->width('25%'),
                                Header::make(__('app.field.age'))
                                    ->width('80px'),
                                Header::make(__('app.field.notes')),
                            ])
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('app.field.name'))
                                    ->maxLength(200)
                                    ->required(),

                                TextInput::make('age')
                                    ->label(__('app.field.age'))
                                    ->minValue(0)
                                    ->integer()
                                    ->required(),

                                TextInput::make('notes')
                                    ->label(__('app.field.notes'))
                                    ->maxLength(200),
                            ]),

                    ]),

                Section::make(__('app.field.stay'))
                    ->columns()
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('app.field.start_date'))
                            ->required(),

                        DatePicker::make('end_date')
                            ->label(__('app.field.end_date'))
                            ->afterOrEqual('start_date')
                            ->required(),
                    ]),

                Section::make(__('app.field.special_needs'))
                    ->schema([
                        Select::make('special_needs')
                            ->options(SpecialNeed::options())
                            ->multiple()
                            ->live(),

                        Textarea::make('special_needs_notes')
                            ->label(__('app.field.special_needs_notes'))
                            ->visible(fn (Get $get) => filled($get('special_needs')))
                            ->rows(3),
                    ]),

                Section::make(__('app.field.notes'))
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('app.field.notes'))
                            ->hiddenLabel()
                            ->maxLength(500)
                            ->rows(10),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('handle')
                ->label(__('app.submit'))
                ->color('primary')
                ->submit('handle'),
        ];
    }

    protected static function getCountries(): Collection
    {
        return Cache::driver('array')
            ->rememberForever('countries', fn () => Country::pluck('name', 'id'));
    }
}
