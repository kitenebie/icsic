<?php

/**
 * Auto-Save Draft System - Usage Examples
 *
 * This file contains practical examples of how to implement
 * the auto-save draft system in various scenarios.
 */

namespace Examples;

use App\Traits\HasDraftManagement;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;

/**
 * Example 1: Basic Livewire Component with Auto-Save
 */
class BasicFormWithDrafts extends Component
{
    use HasDraftManagement;

    public $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes([
                'x-init' => "
                    // Check for existing draft
                    let saved = JSON.parse(localStorage.getItem('basic-form-draft') ?? '{}');
                    if (Object.keys(saved).length > 0) {
                        if (confirm('A saved draft was found. Do you want to restore it?')) {
                            for (let key in saved) {
                                \$wire.set('data.' + key, saved[key]);
                            }
                        } else {
                            localStorage.removeItem('basic-form-draft');
                        }
                    }

                    // Auto-save draft
                    \$watch('\$wire.data', value => {
                        localStorage.setItem('basic-form-draft', JSON.stringify(value));
                    });
                ",
            ])
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('description'),
                MarkdownEditor::make('content')->required(),
            ])
            ->statePath('data');
    }

    public function save()
    {
        $validatedData = $this->form->getState();

        // Save to database
        Post::create($validatedData);

        // Clear draft after successful save
        $this->clearDraft('basic-form-draft');

        session()->flash('message', 'Post created successfully!');
    }

    public function render()
    {
        return view('livewire.basic-form');
    }
}

/**
 * Example 2: Advanced Form with Server-Side Draft Management
 */
class AdvancedFormWithServerDrafts extends Component
{
    use HasDraftManagement;

    public $data = [];
    public $draftId = null;

    public function mount()
    {
        $this->configureDrafts([
            'storage' => 'cache',
            'ttl' => 7, // 7 days
            'auto_cleanup' => true,
        ]);

        $this->form->fill();

        // Load existing draft from server
        $draft = $this->loadDraft('advanced-form');
        if ($draft) {
            $this->data = $draft['data'];
            $this->draftId = $draft['id'];
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('category'),
                MarkdownEditor::make('content')->required(),
                FileUpload::make('attachments')->multiple(),
            ])
            ->statePath('data');
    }

    public function saveDraft()
    {
        $currentData = $this->form->getState();

        $metadata = [
            'form_step' => 'content',
            'has_attachments' => !empty($currentData['attachments']),
            'word_count' => str_word_count($currentData['content'] ?? ''),
        ];

        $result = $this->saveDraft('advanced-form', $currentData, $metadata);

        if ($result) {
            $this->dispatch('draft-saved', [
                'message' => 'Draft saved successfully!',
                'timestamp' => now()->toISOString(),
            ]);
        }
    }

    public function save()
    {
        $validatedData = $this->form->getState();

        // Save to database
        $post = Post::create($validatedData);

        // Clear draft after successful save
        $this->deleteDraft('advanced-form');

        session()->flash('message', 'Post created successfully!');
        return redirect()->route('posts.show', $post);
    }

    public function clearDraft()
    {
        $this->deleteDraft('advanced-form');
        $this->data = [];
        $this->draftId = null;

        $this->dispatch('draft-cleared');
    }

    public function render()
    {
        return view('livewire.advanced-form', [
            'draftStats' => $this->getDraftStats(),
        ]);
    }
}

/**
 * Example 3: Multi-Step Form with Draft Management
 */
class MultiStepForm extends Component
{
    use HasDraftManagement;

    public $currentStep = 1;
    public $totalSteps = 3;
    public $data = [];

    public $steps = [
        1 => ['title' => 'Basic Information', 'fields' => ['title', 'category']],
        2 => ['title' => 'Content', 'fields' => ['content', 'excerpt']],
        3 => ['title' => 'Media', 'fields' => ['featured_image', 'attachments']],
    ];

