<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar -->
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Manage my network</h3>
                    </div>
                    <div class="p-0">
                        <a href="{{ route('network.index') }}" class="flex justify-between items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                            <span class="flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Connections
                            </span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $connectionsCount }}</span>
                        </a>
                        <a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                             <span class="flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Groups
                            </span>
                             <span class="font-semibold text-gray-800 dark:text-gray-200">2</span>
                        </a>
                         <a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                             <span class="flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                Pages
                            </span>
                             <span class="font-semibold text-gray-800 dark:text-gray-200">5</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-1 md:col-span-3 space-y-4">
                
                <!-- Invitations -->
                @if($pendingRequests->isNotEmpty())
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Invitations</h3>
                            <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-700">See all {{ $pendingRequests->count() }}</a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($pendingRequests as $request)
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="h-16 w-16 rounded-full object-cover border border-gray-200" src="{{ $request->sender->profile?->avatar_path ? asset('storage/'.$request->sender->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($request->sender->name).'&size=64&color=7F9CF5&background=EBF4FF' }}" alt="">
                                        <div class="ml-4">
                                            <a href="{{ route('profile.show', $request->sender) }}" class="text-lg font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                                                {{ $request->sender->name }}
                                            </a>
                                            <p class="text-sm text-gray-500">{{ $request->sender->profile?->headline ?? 'Member at Connectin' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <form method="POST" action="{{ route('connection.update', $request->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="font-semibold text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 px-4 py-2 rounded-full transition">Ignore</button>
                                        </form>
                                        <form method="POST" action="{{ route('connection.update', $request->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="font-semibold text-linkedin-blue border border-linkedin-blue hover:bg-blue-50 px-6 py-2 rounded-full transition">Accept</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Suggestions -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">People you may know</h3>
                         <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-700">See all</a>
                    </div>
                    <div class="p-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($suggestions as $suggestion)
                            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden relative group">
                                <div class="h-16 bg-gray-200 dark:bg-gray-700 relative">
                                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $suggestion->profile?->banner_path ? asset('storage/'.$suggestion->profile->banner_path) : '' }}'); opacity: 0.5;"></div>
                                     <button class="absolute top-2 right-2 text-gray-600 bg-white/50 rounded-full p-1 opacity-0 group-hover:opacity-100 transition hover:bg-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <div class="px-4 pb-4 text-center -mt-8 relative z-10">
                                    <img class="h-16 w-16 mx-auto rounded-full object-cover border-2 border-white dark:border-gray-800 bg-white" src="{{ $suggestion->profile?->avatar_path ? asset('storage/'.$suggestion->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($suggestion->name).'&size=64&color=7F9CF5&background=EBF4FF' }}" alt="">
                                    <a href="{{ route('profile.show', $suggestion) }}" class="block mt-2 font-semibold text-gray-900 dark:text-gray-100 hover:underline truncate">{{ $suggestion->name }}</a>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $suggestion->profile?->headline ?? 'Member at Connectin' }}</p>
                                    
                                     <form method="POST" action="{{ route('connection.store') }}" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $suggestion->id }}">
                                        <button type="submit" class="w-full font-semibold text-linkedin-blue border border-linkedin-blue hover:bg-blue-50 px-4 py-1.5 rounded-full transition flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Connect
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
