<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\PythonServiceClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatIntegrationTest extends TestCase
{
    /**
     * Test that Python service health check works.
     */
    public function test_python_service_health_check(): void
    {
        // Mock successful health check
        Http::fake([
            '*/api/v1/health' => Http::response(['status' => 'ok'], 200),
        ]);

        $client = new PythonServiceClient();
        $isHealthy = $client->testConnection();

        $this->assertTrue($isHealthy);
    }

    /**
     * Test that Python service health check handles failures.
     */
    public function test_python_service_health_check_fails_gracefully(): void
    {
        // Mock failed health check
        Http::fake([
            '*/api/v1/health' => Http::response([], 500),
        ]);

        $client = new PythonServiceClient();
        $isHealthy = $client->testConnection();

        $this->assertFalse($isHealthy);
    }

    /**
     * Test sending a chat message.
     */
    public function test_send_chat_message(): void
    {
        Http::fake([
            '*/api/v1/chat/' => Http::response([
                'answer' => 'This is a test response',
                'conversation_id' => 'test-conv-123',
                'sources' => [],
            ], 200),
        ]);

        $client = new PythonServiceClient();
        $response = $client->sendChatMessage(
            message: 'What is AI?',
            conversationId: null,
            includeSources: true
        );

        $this->assertArrayHasKey('answer', $response);
        $this->assertArrayHasKey('conversation_id', $response);
        $this->assertEquals('This is a test response', $response['answer']);
    }

    /**
     * Test creating a conversation.
     */
    public function test_create_conversation(): void
    {
        Http::fake([
            '*/api/v1/conversations/' => Http::response([
                'conversation_id' => 'new-conv-456',
                'created_at' => now()->toISOString(),
            ], 200),
        ]);

        $client = new PythonServiceClient();
        $response = $client->createConversation();

        $this->assertArrayHasKey('conversation_id', $response);
        $this->assertEquals('new-conv-456', $response['conversation_id']);
    }

    /**
     * Test document upload.
     */
    public function test_upload_document(): void
    {
        Http::fake([
            '*/api/v1/documents/upload' => Http::response([
                'document_id' => 'doc-789',
                'status' => 'processing',
                'file_name' => 'test.pdf',
            ], 200),
        ]);

        $client = new PythonServiceClient();

        // Create a temporary test file
        $tempFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tempFile, 'Test content');

        $response = $client->uploadDocument($tempFile, 'test.pdf');

        $this->assertArrayHasKey('document_id', $response);
        $this->assertArrayHasKey('status', $response);

        // Cleanup
        unlink($tempFile);
    }

    /**
     * Test getting vector store stats.
     */
    public function test_get_vector_store_stats(): void
    {
        Http::fake([
            '*/api/v1/vector-store/stats' => Http::response([
                'collection_name' => 'rag_documents',
                'total_documents' => 42,
                'total_chunks' => 156,
            ], 200),
        ]);

        $client = new PythonServiceClient();
        $stats = $client->getVectorStoreStats();

        $this->assertArrayHasKey('collection_name', $stats);
        $this->assertArrayHasKey('total_documents', $stats);
        $this->assertEquals(42, $stats['total_documents']);
    }

    /**
     * Test error handling when Python service is unavailable.
     */
    public function test_handles_service_unavailable(): void
    {
        Http::fake([
            '*/api/v1/chat/' => Http::response([], 503),
        ]);

        $client = new PythonServiceClient();

        $this->expectException(\Exception::class);
        $client->sendChatMessage('Test message');
    }

    /**
     * Test that requests include proper headers.
     */
    public function test_requests_include_proper_headers(): void
    {
        Http::fake([
            '*/api/v1/chat/' => Http::response(['answer' => 'Test'], 200),
        ]);

        $client = new PythonServiceClient();
        $client->sendChatMessage('Test message');

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Accept', 'application/json') &&
                   $request->hasHeader('Content-Type', 'application/json');
        });
    }
}
