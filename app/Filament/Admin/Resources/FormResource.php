<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\Form\Status;
use App\Enums\Form\Type;
use App\Filament\Admin\Resources\FormResource\Actions\Tables\PublishAction;
use App\Filament\Admin\Resources\FormResource\Pages;
use App\Filament\Admin\Resources\FormResource\Schemas\FormSchema;
use App\Forms\Components\Repeater;
use App\Models\Form as FormModel;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FormResource extends Resource
{
    use Translatable;

    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isScopedToTenant = false;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.configurations');
    }

    public static function getModelLabel(): string
    {
        return __('app.form.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.form.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('app.field.name'))
                            ->required()
                            ->translatable(),

                        Select::make('type')
                            ->label(__('app.field.form_type'))
                            ->options(Type::options())
                            ->required(),

                        RichEditor::make('description')
                            ->label(__('app.field.description'))
                            ->required()
                            ->translatable()
                            ->columnSpanFull(),
                    ]),

                Repeater::make('sections')
                    ->relationship('sections')
                    ->label(__('app.field.sections'))
                    ->hiddenLabel()
                    ->reorderable()
                    ->orderColumn('order')
                    ->minItems(1)
                    ->addActionAlignment(Alignment::Start)
                    ->addAction(
                        fn (Action $action) => $action
                            ->icon('heroicon-s-plus')
                            ->color('primary')
                            ->link()
                    )
                    ->itemLabel(fn (array $state) => data_get($state, 'name.' . app()->getLocale()))
                    ->cloneable()
                    ->collapsible()
                    ->columnSpanFull()

                    ->schema(FormSchema::getSectionSchema()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('app.field.status'))
                    ->badge(),

                TextColumn::make('type')
                    ->label(__('app.field.form_type')),

                TextColumn::make('created_at')
                    ->label(__('app.field.created_at'))
                    ->dateTime(),

                TextColumn::make('updated_at')
                    ->label(__('app.field.updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.field.status'))
                    ->options(Status::options()),

                SelectFilter::make('type')
                    ->label(__('app.field.form_type'))
                    ->options(Type::options()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),

                    Tables\Actions\EditAction::make(),

                    PublishAction::make(),

                    Tables\Actions\ReplicateAction::make(),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'view' => Pages\ViewForm::route('/{record}'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
