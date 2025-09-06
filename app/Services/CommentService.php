<?php

namespace App\Services;

use App\Models\announcementComment;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentService
{
    /**
     * Save a new comment
     *
     * @param array $data
     * @return array
     */
    public function saveComment(array $data): array
    {
        try {
            // Validate the input data
            $validator = $this->validateCommentData($data);
            
            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ];
            }

            // Prepare comment data
            $commentData = $this->prepareCommentData($data);

            // Save the comment
            $comment = announcementComment::create($commentData);

            Log::info('Comment saved successfully', [
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
                'post_id' => $comment->post_id
            ]);

            return [
                'success' => true,
                'message' => 'Comment saved successfully',
                'comment' => $comment
            ];

        } catch (\Exception $e) {
            Log::error('Failed to save comment', [
                'error' => $e->getMessage(),
                'data' => $data,
                'user_id' => Auth::id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to save comment: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Save a main comment
     *
     * @param int $postId
     * @param string $commentText
     * @return array
     */
    public function saveMainComment(int $postId, string $commentText): array
    {
        return $this->saveComment([
            'post_id' => $postId,
            'comment' => $commentText,
            'type' => 'main'
        ]);
    }

    /**
     * Save a reply comment
     *
     * @param int $postId
     * @param int $parentCommentId
     * @param string $commentText
     * @return array
     */
    public function saveReplyComment(int $postId, int $parentCommentId, string $commentText): array
    {
        return $this->saveComment([
            'post_id' => $postId,
            'reply_to' => $parentCommentId,
            'comment' => $commentText,
            'type' => 'reply'
        ]);
    }

    /**
     * Validate comment data
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateCommentData(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'post_id' => 'required|integer|exists:announcements,id',
            'comment' => 'required|string|min:1|max:10000',
            'type' => 'required|in:main,reply',
            'reply_to' => 'nullable|integer|exists:announcement_comments,id'
        ]);
    }

    /**
     * Prepare comment data for saving
     *
     * @param array $data
     * @return array
     */
    private function prepareCommentData(array $data): array
    {
        return [
            'post_id' => $data['post_id'],
            'commentatorId' => Auth::id(),
            'type' => $data['type'],
            'reply_to' => $data['reply_to'] ?? null,
            'comment' => strip_tags(trim($data['comment']))
        ];
    }

    /**
     * Get comments for a post
     *
     * @param int $postId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getComments(int $postId)
    {
        return announcementComment::where('post_id', $postId)
            ->where('type', 'main')
            ->with(['commentator', 'replies.commentator'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get replies for a comment
     *
     * @param int $commentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReplies(int $commentId)
    {
        return announcementComment::where('reply_to', $commentId)
            ->where('type', 'reply')
            ->with('commentator')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}