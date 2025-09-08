# Auto-Save Draft System

A comprehensive, production-ready auto-save draft system for Laravel applications with Livewire and Filament support.

## 🚀 Features

- **Automatic Saving**: Real-time form data saving with debouncing
- **Cross-Session Persistence**: Drafts persist across browser sessions
- **User-Friendly UI**: Beautiful notification banners and restore buttons
- **Multiple Storage Options**: Cache or database storage
- **Event-Driven Architecture**: Extensible with custom events
- **Error Handling**: Robust error handling and data validation
- **Performance Optimized**: Efficient storage and retrieval
- **Security**: User-specific draft isolation

## 📦 Installation

### 1. Include JavaScript Utility

Add the JavaScript utility to your main layout or specific pages:

```html
<!-- In your layout file -->
<script src="{{ asset('js/auto-save-draft.js') }}"></script>
```

Or include it in your Vite build:

```javascript
// In resources/js/app.js
import './auto-save-draft.js';
```

### 2. Include PHP Trait (Optional)

For server-side draft management, use the trait in your controllers or components:

```php
<?php

use App\Traits\HasDraftManagement;

class MyController extends Controller
{
    use HasDraftManagement;

    // Now you have access to draft methods
    public function saveUserDraft(Request $request)
    {
        return $this->saveDraft('user_form', $request->all());
    }
}
```

## 🎯 Quick Start

### Basic Usage with JavaScript

```html
<!-- In your form -->
<form id="my-form">
    <input type="text" name="title" placeholder="Enter title">
    <textarea name="content" placeholder="Enter content"></textarea>
    <button type="submit">Save</button>
</form>

<script>
// Initialize auto-save
const draftSystem = new AutoSaveDraft({
    draftKey: 'my-form-draft',
    saveDelay: 1000, // Save after 1 second of inactivity
    enableNotifications: true
});

// Listen for draft events
draftSystem.on('draftSaved', (data) => {
    console.log('Draft saved:', data);
});

draftSystem.on('draftRestored', (data) => {
    console.log('Draft restored:', data);
});
</script>
```

### Using Blade Components

```blade
{{-- Include the draft banner in your form --}}
<x-draft-banner
    draft-key="my-form-draft"
    title="Draft Available"
    description="You have unsaved changes from your last session."
    restore-text="Restore Changes"
    dismiss-text="Discard"
/>

<form wire:submit="save" x-data="{ title: '', content: '' }">
    <input type="text" x-model="title" name="title">
    <textarea x-model="content" name="content"></textarea>
    <button type="submit">Save</button>
</form>

<script>
// Auto-save with Alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        const data = { title: Alpine.store('form').title, content: Alpine.store('form').content };
        localStorage.setItem('my-form-draft', JSON.stringify(data));
    });
});
</script>
```

### Livewire Integration

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\HasDraftManagement;

class MyForm extends Component
{
    use HasDraftManagement;

    public $title = '';
    public $content = '';
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
                    let saved = JSON.parse(localStorage.getItem('my-form-draft') ?? '{}');
                    if (Object.keys(saved).length > 0) {
                        if (confirm('A saved draft was found. Do you want to restore it?')) {
                            for (let key in saved) {
                                \$wire.set('data.' + key, saved[key]);
                            }
                        } else {
                            localStorage.removeItem('my-form-draft');
                        }
                    }

                    // Auto-save draft
                    \$watch('\$wire.data', value => {
                        localStorage.setItem('my-form-draft', JSON.stringify(value));
                    });
                ",
            ])
            ->schema([
                TextInput::make('title')->required(),
                MarkdownEditor::make('content')->required(),
            ])
            ->statePath('data');
    }

    public function save()
    {
        $validatedData = $this->form->getState();

        // Save to database
        MyModel::create($validatedData);

        // Clear draft after successful save
        $this->clearDraft('my-form-draft');

        session()->flash('message', 'Saved successfully!');
    }

    public function render()
    {
        return view('livewire.my-form');
    }
}
```

## 🔧 Configuration Options

### JavaScript Options

```javascript
const draftSystem = new AutoSaveDraft({
    draftKey: 'my-form-draft',           // Unique identifier for the draft
    saveDelay: 1000,                     // Delay before saving (ms)
    maxRetries: 3,                       // Max retry attempts on failure
    enableNotifications: true,           // Show save notifications
    excludeFields: ['_token', 'password'], // Fields to exclude from drafts
    includeFiles: false,                 // Include file data in drafts
});
```

### PHP Trait Configuration

```php
class MyController extends Controller
{
    use HasDraftManagement;

    public function __construct()
    {
        $this->configureDrafts([
            'storage' => 'cache',        // 'cache' or 'database'
            'prefix' => 'draft',         // Draft key prefix
            'ttl' => 30,                 // Time to live in days
            'max_drafts_per_user' => 10, // Max drafts per user
            'auto_cleanup' => true,      // Auto cleanup expired drafts
        ]);
    }
}
```

## 🎨 UI Components

### Draft Notification Component

```blade
{{-- Full-featured notification --}}
<x-draft-notification
    draft-key="my-form-draft"
    title="Draft Found"
    description="You have unsaved form data from a previous session."
    position="top-right"
    variant="default"
    :auto-hide="true"
    auto-hide-delay="10000"
/>
```

### Draft Banner Component

```blade
{{-- Simple inline banner --}}
<x-draft-banner
    draft-key="my-form-draft"
    title="Draft Available"
    description="You have unsaved changes."
    variant="blue"
    :show-icon="true"
/>
```

## 📋 API Reference

### JavaScript Methods

```javascript
const draft = new AutoSaveDraft(options);

