<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                         <h2 class="font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                            My Items
                        </h2>
                    </div>
                    <ul class="text-sm">
                        <li>
                            <a href="#" class="block px-4 py-3 border-l-4 border-linkedin-blue bg-blue-50 dark:bg-gray-700 text-linkedin-blue font-semibold">
                                Saved Items ({{ $savedPosts->count() + $savedJobs->count() }})
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 space-y-6">
                
                <!-- Saved Posts -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100">Saved Posts</h3>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($savedPosts as $post)
                            <div class="p-4">
                                <div class="flex space-x-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->profile?->avatar_path ? asset('storage/'.$post->user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <a href="{{ route('profile.show', $post->user) }}" class="font-bold text-gray-900 dark:text-gray-100 hover:text-linkedin-blue">{{ $post->user->name }}</a>
                                                <p class="text-xs text-gray-500">{{ $post->user->profile?->headline }}</p>
                                                <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                            
                                            <!-- Unsave Button -->
                                            <form action="{{ route('saved-items.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $post->id }}">
                                                <input type="hidden" name="type" value="post">
                                                <button type="submit" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-gray-800 dark:text-gray-200 mt-2">{{ $post->content }}</p>
                                        @if($post->image_path)
                                            <img src="{{ asset('storage/'.$post->image_path) }}" alt="Post Image" class="mt-3 rounded-lg w-full object-cover max-h-96">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                No saved posts.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Saved Jobs -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100">Saved Jobs</h3>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($savedJobs as $job)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-gray-200 dark:bg-gray-600 h-12 w-12 rounded flex items-center justify-center font-bold text-gray-500">
                                        {{ substr($job->company, 0, 1) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('jobs.show', $job) }}" class="block font-bold text-linkedin-blue hover:underline text-lg">{{ $job->title }}</a>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $job->company }}</p>
                                        <p class="text-sm text-gray-500">{{ $job->location }} ({{ $job->type }})</p>
                                    </div>
                                </div>
                                <form action="{{ route('saved-items.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $job->id }}">
                                    <input type="hidden" name="type" value="job">
                                    <button type="submit" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                No saved jobs.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
