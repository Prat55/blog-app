<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="relative p-6 text-gray-900 dark:text-gray-100">
                    <div class="box-border flex justify-between">
                        <h2 class="text-2xl font-semibold text-gray-600 dark:text-white">{{ $blog->blog_title ?: '' }}
                        </h2>

                        <p class="font-bold text-gray-600 dark:text-white">-{{ $blog->user->name }}</p>
                    </div>
                    <div class="object-cover w-full mt-3 overflow-hidden rounded-lg max-h-[400px]">
                        <img src="/blog_images/{{ $blog->cover_img }}" alt="blog_image" class="">
                    </div>
                    <div class="p-5 mt-3 bg-gray-400 rounded-md dark:bg-gray-700">
                        {{ $blog->blog_description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
