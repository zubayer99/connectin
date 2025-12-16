<x-app-layout>
    <div class="py-12" style="height: calc(100vh - 64px);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar: Conversation List -->
            <div class="col-span-1 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col h-full">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Messaging</h2>
                </div>
                
                <div class="overflow-y-auto flex-1">
                    @forelse($conversations as $conv)
                        @php
                            $otherUser = $conv->users->where('id', '!=', Auth::id())->first();
                        @endphp
                        <a href="{{ route('messaging.show', $conv) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700 {{ isset($conversation) && $conversation->id === $conv->id ? 'bg-blue-50 dark:bg-gray-900 border-l-4 border-l-linkedin-blue' : '' }}">
                            <div class="flex items-start space-x-3">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $otherUser->profile?->avatar_path ? asset('storage/'.$otherUser->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                                <div class="flex-1 overflow-hidden">
                                     <div class="flex justify-between items-baseline">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $otherUser->name }}</h3>
                                        <span class="text-xs text-gray-500">{{ $conv->latestMessage?->created_at->diffForHumans(null, true, true) ?? '' }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 truncate mt-0.5 {{ $conv->latestMessage && !$conv->latestMessage->read_at && $conv->latestMessage->user_id !== Auth::id() ? 'font-bold text-gray-900 dark:text-white' : '' }}">
                                        {{ $conv->latestMessage->content ?? 'Start a conversation' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-gray-500 text-sm">
                            No messages yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chat Area: Placeholder for Index -->
            <div class="col-span-1 md:col-span-3 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col items-center justify-center p-8 text-center h-full">
                <img src="https://illustrations.popsy.co/gray/work-from-home.svg" alt="Select conversation" class="h-64 w-64 opacity-50 mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Select a message</h3>
                <p class="text-gray-500 mt-2">Choose from your existing conversations, start a new one, or just keep swimming.</p>
                <a href="{{ route('network.index') }}" class="mt-4 bg-linkedin-blue text-white px-6 py-2 rounded-full font-bold hover:bg-linkedin-dark transition">New Message</a>
            </div>

        </div>
    </div>
</x-app-layout>
