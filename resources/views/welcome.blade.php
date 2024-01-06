<x-app-layout>
    <div class="flex flex-col justify-center w-full gap-10 overflow-hidden bg-white dark:bg-gray-900">
        <div class="py-5 px-[10%] flex justify-between gap-2">
            <div class="">
                @forelse ($blogs as $blog)
                    <div class="flex ">
                        <div class="p-4 mb-4 text-white bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold">{{ $blog->blog_title }}</h3>
                                @php
                                    $time = $blog->created_at->diffForHumans();
                                @endphp
                                <span class="flex items-center gap-5">-&nbsp;
                                    {{ $time }}


                                    <div class="border border-white rounded-full w-[47px] h-[47px] overflow-hidden">
                                        <img src="/profile_img/{{ $blog->user->profile_img ?: 'profile.png' }}"
                                            alt="profile_image" class="w-full rounded-full" id="profile_image_preview2">
                                    </div>
                                </span>
                            </div>
                            <div class="py-2 overflow-hidden shadow rounded-[10px] h-[200px]">
                                <img src="/blog_images/{{ $blog->cover_img }}" alt="blog_images">
                            </div>
                            <div class="py-2 h-[200px] overflow-hidden relative">
                                <p class="text-justify">{{ $blog->blog_description }}</p>
                                <div class="absolute top-0 flex items-end justify-end w-full h-full">
                                    <span
                                        class="text-white bg-transparent blur-sm">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;</span>
                                </div>
                            </div>
                            <a href="/blog/full/{{ $blog->blog_uid }}">
                                <h5 class="pt-2 font-bold text-center capitalize">read full blog</h5>
                                <div class="flex items-center justify-center w-full">
                                    <i class="text-4xl font-bold fa fa-angle-down"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-white">No Blogs Added</div>
                @endforelse
            </div>

            <div class="py-5 text-white bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg h-fit">
                <h3 class="text-black dark:text-white">Our popular blogs</h3>

                <div class="w-full">
                    @forelse ($populars as $blog)
                        <a href="/blog/full/{{ $blog->blog_uid }}">
                            <div
                                class="flex items-center w-full py-2 border-b-2 dark:border-b-gray-600 border-b-gray-300">
                                <img src="/blog_images/{{ $blog->cover_img }}" alt="blog_image"
                                    class="rounded-xl w-[50px] h-[50px]">

                                <div class="w-[200px] overflow-hidden">
                                    <h4 class="px-2 w-[200px]">{{ $blog->blog_title }}</h4>
                                    <h5 class="text-end">-&nbsp;{{ $blog->user->name }}</h5>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="w-[200px] overflow-hidden">
                            <h4 class="w-[200px] text-center py-5">No popular blogs</h4>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
