<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Applicants</h2>
                        <p class="text-gray-500">for {{ $job->title }} at {{ $job->company }}</p>
                    </div>
                    <a href="{{ route('jobs.show', $job) }}" class="text-linkedin-blue font-bold hover:underline">Back to Job</a>
                </div>
                
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($job->applications as $application)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center space-x-4">
                            <a href="{{ route('profile.show', $application->user) }}">
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ $application->user->profile?->avatar_path ? asset('storage/'.$application->user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="{{ route('profile.show', $application->user) }}" class="block text-gray-900 dark:text-gray-100 font-bold hover:text-linkedin-blue hover:underline">
                                    {{ $application->user->name }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $application->user->profile?->headline ?? 'No headline' }}</p>
                                <p class="text-xs text-gray-400 mt-1">Applied {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <a href="{{ route('messaging.store') }}" onclick="event.preventDefault(); document.getElementById('msg-form-{{ $application->user->id }}').submit();" class="border border-linkedin-blue text-linkedin-blue px-4 py-1.5 rounded-full font-bold hover:bg-blue-50 transition text-sm">
                                    Message
                                </a>
                                <form id="msg-form-{{ $application->user->id }}" action="{{ route('messaging.store') }}" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $application->user->id }}">
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            No applicants yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
