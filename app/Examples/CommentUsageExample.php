<?php

namespace App\Examples;

use App\Services\CommentService;

/**
 * Example usage of the CommentService
 */
class CommentUsageExample
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Example: Save a main comment
     */
    public function saveMainCommentExample()
    {
        $postId = 1; // Announcement ID
        $commentText = "This is a great announcement!";

        $result = $this->commentService->saveMainComment($postId, $commentText);

        if ($result['success']) {
            echo "Comment saved successfully! ID: " . $result['comment']->id;
        } else {
            echo "Error: " . $result['message'];
        }

        return $result;
    }

    /**
     * Example: Save a reply comment
     */
    public function saveReplyCommentExample()
    {
        $postId = 1; // Announcement ID
        $parentCommentId = 5; // Parent comment ID
        $commentText = "I agree with your comment!";

        $result = $this->commentService->saveReplyComment($postId, $parentCommentId, $commentText);

        if ($result['success']) {
            echo "Reply saved successfully! ID: " . $result['comment']->id;
        } else {
            echo "Error: " . $result['message'];
        }

        return $result;
    }

    /**
     * Example: Save comment using generic method
     */
    public function saveCommentGenericExample()
    {
        $result = $this->commentService->saveComment([
            'post_id' => 1,
            'comment' => 'This is my comment text',
            'type' => 'main', // or 'reply'
            'reply_to' => null // set to parent comment ID if it's a reply
        ]);

        return $result;
    }

    /**
     * Example: Get all comments for a post
     */
    public function getCommentsExample()
    {
        $postId = 1;
        $comments = $this->commentService->getComments($postId);
        
        foreach ($comments as $comment) {
            echo "Comment: " . $comment->comment . " by " . $comment->commentator->FirstName . "\n";
            
            // Show replies
            foreach ($comment->replies as $reply) {
                echo "  Reply: " . $reply->comment . " by " . $reply->commentator->FirstName . "\n";
            }
        }

        return $comments;
    }
}