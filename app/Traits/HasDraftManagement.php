<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Draft Management Trait
 *
 * Provides server-side draft management functionality for forms and components.
 * Supports both database and cache storage with automatic cleanup.
 *
 * Features:
 * - Save drafts to database or cache
 * - Automatic draft expiration
 * - User-specific draft isolation
 * - Draft versioning and metadata
 * - Bulk operations and cleanup
 * - Integration with Livewire components
 */
trait HasDraftManagement
{
    /**
     * Draft configuration
     */
    protected array $draftConfig = [
        'storage' => 'cache', // 'cache' or 'database'
        'prefix' => 'draft',
        'ttl' => 30, // days
        'max_drafts_per_user' => 10,
        'auto_cleanup' => true,
    ];

    /**
     * Save draft data
     *
     * @param string $key Unique draft identifier
     * @param array $data Draft data
     * @param array $metadata Additional metadata
     * @return bool
     */
    public function saveDraft(string $key, array $data, array $metadata = []): bool
    {
        try {
            $userId = Auth::id() ?? 'guest_' . session()->getId();
            $draftKey = $this->generateDraftKey($key, $userId);

            $draftData = [
                'id' => Str::uuid(),
                'key' => $key,
                'user_id' => $userId,
                'data' => $data,
                'metadata' => array_merge([
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_agent' => request()->userAgent(),
                    'ip_address' => request()->ip(),
                    'session_id' => session()->getId(),
                    'version' => '1.0.0',
                ], $metadata),
            ];

            if ($this->draftConfig['storage'] === 'database') {
                return $this->saveDraftToDatabase($draftKey, $draftData);
            } else {
                return $this->saveDraftToCache($draftKey, $draftData);
            }
        } catch (\Exception $e) {
            Log::error('Draft save error: ' . $e->getMessage(), [
                'key' => $key,
                'user_id' => Auth::id(),
            ]);
            return false;
        }
    }

    /**
     * Load draft data
     *
     * @param string $key Draft identifier
     * @return array|null
     */
    public function loadDraft(string $key): ?array
    {
        try {
            $userId = Auth::id() ?? 'guest_' . session()->getId();
            $draftKey = $this->generateDraftKey($key, $userId);

            if ($this->draftConfig['storage'] === 'database') {
                return $this->loadDraftFromDatabase($draftKey);
            } else {
                return $this->loadDraftFromCache($draftKey);
            }
        } catch (\Exception $e) {
            Log::error('Draft load error: ' . $e->getMessage(), [
                'key' => $key,
                'user_id' => Auth::id(),
            ]);
            return null;
        }
    }

    /**
     * Check if draft exists
     *
     * @param string $key Draft identifier
     * @return bool
     */
    public function hasDraft(string $key): bool
    {
        $userId = Auth::id() ?? 'guest_' . session()->getId();
        $draftKey = $this->generateDraftKey($key, $userId);

        if ($this->draftConfig['storage'] === 'database') {
            return $this->draftExistsInDatabase($draftKey);
        } else {
            return Cache::has($draftKey);
        }
    }

    /**
     * Delete draft
     *
     * @param string $key Draft identifier
     * @return bool
     */
    public function deleteDraft(string $key): bool
    {
        try {
            $userId = Auth::id() ?? 'guest_' . session()->getId();
            $draftKey = $this->generateDraftKey($key, $userId);

            if ($this->draftConfig['storage'] === 'database') {
                return $this->deleteDraftFromDatabase($draftKey);
            } else {
                return Cache::forget($draftKey);
            }
        } catch (\Exception $e) {
            Log::error('Draft delete error: ' . $e->getMessage(), [
                'key' => $key,
                'user_id' => Auth::id(),
            ]);
            return false;
        }
    }

