<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

            <!-- Sidebar Filters / Types -->
            <div class="w-full md:w-1/4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="font-bold text-gray-900 dark:text-gray-100">Search Results</h2>
                    </div>
                    <div class="flex flex-col text-sm text-gray-600 dark:text-gray-400">
                         <a href="{{ route('search.index', ['q' => $query, 'type' => 'people']) }}" class="px-4 py-3 {{ $type === 'people' ? 'border-l-4 border-linkedin-blue bg-blue-50 dark:bg-gray-700 text-linkedin-blue font-bold' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                             People
                         </a>
                         <a href="{{ route('search.index', ['q' => $query, 'type' => 'jobs']) }}" class="px-4 py-3 {{ $type === 'jobs' ? 'border-l-4 border-linkedin-blue bg-blue-50 dark:bg-gray-700 text-linkedin-blue font-bold' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                             Jobs
                         </a>
                         <a href="{{ route('search.index', ['q' => $query, 'type' => 'posts']) }}" class="px-4 py-3 {{ $type === 'posts' ? 'border-l-4 border-linkedin-blue bg-blue-50 dark:bg-gray-700 text-linkedin-blue font-bold' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                             Posts
                         </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Results -->
            <div class="w-full md:w-3/4">
                 @if($type === 'people')
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">People</h3>
                        @forelse($users as $user)
                             <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-start space-x-4">
                                <a href="{{ route('profile.show', $user) }}">
                                    <img class="h-16 w-16 rounded-full object-cover" src="{{ $user->profile?->avatar_path ? asset('storage/'.$user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                                </a>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('profile.show', $user) }}" class="text-lg font-bold text-gray-900 dark:text-gray-100 hover:text-linkedin-blue hover:underline">
                                                {{ $user->name }}
                                            </a>
                                            <p class="text-gray-500">{{ $user->profile?->headline ?? 'Member' }}</p>
                                            <p class="text-sm text-gray-400">{{ $user->profile?->location ?? 'Bangladesh' }}</p>
                                        </div>
                                        @if(Auth::id() !== $user->id)
                                             @if(Auth::user()->isConnectedWith($user))
                                                <button class="border border-linkedin-blue text-linkedin-blue px-4 py-1 rounded-full font-bold hover:bg-blue-50 transition">Message</button>
                                             @elseif(Auth::user()->hasSentRequestTo($user))
                                                <button disabled class="bg-gray-300 text-white px-4 py-1 rounded-full font-bold cursor-default">Pending</button>
                                             @else
                                                <form action="{{ route('connection.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                                    <button type="submit" class="border border-linkedin-blue text-linkedin-blue px-4 py-1 rounded-full font-bold hover:bg-blue-50 transition">Connect</button>
                                                </form>
                                             @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No people found searching for "{{ $query }}".</p>
                        @endforelse
                    </div>

                 @elseif($type === 'jobs')
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Jobs</h3>
                        @forelse($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-start space-x-4 hover:shadow-md transition">
                                <div class="bg-gray-200 dark:bg-gray-600 h-16 w-16 rounded flex items-center justify-center font-bold text-gray-500 text-xl">
                                    {{ substr($job->company, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <a href="{{ route('jobs.show', $job) }}" class="text-lg font-bold text-linkedin-blue hover:underline">
                                        {{ $job->title }}
                                    </a>
                                    <p class="text-gray-900 dark:text-gray-100 font-semibold">{{ $job->company }}</p>
                                    <p class="text-gray-500 text-sm">{{ $job->location }} ({{ $job->type }})</p>
                                    <p class="text-gray-400 text-xs mt-2">{{ $job->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                             <p class="text-gray-500">No jobs found searching for "{{ $query }}".</p>
                        @endforelse
                    </div>

                 @elseif($type === 'posts')
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Posts</h3>
                        @forelse($posts as $post)
                             <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                                <div class="flex space-x-3 mb-2">
                                     <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->profile?->avatar_path ? asset('storage/'.$post->user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                                     <div>
                                         <a href="{{ route('profile.show', $post->user) }}" class="font-bold text-gray-900 dark:text-gray-100 hover:text-linkedin-blue">{{ $post->user->name }}</a>
                                         <p class="text-xs text-gray-500">{{ $post->user->profile?->headline }}</p>
                                     </div>
                                </div>
                                <p class="text-gray-800 dark:text-gray-200 text-sm whitespace-pre-line">{{ Str::limit($post->content, 300) }}</p>
                             </div>
                        @empty
                             <p class="text-gray-500">No posts found searching for "{{ $query }}".</p>
                        @endforelse
                    </div>
                 @endif

            </div>
        </div>
    </div>
</x-app-layout>
