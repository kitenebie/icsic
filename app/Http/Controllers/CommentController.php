<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Store a new comment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->commentService->saveComment([
            'post_id' => $request->input('post_id'),
            'comment' => $request->input('comment'),
            'type' => $request->input('type', 'main'),
            'reply_to' => $request->input('reply_to')
        ]);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Store a main comment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeMainComment(Request $request): JsonResponse
    {
        $result = $this->commentService->saveMainComment(
            $request->input('post_id'),
            $request->input('comment')
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Store a reply comment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeReply(Request $request): JsonResponse
    {
        $result = $this->commentService->saveReplyComment(
            $request->input('post_id'),
            $request->input('parent_comment_id'),
            $request->input('comment')
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Get comments for a post
     *
     * @param int $postId
     * @return JsonResponse
     */
    public function getComments(int $postId): JsonResponse
    {
        $comments = $this->commentService->getComments($postId);
        
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }
}