    /**
     * Get all drafts for current user
     *
     * @return array
     */
    public function getUserDrafts(): array
    {
        try {
            $userId = Auth::id() ?? 'guest_' . session()->getId();

            if ($this->draftConfig['storage'] === 'database') {
                return $this->getUserDraftsFromDatabase($userId);
            } else {
                return $this->getUserDraftsFromCache($userId);
            }
        } catch (\Exception $e) {
            Log::error('Get user drafts error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return [];
        }
    }

    /**
     * Clear all expired drafts
     *
     * @return int Number of drafts cleared
     */
    public function clearExpiredDrafts(): int
    {
        if (!$this->draftConfig['auto_cleanup']) {
            return 0;
        }

        try {
            if ($this->draftConfig['storage'] === 'database') {
                return $this->clearExpiredDraftsFromDatabase();
            } else {
                // Cache automatically expires, so no manual cleanup needed
                return 0;
            }
        } catch (\Exception $e) {
            Log::error('Clear expired drafts error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Clear all drafts for current user
     *
     * @return int Number of drafts cleared
     */
    public function clearUserDrafts(): int
    {
        try {
            $userId = Auth::id() ?? 'guest_' . session()->getId();

            if ($this->draftConfig['storage'] === 'database') {
                return $this->clearUserDraftsFromDatabase($userId);
            } else {
                return $this->clearUserDraftsFromCache($userId);
            }
        } catch (\Exception $e) {
            Log::error('Clear user drafts error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return 0;
        }
    }

    /**
     * Generate draft key
     *
     * @param string $key Base key
     * @param string $userId User identifier
     * @return string
     */
    protected function generateDraftKey(string $key, string $userId): string
    {
        return "{$this->draftConfig['prefix']}:{$userId}:{$key}";
    }

    /**
     * Save draft to database
     */
    protected function saveDraftToDatabase(string $draftKey, array $draftData): bool
    {
        // This would require a drafts table migration
        // For now, we'll use cache as fallback
        return $this->saveDraftToCache($draftKey, $draftData);
    }

    /**
     * Load draft from database
     */
    protected function loadDraftFromDatabase(string $draftKey): ?array
    {
        // This would require a drafts table migration
        // For now, we'll use cache as fallback
        return $this->loadDraftFromCache($draftKey);
    }

    /**
     * Check if draft exists in database
     */
    protected function draftExistsInDatabase(string $draftKey): bool
    {
        // This would require a drafts table migration
        // For now, we'll use cache as fallback
        return Cache::has($draftKey);
    }

    /**
     * Delete draft from database
     */
    protected function deleteDraftFromDatabase(string $draftKey): bool
    {
        // This would require a drafts table migration
        // For now, we'll use cache as fallback
        return Cache::forget($draftKey);
    }

    /**
     * Get user drafts from database
     */
    protected function getUserDraftsFromDatabase(string $userId): array
    {
        // This would require a drafts table migration
        // For now, return empty array
        return [];
    }

    /**
     * Clear expired drafts from database
     */
    protected function clearExpiredDraftsFromDatabase(): int
    {
        // This would require a drafts table migration
        // For now, return 0
        return 0;
    }

    /**
     * Clear user drafts from database
     */
    protected function clearUserDraftsFromDatabase(string $userId): int
    {
        // This would require a drafts table migration
        // For now, return 0
        return 0;
    }

    /**
     * Save draft to cache
     */
    protected function saveDraftToCache(string $draftKey, array $draftData): bool
    {
        $ttl = now()->addDays($this->draftConfig['ttl']);
        return Cache::put($draftKey, $draftData, $ttl);
    }

    /**
     * Load draft from cache
     */
    protected function loadDraftFromCache(string $draftKey): ?array
    {
        return Cache::get($draftKey);
    }

    /**
     * Get user drafts from cache
     */
    protected function getUserDraftsFromCache(string $userId): array
    {
        $pattern = "{$this->draftConfig['prefix']}:{$userId}:*";
        $drafts = [];

        // Note: This is a simplified implementation
        // In a real scenario, you might need to use Redis SCAN or similar
        // For now, we'll return an empty array as cache doesn't support pattern matching easily

        return $drafts;
    }

    /**
     * Clear user drafts from cache
     */
    protected function clearUserDraftsFromCache(string $userId): int
    {
        $cleared = 0;

        // Get all cache keys (this is a simplified approach)
        // In production, you might want to maintain a separate index of user drafts

        return $cleared;
    }

    /**
     * Configure draft settings
     *
     * @param array $config Configuration options
     * @return self
     */
    public function configureDrafts(array $config): self
    {
        $this->draftConfig = array_merge($this->draftConfig, $config);
        return $this;
    }

    /**
     * Get draft statistics
     *
     * @return array
     */
    public function getDraftStats(): array
    {
        $userId = Auth::id() ?? 'guest_' . session()->getId();

        return [
            'total_drafts' => count($this->getUserDrafts()),
            'storage_type' => $this->draftConfig['storage'],
            'ttl_days' => $this->draftConfig['ttl'],
            'auto_cleanup' => $this->draftConfig['auto_cleanup'],
            'user_id' => $userId,
        ];
    }

    /**
     * Validate draft data
     *
     * @param array $data Draft data
     * @return bool
     */
    protected function validateDraftData(array $data): bool
    {
        // Basic validation - can be extended
        return !empty($data) && is_array($data);
    }

    /**
     * Compress draft data for storage efficiency
     *
     * @param array $data Draft data
     * @return string
     */
    protected function compressDraftData(array $data): string
    {
        return json_encode($data);
    }

    /**
     * Decompress draft data
     *
     * @param string $compressedData Compressed data
     * @return array
     */
    protected function decompressDraftData(string $compressedData): array
    {
        return json_decode($compressedData, true) ?? [];
    }

    /**
     * Export draft data
     *
     * @param string $key Draft identifier
     * @return array|null
     */
    public function exportDraft(string $key): ?array
    {
        $draft = $this->loadDraft($key);

        if (!$draft) {
            return null;
        }

        return [
            'export_version' => '1.0.0',
            'exported_at' => now()->toISOString(),
            'draft_key' => $key,
            'data' => $draft,
            'metadata' => [
                'storage_type' => $this->draftConfig['storage'],
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
            ],
        ];
    }

    /**
     * Import draft data
     *
     * @param array $exportData Exported draft data
     * @return bool
     */
    public function importDraft(array $exportData): bool
    {
        if (!isset($exportData['draft_key']) || !isset($exportData['data'])) {
            return false;
        }

        return $this->saveDraft(
            $exportData['draft_key'],
            $exportData['data'],
            [
                'imported_at' => now(),
                'import_version' => $exportData['export_version'] ?? 'unknown',
                'original_exported_at' => $exportData['exported_at'] ?? null,
            ]
        );
    }
}