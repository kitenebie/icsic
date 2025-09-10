<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiModelResource\Pages;
use App\Filament\Resources\AiModelResource\RelationManagers;
use App\Models\AiModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Http;
use DOMDocument;

class AiModelResource extends Resource
{
    protected static ?string $model = AiModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-code-bracket-square';


    public static function getNavigationSort(): ?int
    {
        return 999;
    }
    public static function canAccess(array $parameters = []): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public static function getModelOptions(): array
    {
        $response = Http::get('https://openrouter.ai/models/?fmt=cards&input_modalities=text&max_price=0&q=free&output_modalities=text');

        if ($response->successful()) {
            $html = $response->body();
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');
            $options = [];

            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                if (!empty($href) && strpos($href, '/') === 0) { // Starts with /
                    $modelId = ltrim($href, '/'); // Remove leading /
                    $options[$modelId] = $modelId;
                }
            }

            return $options;
        }

        return [];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('model')
                    ->rules(['required', 'max:255'])
                    ->afterStateUpdated(function ($state) {
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->body('Changes to the model ' . $state . ' have been saved.')
                            ->send();
                    })

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Ai_Models')
                    ->form([
                        Select::make('model_name')
                            ->label('Available Model')
                            ->options(fn () => self::getModelOptions())
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        AiModel::whereNot('id', null)->update([
                            'model' => $data['model_name']
                        ]);
                    })
            ])
            ->actions([])
            ->bulkActions([]);
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
            'index' => Pages\ListAiModels::route('/'),
        ];
    }
}
