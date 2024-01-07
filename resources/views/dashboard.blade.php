<x-app-layout>
    <div class="py-12">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="relative p-6 text-gray-900 dark:text-gray-100">
                    <div class="absolute text-green-600 right-[20px] top-7">
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

                                {{-- ?Blog Title --}}
                                <label for="blog_title"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Blog Title
                                </label>
                                <x-text-input id="blog_title" name="blog_title" type="text" class="block w-full"
                                    placeholder="{{ __('Enter the title of blog') }}" value="{{ old('blog_title') }}" />
                                <x-input-error :messages="$errors->get('blog_title')" class="mt-2" />

                                {{-- ?Blog Description --}}
                                <label for="blog_description"
                                    class="block mt-5 mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Blog Description
                                </label>
                                <textarea name="blog_description" id="blog_description" cols="30" rows="10"
                                    class="block w-full p-3 mt-1 mb-5 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                    placeholder="{{ __(' Write your thoughts here') }}" value="{{ old('blog_description') }}"></textarea>
                                <x-input-error :messages="$errors->get('blog_description')" class="mt-2" />

                                {{-- ?Blog Cover Image --}}
                                <label for="coverimg"
                                    class="block mt-4 mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
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

            {{-- ?Blogs --}}
            <div class="w-full mt-[50px] flex md:gap-8 gap-4 flex-wrap md:justify-start justify-center">
                @forelse ($blogs as $blog)
                    <div
                        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#" class="">
                            <img class="object-cover rounded-t-lg h-[188px] w-full"
                                src="/blog_images/{{ $blog->cover_img }}" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $blog->blog_title }}</h5>
                            </a>

                            <p
                                class="overflow-hidden font-normal text-gray-700 dark:text-gray-400 w-[100%] text-ellipsis whitespace-nowrap p-[10px]">
                                {{ $blog->blog_description }}
                            </p>

                            @php
                                $time = $blog->created_at->diffForHumans();
                            @endphp
                            <h6 class="mb-2 text-white text-end">-&nbsp;{{ $time }}</h6>

                            <a href="/blog/full/{{ $blog->blog_uid }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>

                            <button data-modal-target="delete-blog" data-modal-toggle="delete-blog"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                type="button">
                                Delete &nbsp;
                                <i class="fa fa-trash"></i>
                            </button>


                        </div>
                    </div>

                    {{-- ? <!--Blog Delete modal --> --}}
                    <div id="delete-blog" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-2xl max-h-full p-4">
                            {{-- ! <!-- Modal content --> --}}
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                {{-- ? <!-- Modal body --> --}}
                                <div class="p-4 space-y-4 md:p-5">
                                    <form method="post" action="/blog/delete/{{ $blog->blog_uid }}" class="p-6">
                                        @csrf
                                        @method('delete')

                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Are you sure you want to delete your blog?') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Once your blog is deleted, all of its resources and data will be permanently deleted.') }}
                                        </p>

                                        <div class="flex justify-center mt-6">
                                            <button data-modal-hide="delete-blog" type="button"
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                                Cancel
                                            </button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Blog') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="overflow-hidden text-white sm:rounded-lg">
                        Write your first blog...
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
