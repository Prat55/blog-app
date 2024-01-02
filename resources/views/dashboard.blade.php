<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="relative p-6 text-gray-900 dark:text-gray-100">
                    <div class="absolute text-green-600" style="right: 40px; top: 38px">
                        @include('message')
                    </div>

                    <p class="font-serif text-white bold">You want to share something&nbsp;.&nbsp;.&nbsp;.</p>
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'whats-new')">{{ __('New Blog') }}
                    </x-primary-button>

                    <x-modal name="whats-new" id="whats-new" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('blog.add') }}" class="p-6"
                            enctype="multipart/form-data">
                            @csrf

                            <h2 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100">
                                New Blog
                            </h2>

                            <div class="mt-6">
                                <label for="blog_description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Blog Description
                                </label>

                                <textarea name="blog_description" id="blog_description" cols="30" rows="10"
                                    class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                    placeholder="{{ __('Write your thoughts here') }}"></textarea>
                                <x-input-error :messages="$errors->get('blog_description')" class="mt-2" />

                                <label for="coverimg"
                                    class="block mt-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Cover Image
                                </label>
                                <x-text-input id="coverimg" name="coverimg" type="file" class="block w-full" />

                                <x-input-error :messages="$errors->get('coverimg')" class="mt-2" />
                            </div>

                            <div class="flex justify-end mt-6">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-primary-button class="ms-3">
                                    {{ __('Add Blog') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