    public function mount()
    {
        $this->configureDrafts([
            'storage' => 'cache',
            'ttl' => 14, // 14 days for multi-step forms
        ]);

        // Load draft and determine current step
        $draft = $this->loadDraft('multi-step-form');
        if ($draft) {
            $this->data = $draft['data'];
            $this->currentStep = $draft['metadata']['current_step'] ?? 1;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->saveDraftWithStep();
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->saveDraftWithStep();
        }
    }

    private function saveDraftWithStep()
    {
        $metadata = [
            'current_step' => $this->currentStep,
            'completed_steps' => range(1, $this->currentStep),
            'progress_percentage' => ($this->currentStep / $this->totalSteps) * 100,
        ];

        $this->saveDraft('multi-step-form', $this->data, $metadata);
    }

    public function save()
    {
        $validatedData = collect($this->data)->only([
            'title', 'category', 'content', 'excerpt', 'featured_image', 'attachments'
        ])->toArray();

        // Save to database
        Post::create($validatedData);

        // Clear draft
        $this->deleteDraft('multi-step-form');

        session()->flash('message', 'Post created successfully!');
    }

    public function render()
    {
        return view('livewire.multi-step-form', [
            'currentStepData' => $this->steps[$this->currentStep],
            'progress' => ($this->currentStep / $this->totalSteps) * 100,
        ]);
    }
}

/**
 * Example 4: Collaborative Form with Draft Locking
 */
class CollaborativeForm extends Component
{
    use HasDraftManagement;

    public $data = [];
    public $isLocked = false;
    public $lockedBy = null;
    public $lockExpiresAt = null;

    public function mount()
    {
        // Check for existing draft and lock
        $draft = $this->loadDraft('collaborative-form');

        if ($draft) {
            $this->data = $draft['data'];

            // Check if draft is locked by another user
            if (isset($draft['metadata']['locked_by']) &&
                $draft['metadata']['locked_by'] !== auth()->id()) {

                $this->isLocked = true;
                $this->lockedBy = $draft['metadata']['locked_by'];
                $this->lockExpiresAt = $draft['metadata']['lock_expires_at'] ?? null;
            } else {
                // Acquire lock
                $this->acquireLock();
            }
        } else {
            // Acquire lock for new draft
            $this->acquireLock();
        }
    }

    private function acquireLock()
    {
        $metadata = [
            'locked_by' => auth()->id(),
            'locked_at' => now(),
            'lock_expires_at' => now()->addMinutes(30), // 30 minute lock
            'user_name' => auth()->user()->name,
        ];

        $this->saveDraft('collaborative-form', $this->data, $metadata);
    }

    public function save()
    {
        if ($this->isLocked && $this->lockedBy !== auth()->id()) {
            session()->flash('error', 'This form is currently being edited by another user.');
            return;
        }

        $validatedData = $this->form->getState();

        // Save to database
        Post::create($validatedData);

        // Clear draft and lock
        $this->deleteDraft('collaborative-form');

        session()->flash('message', 'Post created successfully!');
    }

    public function forceUnlock()
    {
        // Admin function to force unlock
        if (auth()->user()->hasRole('admin')) {
            $draft = $this->loadDraft('collaborative-form');
            if ($draft) {
                unset($draft['metadata']['locked_by']);
                unset($draft['metadata']['lock_expires_at']);
                $this->saveDraft('collaborative-form', $draft['data'], $draft['metadata']);
            }
        }
    }

    public function render()
    {
        return view('livewire.collaborative-form');
    }
}

/**
 * Example 5: Form with Auto-Save Indicator
 */
class FormWithIndicator extends Component
{
    use HasDraftManagement;

    public $data = [];
    public $lastSaved = null;
    public $isSaving = false;

    public function mount()
    {
        $draft = $this->loadDraft('indicator-form');
        if ($draft) {
            $this->data = $draft['data'];
            $this->lastSaved = $draft['metadata']['updated_at'] ?? null;
        }
    }

