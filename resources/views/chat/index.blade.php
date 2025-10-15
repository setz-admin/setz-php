<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RAG Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" x-data="chatApp()">
                    <!-- Health Status Warning -->
                    <div class="mb-4" x-show="!healthStatus.connected && healthStatus.checked">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        RAG service is not connected. Please check the Python service is running.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Chat Area (2/3) -->
                        <div class="lg:col-span-2">
                            <!-- Messages Container -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 h-[600px] overflow-y-auto mb-4" id="messagesContainer">
                                <!-- Welcome Message -->
                                <div x-show="messages.length === 0" class="text-center text-gray-500 dark:text-gray-400 py-20">
                                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <p class="text-lg font-medium mb-2">Welcome to RAG Chat</p>
                                    <p class="text-sm">Start a conversation by typing a message below</p>
                                    <p class="text-xs mt-2 text-gray-400">Upload documents first for better answers!</p>
                                </div>

                                <!-- Messages -->
                                <template x-for="(message, index) in messages" :key="index">
                                    <div :class="message.role === 'user' ? 'flex justify-end mb-4' : 'flex justify-start mb-4'">
                                        <div :class="message.role === 'user' ? 'bg-blue-500 text-white rounded-lg py-3 px-4 max-w-[80%]' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg py-3 px-4 max-w-[80%] shadow'">
                                            <!-- User Message -->
                                            <template x-if="message.role === 'user'">
                                                <div>
                                                    <p class="text-sm whitespace-pre-wrap" x-text="message.content"></p>
                                                    <p class="text-xs opacity-75 mt-1" x-text="formatTime(message.timestamp)"></p>
                                                </div>
                                            </template>

                                            <!-- Assistant Message -->
                                            <template x-if="message.role === 'assistant'">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Assistant</span>
                                                    </div>
                                                    <div class="prose prose-sm dark:prose-invert max-w-none mb-2" x-html="formatMarkdown(message.content)"></div>

                                                    <!-- Sources -->
                                                    <template x-if="message.sources && message.sources.length > 0">
                                                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                                            <button @click="message.showSources = !message.showSources" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center">
                                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span x-text="message.showSources ? 'Hide Sources' : 'Show Sources (' + message.sources.length + ')'"></span>
                                                            </button>

                                                            <div x-show="message.showSources" x-collapse class="mt-2 space-y-2">
                                                                <template x-for="(source, sIndex) in message.sources" :key="sIndex">
                                                                    <div class="bg-gray-100 dark:bg-gray-700 rounded p-2 text-xs">
                                                                        <div class="font-semibold text-gray-700 dark:text-gray-300 mb-1 flex items-center justify-between">
                                                                            <span>
                                                                                <span x-text="source.document_name"></span>
                                                                                <span x-show="source.page_number" class="text-gray-500"> - Page <span x-text="source.page_number"></span></span>
                                                                            </span>
                                                                            <span class="text-green-600 dark:text-green-400 text-xs" x-text="Math.round(source.relevance_score * 100) + '%'"></span>
                                                                        </div>
                                                                        <p class="text-gray-600 dark:text-gray-400 italic" x-text="source.excerpt"></p>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </template>

                                                    <p class="text-xs text-gray-500 mt-2" x-text="formatTime(message.timestamp)"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- Loading Indicator -->
                                <div x-show="isLoading" class="flex justify-start mb-4">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg py-3 px-4 shadow">
                                        <div class="flex space-x-2">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Input -->
                            <form @submit.prevent="sendMessage" class="flex gap-2">
                                <input
                                    x-model="newMessage"
                                    type="text"
                                    placeholder="Type your message here..."
                                    maxlength="5000"
                                    class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    :disabled="isLoading"
                                />
                                <button
                                    type="submit"
                                    :disabled="isLoading || !newMessage.trim()"
                                    class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                                    <span x-show="!isLoading">Send</span>
                                    <span x-show="isLoading">
                                        <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </form>

                            <!-- Error Message -->
                            <div x-show="errorMessage" class="mt-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4" x-cloak>
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-red-700 dark:text-red-300" x-text="errorMessage"></p>
                                    </div>
                                    <button @click="errorMessage = ''" class="text-red-400 hover:text-red-600">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar (1/3) -->
                        <div class="space-y-4">
                            <!-- Conversation Info -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 text-sm">Current Conversation</h3>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 dark:text-gray-400">Messages:</span>
                                        <span class="font-mono text-gray-900 dark:text-gray-100" x-text="messages.length"></span>
                                    </div>
                                    <div x-show="conversationId" class="flex justify-between">
                                        <span class="text-gray-500 dark:text-gray-400">ID:</span>
                                        <span class="font-mono text-gray-900 dark:text-gray-100 truncate ml-2" x-text="conversationId ? conversationId.substring(0, 8) + '...' : 'N/A'"></span>
                                    </div>
                                </div>
                                <button @click="clearConversation" class="mt-3 w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded text-sm font-semibold transition-colors">
                                    New Conversation
                                </button>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 text-sm">Quick Actions</h3>
                                <div class="space-y-2">
                                    <button @click="checkHealth" class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded text-sm font-semibold transition-colors">
                                        Check Service Status
                                    </button>
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2 flex items-center text-sm">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tips
                                </h3>
                                <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1">
                                    <li>• Upload documents for accurate answers</li>
                                    <li>• Be specific in your questions</li>
                                    <li>• Click "Show Sources" to see references</li>
                                    <li>• Conversations are saved automatically</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function chatApp() {
            return {
                messages: [],
                newMessage: '',
                conversationId: null,
                isLoading: false,
                errorMessage: '',
                healthStatus: {
                    connected: true,
                    checked: false
                },

                init() {
                    this.checkHealth();
                    this.$watch('messages', () => {
                        this.$nextTick(() => this.scrollToBottom());
                    });
                },

                async checkHealth() {
                    try {
                        const response = await fetch('/api/chat/health', {
                            headers: { 'Accept': 'application/json' }
                        });
                        const data = await response.json();
                        this.healthStatus.connected = data.success;
                        this.healthStatus.checked = true;
                    } catch (error) {
                        this.healthStatus.connected = false;
                        this.healthStatus.checked = true;
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.isLoading) return;

                    const userMessage = {
                        role: 'user',
                        content: this.newMessage,
                        timestamp: new Date()
                    };

                    this.messages.push(userMessage);
                    const messageToSend = this.newMessage;
                    this.newMessage = '';
                    this.isLoading = true;
                    this.errorMessage = '';

                    try {
                        const response = await fetch('/api/chat/message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                message: messageToSend,
                                conversation_id: this.conversationId,
                                include_sources: true
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            const assistantMessage = {
                                role: 'assistant',
                                content: data.data.answer || data.data.response || 'No response received',
                                sources: data.data.sources || [],
                                timestamp: new Date(),
                                showSources: false
                            };
                            this.messages.push(assistantMessage);

                            if (data.data.conversation_id) {
                                this.conversationId = data.data.conversation_id;
                            }
                        } else {
                            throw new Error(data.error || 'Unknown error occurred');
                        }
                    } catch (error) {
                        this.errorMessage = 'Failed to send message: ' + error.message;
                        console.error('Chat error:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                clearConversation() {
                    if (this.messages.length > 0 && confirm('Start a new conversation? Current chat will be cleared.')) {
                        this.messages = [];
                        this.conversationId = null;
                        this.errorMessage = '';
                    } else if (this.messages.length === 0) {
                        this.conversationId = null;
                    }
                },

                scrollToBottom() {
                    const container = document.getElementById('messagesContainer');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                },

                formatTime(timestamp) {
                    const date = new Date(timestamp);
                    return date.toLocaleTimeString('de-DE', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },

                formatMarkdown(text) {
                    if (!text) return '';
                    return text
                        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.+?)\*/g, '<em>$1</em>')
                        .replace(/\n/g, '<br>')
                        .replace(/`(.+?)`/g, '<code class="bg-gray-100 dark:bg-gray-700 px-1 rounded text-xs">$1</code>');
                }
            }
        }
    </script>
</x-app-layout>
