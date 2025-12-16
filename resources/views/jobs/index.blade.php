<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar: My Jobs & Filters -->
            <div class="col-span-1 space-y-4">
                                Practice Interview
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content: Job Search & List -->
            <div class="col-span-1 md:col-span-3 space-y-6">
                
                <!-- Search Box -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <form action="{{ route('jobs.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                        <div class="flex-1">
                            <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search by title, skill, or company</label>
                            <input type="text" name="q" id="q" value="{{ request('q') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-linkedin-blue focus:ring-linkedin-blue dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Software Engineer">
                        </div>
                        <div class="flex-1">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City, state, or zip code</label>
                            <input type="text" name="location" id="location" value="{{ request('location') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-linkedin-blue focus:ring-linkedin-blue dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Dhaka">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto bg-linkedin-blue text-white px-6 py-2.5 rounded-full font-bold hover:bg-linkedin-dark transition">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Job Listings -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="font-bold text-xl text-gray-900 dark:text-gray-100">Recommended for you</h2>
                        <p class="text-sm text-gray-500">Based on your profile and search history</p>
                    </div>

                    @forelse($jobs as $job)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition group relative">
                            <div class="flex items-start">
                                <div class="bg-gray-200 dark:bg-gray-600 h-16 w-16 rounded flex items-center justify-center text-xl font-bold text-gray-500">
                                    {{ substr($job->company, 0, 1) }}
                                </div>
                                <div class="ml-4 flex-1">
                                    <a href="{{ route('jobs.show', $job) }}" class="block text-lg font-bold text-linkedin-blue hover:underline">
                                        {{ $job->title }}
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $job->company }}</p>
                                    <p class="text-sm text-gray-500">{{ $job->location }} ({{ $job->type }})</p>
                                    
                                    <div class="mt-2 flex items-center text-xs text-gray-400">
                                        @if($job->created_at->diffInDays() < 3)
                                            <span class="text-green-600 font-bold mr-2">New</span>
                                        @endif
                                        <span>{{ $job->created_at->diffForHumans() }}</span>
                                        <span class="mx-1">•</span>
                                        <span>Apply properly with your Resume</span>
                                    </div>
                                    
                                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ $job->description }}
                                    </div>
                                </div>
                                <div class="hidden group-hover:block z-10">
                                     <button class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-gray-500">No jobs found matching your criteria.</p>
                            @if(request('q') || request('location'))
                                <a href="{{ route('jobs.index') }}" class="text-linkedin-blue font-bold hover:underline mt-2 inline-block">Clear Filters</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                 <div class="mt-4">
                    {{ $jobs->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
