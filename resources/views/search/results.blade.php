<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar Filters (Placeholder) -->
            <div class="col-span-1 hidden md:block">
                 <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden p-4">
                     <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-4">On this page</h3>
                     <div class="space-y-2">
                         <div class="flex items-center text-gray-600 dark:text-gray-400">
                             <input type="radio" checked class="mr-2 text-linkedin-blue focus:ring-linkedin-blue"> People
                         </div>
                         <div class="flex items-center text-gray-600 dark:text-gray-400">
                             <input type="radio" disabled class="mr-2 text-gray-300"> Jobs (Coming soon)
                         </div>
                         <div class="flex items-center text-gray-600 dark:text-gray-400">
                             <input type="radio" disabled class="mr-2 text-gray-300"> Companies (Coming soon)
                         </div>
                     </div>
                 </div>
            </div>

            <!-- Main Results -->
            <div class="col-span-1 md:col-span-3 space-y-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Results for "{{ $query }}"</h2>
                
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($users as $user)
                        <div class="p-4 flex items-start">
                             <img class="h-16 w-16 rounded-full object-cover border border-gray-200" src="{{ $user->profile?->avatar_path ? asset('storage/'.$user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=64&color=7F9CF5&background=EBF4FF' }}" alt="">
                             <div class="ml-4 flex-1">
                                 <div class="flex justify-between items-start">
                                     <div>
                                         <a href="{{ route('profile.show', $user) }}" class="text-lg font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                                            {{ $user->name }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $user->profile?->headline ?? 'Member at Connectin' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $user->profile?->location ?? 'Bangladesh' }}</p>
                                        
                                        @if(Auth::user()->isConnectedWith($user))
                                            <p class="text-xs text-green-600 mt-1 font-medium is-connected">• 1st</p>
                                        @endif
                                     </div>
                                     
                                     <div class="ml-4">
                                         @if(Auth::id() !== $user->id)
                                            @if(Auth::user()->isConnectedWith($user))
                                                <button class="font-semibold text-gray-600 border border-gray-400 hover:bg-gray-100 px-4 py-1.5 rounded-full transition">Message</button>
                                            @elseif(Auth::user()->hasPendingRequestFrom($user))
                                                <button class="font-semibold text-linkedin-blue border border-linkedin-blue hover:bg-blue-50 px-4 py-1.5 rounded-full transition">Accept</button>
                                            @elseif(Auth::user()->hasSentRequestTo($user))
                                                <button class="font-semibold text-gray-500 border border-gray-400 px-4 py-1.5 rounded-full cursor-not-allowed" disabled>Pending</button>
                                            @else
                                                <form method="POST" action="{{ route('connection.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                                    <button type="submit" class="font-semibold text-linkedin-blue border border-linkedin-blue hover:bg-blue-50 px-4 py-1.5 rounded-full transition">Connect</button>
                                                </form>
                                            @endif
                                        @endif
                                     </div>
                                 </div>
                             </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            No results found.
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-4">
                    {{ $users->appends(['q' => $query])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
