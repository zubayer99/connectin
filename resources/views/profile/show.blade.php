<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Hero Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg relative">
                <!-- Banner -->
                <div class="h-48 w-full bg-cover bg-center bg-gray-300 relative" style="background-image: url('{{ $user->profile?->banner_path ? asset('storage/'.$user->profile->banner_path) : 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80' }}');">
                </div>
                
                <div class="px-6 pb-6">
                    <div class="relative flex justify-between items-end -mt-12 mb-4">
                        <img class="h-40 w-40 rounded-full ring-4 ring-white dark:ring-gray-800 object-cover bg-white" src="{{ $user->profile?->avatar_path ? asset('storage/'.$user->profile->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=160&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}">
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit_details') }}" class="mb-4">
                                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                        {{ $user->name }} 
                        @if($user->profile?->verified) 
                            <svg class="w-5 h-5 ml-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        @endif
                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mt-1">{{ $user->profile?->headline ?? 'Dev at Connectin' }}</p>
                    
                    <div class="text-sm text-gray-500 mt-2 flex items-center">
                        <span>{{ $user->profile?->location ?? 'Bangladesh' }}</span>
                        <span class="mx-2">•</span>
                        <a href="#" class="text-linkedin-blue font-bold hover:underline">Contact info</a>
                    </div>
                
                    <div class="mt-4 flex space-x-3">
                        @if(Auth::id() !== $user->id)
                            <button class="bg-linkedin-blue text-white px-4 py-1.5 rounded-full font-bold hover:bg-linkedin-dark transition">Connect</button>
                            <button class="border border-gray-500 text-gray-600 dark:text-gray-400 px-4 py-1.5 rounded-full font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition">Message</button>
                        @else
                            <button class="bg-linkedin-blue text-white px-4 py-1.5 rounded-full font-bold hover:bg-linkedin-dark transition">Open to</button>
                            <a href="{{ route('profile.edit_details') }}" class="border border-linkedin-blue text-linkedin-blue px-4 py-1.5 rounded-full font-bold hover:bg-blue-50 transition inline-block">Add profile section</a>
                        @endif
                        <button class="border border-gray-500 text-gray-600 dark:text-gray-400 px-3 py-1.5 rounded-full font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition">More</button>
                    </div>
                </div>
            </div>

            <!-- About Section -->
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">About</h2>
                    @if(Auth::id() === $user->id)
                        <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    @endif
                </div>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line text-sm leading-relaxed">
                    {{ $user->profile?->about ?? 'No about section yet.' }}
                </p>
            </div>

            <!-- Experience Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                 <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Experience</h2>
                     @if(Auth::id() === $user->id)
                        <div class="flex space-x-2">
                             <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-6">
                    @forelse($user->experiences as $experience)
                        <div class="flex">
                            <img class="h-12 w-12 rounded bg-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($experience->company) }}&size=48&color=7F9CF5&background=EBF4FF" alt="">
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $experience->title }}</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $experience->company }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $experience->start_date->format('M Y') }} - {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Present' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $experience->location }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $experience->description }}</p>
                            </div>
                        </div>
                        @if(!$loop->last) <hr class="border-gray-100 dark:border-gray-700"> @endif
                    @empty
                        <p class="text-gray-500 text-sm">No experience added yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Education Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                 <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Education</h2>
                     @if(Auth::id() === $user->id)
                        <div class="flex space-x-2">
                             <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                    @endif
                </div>

                 <div class="space-y-6">
                    @forelse($user->education as $education)
                        <div class="flex">
                            <img class="h-12 w-12 rounded bg-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($education->school) }}&size=48&color=7F9CF5&background=EBF4FF" alt="">
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $education->school }}</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $education->degree }}, {{ $education->field_of_study }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $education->start_date->format('M Y') }} - {{ $education->end_date ? $education->end_date->format('M Y') : 'Present' }}</p>
                            </div>
                        </div>
                         @if(!$loop->last) <hr class="border-gray-100 dark:border-gray-700"> @endif
                    @empty
                        <p class="text-gray-500 text-sm">No education added yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