    public function updatedData()
    {
        $this->isSaving = true;

        // Debounced save
        $this->dispatch('save-draft-debounced', [
            'data' => $this->data,
            'delay' => 1000,
        ]);
    }

    public function saveDraft($data)
    {
        $metadata = [
            'updated_at' => now(),
            'auto_saved' => true,
            'field_count' => count(array_filter($data)),
        ];

        $result = $this->saveDraft('indicator-form', $data, $metadata);

        $this->isSaving = false;
        $this->lastSaved = now();

        if ($result) {
            $this->dispatch('draft-saved', [
                'timestamp' => $this->lastSaved,
            ]);
        }
    }

    public function save()
    {
        $validatedData = $this->data;

        // Save to database
        Post::create($validatedData);

        // Clear draft
        $this->deleteDraft('indicator-form');

        session()->flash('message', 'Post saved successfully!');
    }

    public function render()
    {
        return view('livewire.form-with-indicator', [
            'saveStatus' => $this->getSaveStatus(),
        ]);
    }

    private function getSaveStatus()
    {
        if ($this->isSaving) {
            return ['status' => 'saving', 'message' => 'Saving...'];
        }

        if ($this->lastSaved) {
            return [
                'status' => 'saved',
                'message' => 'Last saved ' . $this->lastSaved->diffForHumans(),
                'timestamp' => $this->lastSaved,
            ];
        }

        return ['status' => 'unsaved', 'message' => 'Unsaved changes'];
    }
}

/**
 * Example 6: Controller with Draft Management
 */
class PostController extends Controller
{
    use HasDraftManagement;

    public function __construct()
    {
        $this->configureDrafts([
            'storage' => 'database', // Use database for persistence
            'ttl' => 30,
            'max_drafts_per_user' => 20,
        ]);
    }

    public function create()
    {
        // Load existing draft
        $draft = $this->loadDraft('post-create');

        return view('posts.create', [
            'draft' => $draft,
            'draftStats' => $this->getDraftStats(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
        ]);

        // Save to database
        $post = Post::create($validated);

        // Clear draft after successful creation
        $this->deleteDraft('post-create');

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    public function saveDraft(Request $request)
    {
        $data = $request->only(['title', 'content', 'category']);

        $metadata = [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'saved_via' => 'api',
        ];

        $result = $this->saveDraft('post-create', $data, $metadata);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Draft saved' : 'Failed to save draft',
            'timestamp' => now()->toISOString(),
        ]);
    }

    public function loadDraft(Request $request)
    {
        $draft = $this->loadDraft('post-create');

        return response()->json([
            'draft' => $draft,
            'exists' => $draft !== null,
        ]);
    }

    public function clearDrafts()
    {
        $cleared = $this->clearUserDrafts();

        return response()->json([
            'cleared' => $cleared,
            'message' => "Cleared {$cleared} drafts",
        ]);
    }
}

/**
 * Example 7: API Controller for Draft Management
 */
class DraftApiController extends Controller
{
    use HasDraftManagement;

    public function index()
    {
        return response()->json([
            'drafts' => $this->getUserDrafts(),
            'stats' => $this->getDraftStats(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'data' => 'required|array',
            'metadata' => 'nullable|array',
        ]);

        $result = $this->saveDraft(
            $request->key,
            $request->data,
            $request->metadata ?? []
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Draft saved' : 'Failed to save draft',
        ], $result ? 200 : 500);
    }

    public function show($key)
    {
        $draft = $this->loadDraft($key);

        if (!$draft) {
            return response()->json([
                'error' => 'Draft not found',
            ], 404);
        }

        return response()->json([
            'draft' => $draft,
        ]);
    }

