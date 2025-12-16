<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profile Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Basic Info -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Basic Info</h3>
                    <form method="post" action="{{ route('profile.update_details') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Banner Upload -->
                        <div>
                            <x-input-label for="banner" :value="__('Banner Image')" />
                            <input id="banner" name="banner" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('banner')" />
                        </div>

                        <!-- Avatar Upload -->
                        <div>
                            <x-input-label for="avatar" :value="__('Profile Picture')" />
                            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>
                        
                        <div>
                            <x-input-label for="headline" :value="__('Headline')" />
                            <x-text-input id="headline" name="headline" type="text" class="mt-1 block w-full" :value="old('headline', $user->profile?->headline)" required autofocus autocomplete="headline" />
                            <x-input-error class="mt-2" :messages="$errors->get('headline')" />
                        </div>

                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->profile?->location)" autocomplete="location" />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                         <div>
                            <x-input-label for="about" :value="__('About')" />
                            <textarea id="about" name="about" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('about', $user->profile?->about) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('about')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Experience (Simplified) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add Experience</h3>
                     <form method="post" action="{{ route('profile.update_details') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="new_experience_title" :value="__('Title')" />
                            <x-text-input id="new_experience_title" name="new_experience_title" type="text" class="mt-1 block w-full" />
                        </div>
                         <div>
                            <x-input-label for="new_experience_company" :value="__('Company')" />
                            <x-text-input id="new_experience_company" name="new_experience_company" type="text" class="mt-1 block w-full" />
                        </div>
                         <div>
                            <x-input-label for="new_experience_start_date" :value="__('Start Date')" />
                            <x-text-input id="new_experience_start_date" name="new_experience_start_date" type="date" class="mt-1 block w-full" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Add Experience') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
