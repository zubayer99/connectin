<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Post a Job</h2>
                    <p class="text-gray-500">Find the right candidate for your open role.</p>
                </div>
                
                <form method="POST" action="{{ route('jobs.store') }}" class="p-6 space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="title" :value="__('Job Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus placeholder="e.g. Senior Software Engineer" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="company" :value="__('Company')" />
                        <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company')" required placeholder="e.g. Acme Corp" />
                        <x-input-error class="mt-2" :messages="$errors->get('company')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required placeholder="e.g. Dhaka, Bangladesh (or Remote)" />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Job Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Temporary">Temporary</option>
                                <option value="Internship">Internship</option>
                                <option value="Remote">Remote</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Job Description')" />
                        <textarea id="description" name="description" rows="10" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Describe the role, responsibilities, and requirements...">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" class="bg-linkedin-blue text-white px-6 py-2 rounded-full font-bold hover:bg-linkedin-dark transition">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