    public function update(Request $request, $key)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'metadata' => 'nullable|array',
        ]);

        $result = $this->saveDraft(
            $key,
            $request->data,
            $request->metadata ?? []
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Draft updated' : 'Failed to update draft',
        ], $result ? 200 : 500);
    }

    public function destroy($key)
    {
        $result = $this->deleteDraft($key);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Draft deleted' : 'Failed to delete draft',
        ], $result ? 200 : 500);
    }

    public function export($key)
    {
        $export = $this->exportDraft($key);

        if (!$export) {
            return response()->json([
                'error' => 'Draft not found',
            ], 404);
        }

        return response()->json($export);
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'export_data' => 'required|array',
        ]);

        $result = $this->importDraft($request->export_data);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Draft imported' : 'Failed to import draft',
        ], $result ? 200 : 500);
    }
}

/**
 * Example 8: Custom Draft Storage Implementation
 */
class RedisDraftStorage implements \App\Contracts\DraftStorageInterface
{
    protected $redis;

    public function __construct()
    {
        $this->redis = Redis::connection('drafts');
    }

    public function save(string $key, array $data, int $ttl): bool
    {
        try {
            $serialized = json_encode($data);
            return $this->redis->setex($key, $ttl * 86400, $serialized);
        } catch (\Exception $e) {
            \Log::error('Redis draft save error: ' . $e->getMessage());
            return false;
        }
    }

    public function load(string $key): ?array
    {
        try {
            $data = $this->redis->get($key);
            return $data ? json_decode($data, true) : null;
        } catch (\Exception $e) {
            \Log::error('Redis draft load error: ' . $e->getMessage());
            return null;
        }
    }

    public function delete(string $key): bool
    {
        try {
            return (bool) $this->redis->del($key);
        } catch (\Exception $e) {
            \Log::error('Redis draft delete error: ' . $e->getMessage());
            return false;
        }
    }

    public function exists(string $key): bool
    {
        try {
            return $this->redis->exists($key);
        } catch (\Exception $e) {
            \Log::error('Redis draft exists error: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllKeys(string $pattern): array
    {
        try {
            return $this->redis->keys($pattern);
        } catch (\Exception $e) {
            \Log::error('Redis draft keys error: ' . $e->getMessage());
            return [];
        }
    }
}

/**
 * Example 9: Draft Migration for Database Storage
 */
class CreateDraftsTable extends Migration
{
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->string('draft_key')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('session_id')->nullable()->index();
            $table->json('data');
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('expires_at')->nullable()->index();

            $table->index(['user_id', 'draft_key']);
            $table->index(['expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('drafts');
    }
}

/**
 * Example 10: JavaScript Integration Examples
 */
class JavaScriptExamples
{
    /**
     * Basic Auto-Save Setup
     */
    public static function basicSetup()
    {
        return "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const draftSystem = new AutoSaveDraft({
                draftKey: 'my-form-draft',
                saveDelay: 1000,
                enableNotifications: true
            });

            // Listen for draft events
            draftSystem.on('draftSaved', function(data) {
                console.log('Draft saved:', data);
            });

            draftSystem.on('draftRestored', function(data) {
                console.log('Draft restored:', data);
                // Populate form fields
                populateForm(data);
            });
        });

        function populateForm(data) {
            Object.keys(data).forEach(key => {
                const element = document.querySelector(`[name=\"${key}\"]`);
                if (element && data[key] !== null && data[key] !== undefined) {
                    element.value = data[key];
                }
            });
        }
        </script>
        ";
    }

    /**
     * Advanced Setup with Custom Validation
     */
    public static function advancedSetup()
    {
        return "
        <script>
        const draftSystem = new AutoSaveDraft({
            draftKey: 'advanced-form-draft',
            saveDelay: 1500,
            validateData: function(data) {
                // Custom validation
                return data.title && data.title.length >= 3;
            },
            shouldSave: function(data) {
                // Only save if meaningful changes
                return Object.keys(data).some(key =>
                    !key.startsWith('_') &&
                    data[key] !== null &&
                    data[key] !== ''
                );
            }
        });

        // Custom event handling
        draftSystem.on('saveError', function(error) {
            showNotification('Failed to save draft: ' + error.message, 'error');
        });

        draftSystem.on('draftSaved', function(data) {
            updateLastSavedTime(data.metadata.updated_at);
        });

        function showNotification(message, type) {
            // Implementation for showing notifications
            console.log(type.toUpperCase() + ':', message);
        }

        function updateLastSavedTime(timestamp) {
            const timeElement = document.getElementById('last-saved-time');
            if (timeElement) {
                timeElement.textContent = new Date(timestamp).toLocaleString();
            }
        }
        </script>
        ";
    }

