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
            $options = [];

            // Create a DOMDocument instance
            $dom = new DOMDocument();
            
            // Suppress warnings for malformed HTML and load the HTML
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            // Create DOMXPath instance for easier querying
            $xpath = new \DOMXPath($dom);
            
            // Find all anchor tags with the specific class pattern
            $links = $xpath->query('//a[contains(@class, "transition-colors") and contains(@class, "text-secondary-foreground")]');

            foreach ($links as $link) {
                $href = '';
                if ($link instanceof \DOMElement) {
                    $href = $link->getAttribute('href');
                }
                
                // Get the text content from spans or the link itself
                $spans = $xpath->query('.//span', $link);
                $name = '';
                
                if ($spans->length > 0) {
                    // Try to get text from the first visible span (md:block)
                    foreach ($spans as $span) {
                        if ($span instanceof \DOMElement) {
                            $class = $span->getAttribute('class');
                            if (strpos($class, 'hidden') === false || strpos($class, 'md:block') !== false) {
                                $name = trim($span->textContent);
                                break;
                            }
                        }
                    }
                    
                    // If no suitable span found, use the first span
                    if (empty($name) && $spans->length > 0) {
                        $name = trim($spans->item(0)->textContent);
                    }
                } else {
                    // Fallback to link text content
                    $name = trim($link->textContent);
                }

                // Remove leading slash from href if present
                $modelKey = ltrim($href, '/');
                
                if (!empty($href) && !empty($name)) {
                    $options[$modelKey] = $name;
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