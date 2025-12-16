<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Main Content: Job Details -->
            <div class="col-span-1 md:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden p-8">
                    <div class="mb-6">
                         <div class="bg-gray-200 dark:bg-gray-600 h-24 w-24 rounded flex items-center justify-center text-3xl font-bold text-gray-500 mb-4">
                            {{ substr($job->company, 0, 1) }}
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $job->title }}</h1>
                        <div class="text-gray-500 mb-4">
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $job->company }}</span> · 
                            <span>{{ $job->location }}</span> · 
                            <span class="text-green-600 font-semibold">{{ $job->created_at->diffForHumans() }}</span> ·
                            <span>{{ $job->type }}</span>
                        </div>
                        <div class="flex space-x-3">
                            <button class="bg-linkedin-blue text-white px-6 py-2 rounded-full font-bold hover:bg-linkedin-dark transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Apply Now
                            </button>
                            <button class="border border-linkedin-blue text-linkedin-blue px-6 py-2 rounded-full font-bold hover:bg-blue-50 transition">
                                Save
                            </button>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700 my-8">

                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">About the job</h2>
                        <div class="prose dark:prose-invert max-w-none whitespace-pre-line text-gray-700 dark:text-gray-300">
                            {{ $job->description }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Company Info / More Jobs -->
            <div class="col-span-1 space-y-4">
                 <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden p-4">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">About the company</h3>
                    <p class="text-sm text-gray-500 mb-4">This company has not provided a description yet.</p>
                     <a href="#" class="text-linkedin-blue font-bold text-sm hover:underline">Show more jobs from {{ $job->company }}</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
