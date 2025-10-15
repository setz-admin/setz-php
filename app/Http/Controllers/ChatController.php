<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PythonServiceClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Controller for RAG-based chat functionality.
 */
class ChatController extends Controller
{
    private PythonServiceClient $pythonService;

    public function __construct(PythonServiceClient $pythonService)
    {
        $this->pythonService = $pythonService;
    }

    /**
     * Send a chat message and get RAG-based response.
     *
     * POST /api/chat/message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:5000',
            'conversation_id' => 'nullable|string|uuid',
            'include_sources' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $response = $this->pythonService->sendChatMessage(
                message: $request->input('message'),
                conversationId: $request->input('conversation_id'),
                includeSources: $request->input('include_sources', true)
            );

            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('Chat message failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to process your message. Please try again.',
            ], 500);
        }
    }

    /**
     * Create a new conversation.
     *
     * POST /api/chat/conversations
     *
     * @return JsonResponse
     */
    public function createConversation(): JsonResponse
    {
        try {
            $conversation = $this->pythonService->createConversation();

            return response()->json([
                'success' => true,
                'data' => $conversation,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create conversation', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to create conversation.',
            ], 500);
        }
    }

    /**
     * Get conversation history.
     *
     * GET /api/chat/conversations/{conversationId}
     *
     * @param string $conversationId
     * @return JsonResponse
     */
    public function getConversation(string $conversationId): JsonResponse
    {
        try {
            $conversation = $this->pythonService->getConversation($conversationId);

            return response()->json([
                'success' => true,
                'data' => $conversation,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get conversation', [
                'error' => $e->getMessage(),
                'conversation_id' => $conversationId,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Conversation not found.',
            ], 404);
        }
    }

    /**
     * Upload a document for RAG processing.
     *
     * POST /api/chat/documents
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadDocument(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,txt,doc,docx|max:20480', // 20MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('file');
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();

            $response = $this->pythonService->uploadDocument($filePath, $fileName);

            return response()->json([
                'success' => true,
                'data' => $response,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Document upload failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to upload document.',
            ], 500);
        }
    }

    /**
     * Get document processing status.
     *
     * GET /api/chat/documents/{documentId}/status
     *
     * @param string $documentId
     * @return JsonResponse
     */
    public function getDocumentStatus(string $documentId): JsonResponse
    {
        try {
            $status = $this->pythonService->getDocumentStatus($documentId);

            return response()->json([
                'success' => true,
                'data' => $status,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get document status', [
                'error' => $e->getMessage(),
                'document_id' => $documentId,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Document not found.',
            ], 404);
        }
    }

    /**
     * Delete a document.
     *
     * DELETE /api/chat/documents/{documentId}
     *
     * @param string $documentId
     * @return JsonResponse
     */
    public function deleteDocument(string $documentId): JsonResponse
    {
        try {
            $this->pythonService->deleteDocument($documentId);

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete document', [
                'error' => $e->getMessage(),
                'document_id' => $documentId,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to delete document.',
            ], 500);
        }
    }

    /**
     * List all documents.
     *
     * GET /api/chat/documents
     *
     * @return JsonResponse
     */
    public function listDocuments(): JsonResponse
    {
        try {
            $documents = $this->pythonService->listDocuments();

            return response()->json([
                'success' => true,
                'data' => $documents,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to list documents', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve documents.',
            ], 500);
        }
    }

    /**
     * Get vector store statistics.
     *
     * GET /api/chat/stats
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = $this->pythonService->getVectorStoreStats();

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get stats', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve statistics.',
            ], 500);
        }
    }

    /**
     * Test connection to Python RAG service.
     *
     * GET /api/chat/health
     *
     * @return JsonResponse
     */
    public function health(): JsonResponse
    {
        $isConnected = $this->pythonService->testConnection();

        return response()->json([
            'success' => $isConnected,
            'service' => 'Python RAG Service',
            'status' => $isConnected ? 'connected' : 'disconnected',
        ], $isConnected ? 200 : 503);
    }
}
