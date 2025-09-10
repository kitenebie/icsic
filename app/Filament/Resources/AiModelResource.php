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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
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
        // Cache the results for 30 minutes to avoid repeated requests
        return Cache::remember('openrouter_models', 1800, function () {
            return self::fetchModelOptionsFromOpenRouter();
        });
    }

    private static function fetchModelOptionsFromOpenRouter(): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                ])
                ->get('https://openrouter.ai/models/?fmt=cards&input_modalities=text&max_price=0&q=free&output_modalities=text');

            if ($response->successful()) {
                $html = $response->body();
                $options = self::parseModelsFromHTML($html);

                if (!empty($options)) {
                    Log::info('Successfully fetched ' . count($options) . ' AI models from OpenRouter');
                    return $options;
                }
            }

            Log::warning('Failed to fetch models from OpenRouter, using fallback data');
            return self::getFallbackModelOptions();

        } catch (\Exception $e) {
            Log::error('Error fetching AI models from OpenRouter: ' . $e->getMessage());
            return self::getFallbackModelOptions();
        }
    }

    private static function parseModelsFromHTML(string $html): array
    {
        $options = [];

        try {
            // Create a DOMDocument instance
            $dom = new DOMDocument();
            
            // Suppress warnings for malformed HTML and load the HTML
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            libxml_clear_errors();

            // Create DOMXPath instance for easier querying
            $xpath = new \DOMXPath($dom);
            
            // Multiple XPath queries to find model links - ordered by specificity
            $queries = [
                // Most specific query using the exact class string
                '//a[@class="transition-colors text-secondary-foreground hover:text-foreground hover:underline underline-offset-2 text-base font-medium md:text-xl"]',
                // Fallback queries
                '//a[contains(@class, "transition-colors") and contains(@class, "text-secondary-foreground") and contains(@class, "hover:text-foreground")]',
                '//a[contains(@class, "transition-colors") and contains(@class, "text-secondary-foreground")]',
                '//a[contains(@href, ":free") and contains(@class, "transition-colors")]',
                '//a[contains(@class, "transition-colors")]'
            ];

            foreach ($queries as $query) {
                $links = $xpath->query($query);
                
                if ($links && $links->length > 0) {
                    /** @var \DOMElement $link */
                    foreach ($links as $link) {
                        if (!($link instanceof \DOMElement)) {
                            continue;
                        }
                        
                        $href = $link->getAttribute('href');
                        
                        // Skip if href is empty or doesn't look like a model path
                        if (empty($href) || !preg_match('/^\/[a-zA-Z0-9\-_\/]+:/', $href)) {
                            continue;
                        }
                        
                        $name = self::extractModelName($xpath, $link);
                        $modelKey = ltrim($href, '/');
                        
                        // Clean up the name and validate
                        $name = preg_replace('/\s+/', ' ', trim($name));
                        
                        if (!empty($href) && !empty($name) && strlen($name) > 3) {
                            $options[$modelKey] = $name;
                        }
                    }
                    
                    // If we found options with this query, break out
                    if (!empty($options)) {
                        break;
                    }
                }
            }

            // If DOM parsing failed, try regex approach as last resort
            if (empty($options)) {
                $options = self::parseModelsWithRegex($html);
            }

        } catch (\Exception $e) {
            Log::error('Error parsing HTML for AI models: ' . $e->getMessage());
        }

        return $options;
    }

    private static function extractModelName(\DOMXPath $xpath, \DOMElement $link): string
    {
        $name = '';
        
        // Get the text content from spans or the link itself
        $spans = $xpath->query('.//span', $link);
        
        if ($spans && $spans->length > 0) {
            // Try to get text from the first visible span (md:block)
            /** @var \DOMElement $span */
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
                $firstSpan = $spans->item(0);
                if ($firstSpan instanceof \DOMElement) {
                    $name = trim($firstSpan->textContent);
                }
            }
        } else {
            // Fallback to link text content
            $name = trim($link->textContent);
        }

        return $name;
    }

    private static function parseModelsWithRegex(string $html): array
    {
        $options = [];
        
        try {
            // Regex pattern to match anchor tags with href and extract content
            $pattern = '/<a[^>]*class="[^"]*transition-colors[^"]*"[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/s';
            
            if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $href = $match[1] ?? '';
                    $content = $match[2] ?? '';
                    
                    if (!empty($href) && preg_match('/^\/[a-zA-Z0-9\-_\/]+:/', $href)) {
                        // Extract text content from spans or use full content
                        $name = strip_tags($content);
                        $name = preg_replace('/\s+/', ' ', trim($name));
                        $modelKey = ltrim($href, '/');
                        
                        if (strlen($name) > 3) {
                            $options[$modelKey] = $name;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in regex parsing for AI models: ' . $e->getMessage());
        }
        
        return $options;
    }

    private static function getFallbackModelOptions(): array
    {
        return [
            'deepseek/deepseek-chat-v3.1:free' => 'deepseek-chat-v3.1',
            'deepseek/deepseek-chat-v3-0324:free' => 'deepseek-chat-v3-0324',
            'deepseek/deepseek-r1-0528:free' => 'deepseek-r1-0528',
            'qwen/qwen3-coder:free' => 'qwen3-coder',
            'z-ai/glm-4.5-air:free' => 'glm-4.5-air',
            'qwen/qwen3-235b-a22b:free' => 'qwen3-235b-a22b',
            'meta-llama/llama-3.3-70b-instruct:free' => 'meta-llama-3.3-70b-instruct',
            'google/gemini-2.0-flash-exp:free' => 'google-gemini-2.0-flash-exp',
            'mistralai/mistral-small-3.2-24b-instruct:free' => 'mistralai-mistral-small-3.2-24b-instruct',
            'openai/gpt-oss-20b:free' => 'openai-gpt-oss-20b',
            'qwen/qwen2.5-vl-72b-instruct:free' => 'qwen-qwen2.5-vl-72b-instruct',
            'meta-llama/llama-4-maverick:free' => 'meta-llama-4-maverick',
            'qwen/qwen3-14b:free' => 'qwen3-14b',
            'mistralai/mistral-nemo:free' => 'mistralai-mistral-nemo',
            'deepseek/deepseek-r1-distill-llama-70b:free' => 'deepseek-r1-distill-llama-70b',
            'google/gemma-3-27b-it:free' => 'google-gemma-3-27b-it',
            'qwen/qwen-2.5-coder-32b-instruct:free' => 'qwen-2.5-coder-32b-instruct',
            'moonshotai/kimi-dev-72b:free' => 'moonshotai-kimi-dev-72b',
            'agentica-org/deepcoder-14b-preview:free' => 'agentica-org-deepcoder-14b-preview',
            'qwen/qwen3-30b-a3b:free' => 'qwen-qwen3-30b-a3b',
            'mistralai/mistral-7b-instruct:free' => 'mistralai-mistral-7b-instruct',
            'meta-llama/llama-3.3-8b-instruct:free' => 'meta-llama-llama-3.3-8b-instruct',
            'meta-llama/llama-4-scout:free' => 'meta-llama-llama-4-scout',
            'cognitivecomputations/dolphin3.0-mistral-24b:free' => 'cognitivecomputations-dolphin3.0-mistral-24b',
            'openai/gpt-oss-120b:free' => 'openai-gpt-oss-120b',
        ];
    }

    public static function clearModelCache(): void
    {
        Cache::forget('openrouter_models');
        Log::info('OpenRouter models cache cleared');
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
                Tables\Actions\Action::make('refresh_models')
                    ->label('Refresh Models')
                    ->icon('heroicon-m-arrow-path')
                    ->color('gray')
                    ->action(function (): void {
                        self::clearModelCache();
                        Notification::make()
                            ->title('Cache Cleared')
                            ->success()
                            ->body('Model cache has been cleared. Models will be refetched on next load.')
                            ->send();
                    }),
                Tables\Actions\Action::make('update_ai_model')
                    ->label('Update AI Model')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->form([
                        Select::make('model_name')
                            ->label('Available Models')
                            ->options(fn () => self::getModelOptions())
                            ->searchable()
                            ->required()
                            ->helperText('Select from available free AI models on OpenRouter')
                            ->placeholder('Choose a model...'),
                    ])
                    ->action(function (array $data): void {
                        try {
                            $updated = AiModel::whereNotNull('id')->update([
                                'model' => $data['model_name']
                            ]);
                            
                            Notification::make()
                                ->title('Model Updated')
                                ->success()
                                ->body("Successfully updated {$updated} record(s) to use model: {$data['model_name']}")
                                ->send();
                        } catch (\Exception $e) {
                            Log::error('Error updating AI model: ' . $e->getMessage());
                            
                            Notification::make()
                                ->title('Update Failed')
                                ->danger()
                                ->body('Failed to update model. Please try again.')
                                ->send();
                        }
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