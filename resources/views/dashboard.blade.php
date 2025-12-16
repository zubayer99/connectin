<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Left Sidebar (Profile Summary) -->
            <div class="col-span-1 hidden md:block space-y-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden relative">
                    <div class="h-16 bg-gray-200 dark:bg-gray-700 bg-cover bg-center" style="background-image: url('{{ Auth::user()->profile?->banner_path ? asset('storage/'.Auth::user()->profile->banner_path) : '' }}');"></div>
                    <div class="px-4 pb-4 text-center -mt-8 relative z-10">
                        <img class="h-16 w-16 mx-auto rounded-full object-cover border-2 border-white dark:border-gray-800 bg-white" src="{{ Auth::user()->profile?->avatar_path ? asset('storage/'.Auth::user()->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=64&color=7F9CF5&background=EBF4FF' }}" alt="">
                        <a href="{{ route('profile.show', Auth::user()) }}" class="block mt-2 font-bold text-gray-900 dark:text-gray-100 hover:underline hover:text-linkedin-blue">{{ Auth::user()->name }}</a>
                        <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->profile?->headline ?? 'Add a headline' }}</p>
                    </div>
                     <div class="border-t border-gray-100 dark:border-gray-700 py-3">
                        <a href="{{ route('network.index') }}" class="block px-4 py-1 hover:bg-gray-50 dark:hover:bg-gray-700">
                             <div class="flex justify-between items-center text-xs font-semibold text-gray-500">
                                <span>Connections</span>
                                <span class="text-linkedin-blue">{{ Auth::user()->connections()->count() }}</span>
                            </div>
                            <div class="text-xs font-bold text-gray-900 dark:text-gray-100">Grow your network</div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="col-span-1 md:col-span-2 space-y-4">
                
                <!-- Create Post Widget -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <div class="flex space-x-4">
                         <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile?->avatar_path ? asset('storage/'.Auth::user()->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=48&color=7F9CF5&background=EBF4FF' }}" alt="">
                         <div class="flex-1">
                             <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                                 @csrf
                                 <textarea name="content" rows="2" class="block w-full rounded-full border-gray-300 focus:border-gray-400 focus:ring-0 resize-none px-4 py-3 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Start a post"></textarea>
                                 <div class="flex justify-between items-center mt-3">
                                     <div class="flex space-x-2">
                                         <label class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-3 py-2 rounded transition cursor-pointer">
                                             <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"></path></svg>
                                             <span class="font-semibold text-sm text-gray-600 dark:text-gray-400">Media</span>
                                             <input type="file" name="image" class="hidden" accept="image/*">
                                         </label>
                                     </div>
                                     <button type="submit" class="bg-linkedin-blue text-white px-4 py-1.5 rounded-full font-bold hover:bg-linkedin-dark transition disabled:opacity-50">Post</button>
                                 </div>
                             </form>
                         </div>
                    </div>
                </div>

                <!-- Posts Stream -->
                @forelse($posts as $post)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <!-- Post Header -->
                        <div class="p-4 flex justify-between items-start">
                             <div class="flex space-x-3">
                                <a href="{{ route('profile.show', $post->user) }}">
                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $post->user->profile?->avatar_path ? asset('storage/'.$post->user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&size=48&color=7F9CF5&background=EBF4FF' }}" alt="">
                                </a>
                                <div>
                                    <a href="{{ route('profile.show', $post->user) }}" class="block font-semibold text-gray-900 dark:text-gray-100 hover:text-linkedin-blue hover:underline">
                                        {{ $post->user->name }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $post->user->profile?->headline ?? 'Member' }}</p>
                                    <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }} • <span class="font-serif">Global</span></p>
                                </div>
                             </div>
                             <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-20" style="display: none;">
                                    <form action="{{ route('saved-items.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $post->id }}">
                                        <input type="hidden" name="type" value="post">
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            {{ Auth::user()->hasSaved($post) ? 'Unsave' : 'Save' }}
                                        </button>
                                    </form>
                                    @if($post->user_id === Auth::id())
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Delete Post</button>
                                        </form>
                                    @endif
                                </div>
                             </div>
                        </div>

                        <!-- Post Content -->
                        <div class="px-4 pb-2">
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $post->content }}</p>
                        </div>
                        @if($post->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$post->image_path) }}" class="w-full h-auto object-cover max-h-96" alt="Post Image">
                            </div>
                        @endif

                        <!-- Social Counts -->
                         @if($post->likes->count() > 0 || $post->comments->count() > 0)
                            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 flex justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    @if($post->likes->count() > 0)
                                        <div class="flex -space-x-1 mr-2">
                                            <div class="bg-blue-500 rounded-full p-0.5">
                                                 <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"></path></svg>
                                            </div>
                                        </div>
                                        <span class="hover:text-blue-500 hover:underline cursor-pointer">{{ $post->likes->count() }}</span>
                                    @endif
                                </div>
                                <div>
                                    @if($post->comments->count() > 0)
                                        <span class="hover:text-blue-500 hover:underline cursor-pointer">{{ $post->comments->count() }} comments</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Bar -->
                        <div class="px-2 py-1 flex justify-between items-center">
                             <form method="POST" action="{{ route('posts.like', $post) }}" class="flex-1">
                                 @csrf
                                 <button type="submit" class="w-full flex justify-center items-center px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition {{ $post->isLikedBy(Auth::user()) ? 'text-blue-600' : 'text-gray-500' }}">
                                     <svg class="w-6 h-6 mr-2 {{ $post->isLikedBy(Auth::user()) ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                         @if(!$post->isLikedBy(Auth::user()))
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                         @else
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"></path>
                                         @endif
                                     </svg>
                                     <span class="font-semibold text-sm">Like</span>
                                 </button>
                             </form>
                             <button class="flex-1 flex justify-center items-center px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition text-gray-500">
                                 <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                 <span class="font-semibold text-sm">Comment</span>
                             </button>
                        </div>

                        <!-- Comments Section -->
                        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3">
                             <form method="POST" action="{{ route('posts.comment', $post) }}" class="flex items-start space-x-2">
                                 @csrf
                                 <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile?->avatar_path ? asset('storage/'.Auth::user()->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=32&color=7F9CF5&background=EBF4FF' }}" alt="">
                                 <div class="flex-1">
                                     <input type="text" name="content" class="w-full rounded-full border-gray-300 px-4 py-2 text-sm focus:border-gray-400 focus:ring-0 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Add a comment...">
                                 </div>
                             </form>

                             @if($post->comments->count() > 0)
                                <div class="mt-4 space-y-4">
                                    @foreach($post->comments->take(3) as $comment)
                                        <div class="flex space-x-2">
                                            <a href="{{ route('profile.show', $comment->user) }}">
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ $comment->user->profile?->avatar_path ? asset('storage/'.$comment->user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&size=32&color=7F9CF5&background=EBF4FF' }}" alt="">
                                            </a>
                                            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg px-3 py-2 flex-1">
                                                <div class="flex justify-between">
                                                    <a href="{{ route('profile.show', $comment->user) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 hover:underline">
                                                        {{ $comment->user->name }}
                                                    </a>
                                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-xs text-gray-500 mb-1">{{ $comment->user->profile?->headline ?? 'Member' }}</p>
                                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($post->comments->count() > 3)
                                        <button class="text-xs font-semibold text-gray-500 hover:text-blue-600 ml-10">Load more comments</button>
                                    @endif
                                </div>
                             @endif
                        </div>

                    </div>
                @empty
                    <div class="text-center py-10">
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">No posts yet</h3>
                        <p class="text-gray-500">Connect with people to see their updates here!</p>
                         <a href="{{ route('network.index') }}" class="mt-4 inline-block bg-linkedin-blue text-white px-6 py-2 rounded-full font-bold">Find Connections</a>
                    </div>
                @endforelse
                
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>

            </div>

            <!-- Right Sidebar -->
             <div class="col-span-1 hidden md:block space-y-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">LinkedIn News</h3>
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                    </div>
                    <ul class="space-y-4">
                        <li>
                            <a href="#" class="block group">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:underline group-hover:text-blue-600">Tech sector hiring rebounds</span>
                                <span class="block text-xs text-gray-500">2d ago • 10,934 readers</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block group">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:underline group-hover:text-blue-600">New skills for 2026</span>
                                <span class="block text-xs text-gray-500">19h ago • 5,211 readers</span>
                            </a>
                        </li>
                         <li>
                            <a href="#" class="block group">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:underline group-hover:text-blue-600">Remote work updates</span>
                                <span class="block text-xs text-gray-500">1d ago • 8,102 readers</span>
                            </a>
                        </li>
                    </ul>
                     <button class="mt-4 flex items-center text-sm font-semibold text-gray-500 hover:bg-gray-100 px-2 py-1 rounded transition">
                        Show more
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
