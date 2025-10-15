<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client for communicating with the Python RAG service.
 */
class PythonServiceClient
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.python_rag.base_url', 'http://localhost:8000');
        $this->timeout = (int) config('services.python_rag.timeout', 30);
    }

    /**
     * Create a base HTTP client with common configuration.
     */
    private function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);
    }

    /**
     * Send a chat message and get a response.
     *
     * @param string $message The user's message
     * @param string|null $conversationId Optional conversation ID for context
     * @param bool $includeSources Whether to include source citations
     * @return array Response with answer and optional sources
     * @throws \Exception
     */
    public function sendChatMessage(
        string $message,
        ?string $conversationId = null,
        bool $includeSources = true
    ): array {
        try {
            $response = $this->client()->post('/api/v1/chat/', [
                'message' => $message,
                'conversation_id' => $conversationId,
                'include_sources' => $includeSources,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Python service chat request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \Exception(
                "Chat request failed with status {$response->status()}: {$response->body()}"
            );
        } catch (\Exception $e) {
            Log::error('Python service communication error', [
                'error' => $e->getMessage(),
                'message' => $message,
            ]);
            throw $e;
        }
    }

    /**
     * Create a new conversation.
     *
     * @return array Conversation data with ID
     * @throws \Exception
     */
    public function createConversation(): array
    {
        try {
            $response = $this->client()->post('/api/v1/conversations/');

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "Create conversation failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to create conversation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get conversation history.
     *
     * @param string $conversationId The conversation ID
     * @return array Conversation data with messages
     * @throws \Exception
     */
    public function getConversation(string $conversationId): array
    {
        try {
            $response = $this->client()->get("/api/v1/conversations/{$conversationId}");

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "Get conversation failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to get conversation', [
                'error' => $e->getMessage(),
                'conversation_id' => $conversationId,
            ]);
            throw $e;
        }
    }

    /**
     * Upload a document for processing.
     *
     * @param string $filePath Path to the document file
     * @param string $fileName Original file name
     * @return array Document upload response
     * @throws \Exception
     */
    public function uploadDocument(string $filePath, string $fileName): array
    {
        try {
            $response = $this->client()->attach(
                'file',
                file_get_contents($filePath),
                $fileName
            )->post('/api/v1/documents/upload');

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "Document upload failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to upload document', [
                'error' => $e->getMessage(),
                'file_name' => $fileName,
            ]);
            throw $e;
        }
    }

    /**
     * Get document processing status.
     *
     * @param string $documentId The document ID
     * @return array Document status and metadata
     * @throws \Exception
     */
    public function getDocumentStatus(string $documentId): array
    {
        try {
            $response = $this->client()->get("/api/v1/documents/{$documentId}/status");

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "Get document status failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to get document status', [
                'error' => $e->getMessage(),
                'document_id' => $documentId,
            ]);
            throw $e;
        }
    }

    /**
     * Delete a document and its vectors.
     *
     * @param string $documentId The document ID
     * @return bool Success status
     * @throws \Exception
     */
    public function deleteDocument(string $documentId): bool
    {
        try {
            $response = $this->client()->delete("/api/v1/documents/{$documentId}");

            if ($response->successful()) {
                return true;
            }

            throw new \Exception(
                "Delete document failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to delete document', [
                'error' => $e->getMessage(),
                'document_id' => $documentId,
            ]);
            throw $e;
        }
    }

    /**
     * List all documents.
     *
     * @return array List of documents
     * @throws \Exception
     */
    public function listDocuments(): array
    {
        try {
            $response = $this->client()->get('/api/v1/documents/');

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "List documents failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to list documents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Test connection to the Python service.
     *
     * @return bool True if connection is successful
     */
    public function testConnection(): bool
    {
        try {
            $response = $this->client()->get('/api/v1/health');
            return $response->successful();
        } catch (\Exception $e) {
            Log::warning('Python service connection test failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Get vector store statistics.
     *
     * @return array Vector store statistics
     * @throws \Exception
     */
    public function getVectorStoreStats(): array
    {
        try {
            $response = $this->client()->get('/api/v1/vector-store/stats');

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception(
                "Get vector store stats failed with status {$response->status()}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to get vector store stats', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