    /**
     * Integration with Form Libraries
     */
    public static function formLibraryIntegration()
    {
        return "
        <script>
        // With Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.data('formWithDrafts', () => ({
                formData: {},
                draftSystem: null,

                init() {
                    this.draftSystem = new AutoSaveDraft({
                        draftKey: 'alpine-form-draft'
                    });

                    // Watch for changes
                    this.$watch('formData', (value) => {
                        this.draftSystem.saveDraft(value);
                    }, { deep: true });
                },

                restoreDraft() {
                    const draft = this.draftSystem.getDraft();
                    if (draft) {
                        this.formData = draft;
                        showNotification('Draft restored successfully!', 'success');
                    }
                },

                clearDraft() {
                    this.draftSystem.clearDraft();
                    this.formData = {};
                    showNotification('Draft cleared', 'info');
                }
            }));
        });

        // With Vue.js
        new Vue({
            el: '#app',
            data: {
                formData: {},
                draftSystem: null
            },
            mounted() {
                this.draftSystem = new AutoSaveDraft({
                    draftKey: 'vue-form-draft'
                });
            },
            watch: {
                formData: {
                    handler: function(newData) {
                        this.draftSystem.saveDraft(newData);
                    },
                    deep: true
                }
            },
            methods: {
                restoreDraft() {
                    const draft = this.draftSystem.getDraft();
                    if (draft) {
                        this.formData = draft;
                    }
                }
            }
        });
        </script>
        ";
    }
}

/**
 * Example 11: Testing Helpers
 */
class DraftTestingHelpers
{
    public static function createTestDraft($key = 'test-draft', $userId = null)
    {
        $userId = $userId ?? auth()->id() ?? 'test-user';

        return [
            'id' => Str::uuid(),
            'key' => $key,
            'user_id' => $userId,
            'data' => [
                'title' => 'Test Draft Title',
                'content' => 'Test draft content',
                'category' => 'test',
                'created_at' => now(),
            ],
            'metadata' => [
                'created_at' => now(),
                'updated_at' => now(),
                'user_agent' => 'Test/1.0',
                'ip_address' => '127.0.0.1',
                'session_id' => 'test-session',
                'version' => '1.0.0',
            ],
        ];
    }

    public static function assertDraftExists($key, $userId = null)
    {
        $userId = $userId ?? auth()->id();

        // Implementation for testing draft existence
        $draftKey = "draft:{$userId}:{$key}";

        if (Cache::has($draftKey)) {
            $draft = Cache::get($draftKey);
            assert(!empty($draft['data']), 'Draft data should not be empty');
            assert(isset($draft['metadata']), 'Draft should have metadata');
            return true;
        }

        return false;
    }

    public static function cleanupTestDrafts()
    {
        // Clean up test drafts from cache
        $testKeys = Cache::store()->getRedis()->keys('draft:*:test-*');

        foreach ($testKeys as $key) {
            Cache::forget(str_replace(Cache::getPrefix(), '', $key));
        }
    }
}

// Usage examples summary:
/*
1. Basic Livewire Component - Use HasDraftManagement trait
2. Advanced Server-Side - Configure storage and metadata
3. Multi-Step Forms - Save progress at each step
4. Collaborative Editing - Lock mechanism for concurrent users
5. Auto-Save Indicators - Show save status to users
6. API Integration - RESTful endpoints for draft management
7. Custom Storage - Redis or other storage backends
8. Database Migration - For persistent draft storage
9. JavaScript Integration - Various frontend frameworks
10. Testing Helpers - Utilities for testing draft functionality
*/

?>