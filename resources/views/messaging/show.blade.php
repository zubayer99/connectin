<x-app-layout>
    <div class="py-12" style="height: calc(100vh - 64px);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar: Conversation List (Hidden on mobile when showing chat) -->
            <div class="hidden md:flex col-span-1 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex-col h-full">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Messaging</h2>
                </div>
                
                <div class="overflow-y-auto flex-1">
                    @forelse($conversations as $conv)
                        @php
                            $otherUserList = $conv->users->where('id', '!=', Auth::id())->first();
                        @endphp
                        <a href="{{ route('messaging.show', $conv) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700 {{ $conversation->id === $conv->id ? 'bg-blue-50 dark:bg-gray-900 border-l-4 border-l-linkedin-blue' : '' }}">
                            <div class="flex items-start space-x-3">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $otherUserList->profile?->avatar_path ? asset('storage/'.$otherUserList->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($otherUserList->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                                <div class="flex-1 overflow-hidden">
                                     <div class="flex justify-between items-baseline">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $otherUserList->name }}</h3>
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

            <!-- Chat Area -->
            <div class="col-span-1 md:col-span-3 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col h-full">
                @php
                    $otherUser = $conversation->users->where('id', '!=', Auth::id())->first();
                @endphp
                
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center space-x-3">
                         <a href="{{ route('messaging.index') }}" class="md:hidden text-gray-500">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                         </a>
                         <a href="{{ route('profile.show', $otherUser) }}">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $otherUser->profile?->avatar_path ? asset('storage/'.$otherUser->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                        </a>
                        <div>
                            <a href="{{ route('profile.show', $otherUser) }}" class="font-bold text-gray-900 dark:text-gray-100 hover:underline">{{ $otherUser->name }}</a>
                            <p class="text-xs text-gray-500">{{ $otherUser->profile?->headline ?? 'Member' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900 flex flex-col-reverse" id="messages-container">
                    <!-- Flex-col-reverse keeps scroll at bottom, but we need to reverse message order in loop or logic. 
                    Let's just use flex-col and scroll to bottom with JS or CSS anchor.
                    Actually, let's stick to standard flow and scroll. -->
                </div>
                <!-- Re-rendering container to fix direction -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900" id="scrollable-messages">
                    @foreach($messages as $message)
                         <div class="flex {{ $message->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%] {{ $message->user_id === Auth::id() ? 'bg-linkedin-blue text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-r-2xl rounded-tl-2xl border border-gray-200 dark:border-gray-600' }} px-4 py-2 shadow-sm">
                                <p class="text-sm whitespace-pre-wrap">{{ $message->content }}</p>
                                <p class="text-[10px] {{ $message->user_id === Auth::id() ? 'text-blue-100' : 'text-gray-400' }} mt-1 text-right">{{ $message->created_at->format('h:i A') }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div id="scroll-anchor"></div>
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <form action="{{ route('messaging.reply', $conversation) }}" method="POST">
                        @csrf
                        <div class="flex space-x-2">
                            <textarea name="content" rows="2" class="flex-1 block w-full rounded-2xl border-gray-300 focus:border-gray-400 focus:ring-0 resize-none px-4 py-2 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Write a message..."></textarea>
                            <button type="submit" class="bg-linkedin-blue text-white px-4 rounded-full font-bold hover:bg-linkedin-dark transition self-end py-2">Send</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    
    <script>
        // Scroll to bottom
        const messageContainer = document.getElementById('scrollable-messages');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    </script>
</x-app-layout>
