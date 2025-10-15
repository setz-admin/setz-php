<?php

declare(strict_types=1);

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public health check
Route::get('/chat/health', [ChatController::class, 'health'])->name('chat.health');

// Protected chat routes (require authentication)
Route::middleware(['auth:sanctum'])->prefix('chat')->name('chat.')->group(function () {
    // Chat messages
    Route::post('/message', [ChatController::class, 'sendMessage'])->name('message');

    // Conversations
    Route::post('/conversations', [ChatController::class, 'createConversation'])->name('conversations.create');
    Route::get('/conversations/{conversationId}', [ChatController::class, 'getConversation'])->name('conversations.show');

    // Documents
    Route::get('/documents', [ChatController::class, 'listDocuments'])->name('documents.index');
    Route::post('/documents', [ChatController::class, 'uploadDocument'])->name('documents.upload');
    Route::get('/documents/{documentId}/status', [ChatController::class, 'getDocumentStatus'])->name('documents.status');
    Route::delete('/documents/{documentId}', [ChatController::class, 'deleteDocument'])->name('documents.delete');

    // Statistics
    Route::get('/stats', [ChatController::class, 'getStats'])->name('stats');
});