// Core methods
draft.saveDraft(data);           // Manually save draft
draft.restoreDraft();            // Restore draft from storage
draft.clearDraft();              // Clear current draft
draft.hasDraft();                // Check if draft exists
draft.getDraft();                // Get draft data
draft.exportDraft();             // Export draft as JSON
draft.importDraft(jsonData);     // Import draft from JSON

// Event handling
draft.on('draftSaved', callback);     // Fired when draft is saved
draft.on('draftRestored', callback);  // Fired when draft is restored
draft.on('draftCleared', callback);   // Fired when draft is cleared
draft.on('saveError', callback);      // Fired on save error
draft.on('restoreError', callback);   // Fired on restore error

// Configuration
draft.configure(options);        // Update configuration
draft.destroy();                 // Clean up and destroy instance
```

### PHP Methods

```php
// Save draft
$this->saveDraft('key', ['field' => 'value'], ['metadata' => 'data']);

// Load draft
$draft = $this->loadDraft('key');

// Check if draft exists
$exists = $this->hasDraft('key');

// Delete draft
$this->deleteDraft('key');

// Get all user drafts
$drafts = $this->getUserDrafts();

// Clear expired drafts
$cleared = $this->clearExpiredDrafts();

// Get draft statistics
$stats = $this->getDraftStats();

// Export/Import drafts
$export = $this->exportDraft('key');
$this->importDraft($exportData);
```

## 🔒 Security Considerations

### User Isolation
- Drafts are automatically isolated by authenticated user ID
- Guest users use session ID for draft isolation
- No cross-user draft contamination

### Data Validation
- Automatic data validation before saving
- Configurable field exclusion for sensitive data
- Error handling for corrupted draft data

### Storage Security
- Draft data is stored client-side by default
- Server-side storage uses Laravel's secure caching
- Automatic cleanup of expired drafts

## 🚀 Advanced Usage

### Custom Storage Backend

```php
class CustomDraftStorage implements DraftStorageInterface
{
    public function save(string $key, array $data, int $ttl): bool
    {
        // Custom save logic
        return true;
    }

    public function load(string $key): ?array
    {
        // Custom load logic
        return null;
    }

    public function delete(string $key): bool
    {
        // Custom delete logic
        return true;
    }

    public function exists(string $key): bool
    {
        // Custom exists logic
        return false;
    }
}
```

### Custom Validation Rules

```javascript
const draftSystem = new AutoSaveDraft({
    // Custom validation function
    validateData: function(data) {
        // Return true if data is valid, false otherwise
        return data.title && data.title.length > 3;
    },

    // Custom save condition
    shouldSave: function(data) {
        // Only save if there are meaningful changes
        return Object.keys(data).length > 0;
    }
});
```

### Integration with Form Libraries

```javascript
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
            });
        },

        restoreDraft() {
            const draft = this.draftSystem.getDraft();
            if (draft) {
                this.formData = draft;
            }
        }
    }));
});
```

## 🐛 Troubleshooting

### Common Issues

**1. Drafts not saving**
```javascript
// Check if localStorage is available
if (typeof Storage === 'undefined') {
    console.error('localStorage not supported');
}

// Check for errors in console
draftSystem.on('saveError', (error) => {
    console.error('Save error:', error);
});
```

**2. Drafts not restoring**
```javascript
// Check draft data structure
const draft = localStorage.getItem('my-draft-key');
console.log('Draft data:', JSON.parse(draft));

// Verify form field names match
```

**3. Performance issues**
```javascript
// Increase save delay
const draftSystem = new AutoSaveDraft({
    saveDelay: 2000, // 2 seconds
    excludeFields: ['large_field', 'unnecessary_data']
});
```

### Debug Mode

```javascript
// Enable debug logging
const draftSystem = new AutoSaveDraft({
    debug: true
});

// Or manually log events
draftSystem.on('draftSaved', (data) => {
    console.log('📝 Draft saved:', data);
});

draftSystem.on('draftRestored', (data) => {
    console.log('🔄 Draft restored:', data);
});
```

## 📈 Performance Optimization

### Debouncing
```javascript
// Adjust save frequency based on form complexity
const draftSystem = new AutoSaveDraft({
    saveDelay: 500, // Faster for simple forms
    // or
    saveDelay: 2000, // Slower for complex forms
});
```

### Selective Saving
```javascript
// Only save specific fields
const draftSystem = new AutoSaveDraft({
    includeFields: ['title', 'content'], // Only save these fields
    excludeFields: ['_token', 'temp_data']
});
```

### Compression
```javascript
// Enable data compression for large forms
const draftSystem = new AutoSaveDraft({
    compressData: true,
    compressionLevel: 6 // 1-9, higher = better compression
});
```

## 🔄 Migration Guide

### From Manual localStorage

```javascript
// Old way
localStorage.setItem('my-draft', JSON.stringify(formData));

// New way
const draftSystem = new AutoSaveDraft({ draftKey: 'my-draft' });
draftSystem.saveDraft(formData);
```

### From Server-Side Only

```php
// Old way - only server side
$this->saveDraftToDatabase($key, $data);

// New way - hybrid approach
$this->saveDraft($key, $data); // Saves to both client and server
```

## 📝 Changelog

### Version 1.0.0
- Initial release
- Basic auto-save functionality
- localStorage and cache storage
- Blade components
- PHP trait
- Event system
- Error handling

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Add tests for new functionality
4. Ensure all tests pass
5. Submit a pull request

## 📄 License

This package is open-sourced software licensed under the MIT license.

## 🆘 Support

For support, please:
1. Check the troubleshooting section
2. Review the API documentation
3. Create an issue on GitHub
4. Check existing issues for similar problems

---

**Happy coding! 🎉**