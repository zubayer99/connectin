<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Notifications</h2>
                </div>
                
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($notifications as $notification)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-start space-x-4 {{ $notification->read_at ? '' : 'bg-blue-50 dark:bg-gray-900' }}">
                            <a href="{{ route('profile.show', $notification->data['sender_id']) }}">
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ isset($notification->data['avatar_path']) && $notification->data['avatar_path'] ? asset('storage/'.$notification->data['avatar_path']) : 'https://ui-avatars.com/api/?name=U&color=7F9CF5&background=EBF4FF' }}" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="{{ $notification->data['link'] ?? '#' }}" class="block text-gray-900 dark:text-gray-100 font-medium hover:text-linkedin-blue hover:underline">
                                    {{ $notification->data['message'] }}
                                </a>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(is_null($notification->read_at))
                                <div class="h-3 w-3 bg-linkedin-blue rounded-full mt-2"></div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            You have no notifications yet.
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
