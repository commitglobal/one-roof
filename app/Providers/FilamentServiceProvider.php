<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Forms;
use Filament\Infolists;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public static string $defaultDateDisplayFormat = 'd.m.Y';

    public static string $defaultDateTimeDisplayFormat = 'd.m.Y H:i';

    public static string $defaultDateTimeWithSecondsDisplayFormat = 'd.m.Y H:i:s';

    public static string $defaultTimeDisplayFormat = 'H:i';

    public static string $defaultTimeWithSecondsDisplayFormat = 'H:i:s';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->setDateTimeDisplayFormats();

        $this->configureFormComponents();
        $this->configureInfolistComponents();
        $this->configureTableComponents();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function setDateTimeDisplayFormats(): void
    {
        Tables\Table::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Tables\Table::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Tables\Table::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Infolists\Infolist::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Infolists\Infolist::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Infolists\Infolist::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Forms\Components\DateTimePicker::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeWithSecondsDisplayFormat = static::$defaultDateTimeWithSecondsDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeWithSecondsDisplayFormat = static::$defaultTimeWithSecondsDisplayFormat;
    }

    protected function configureFormComponents(): void
    {
        Forms\Components\Repeater::configureUsing(function (Forms\Components\Repeater $repeater) {
            return $repeater->addActionAlignment(Alignment::Left);
        });
    }

    protected function configureInfolistComponents(): void
    {
        Infolists\Components\TextEntry::configureUsing(function (Infolists\Components\TextEntry $entry) {
            return $entry->default('—');
        });
    }

    protected function configureTableComponents(): void
    {
        Tables\Columns\Column::macro('shrink', function () {
            return $this->extraHeaderAttributes(['class' => 'w-1']);
        });
    }
}
