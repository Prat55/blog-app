<x-app-layout>
    <div class="flex flex-col justify-center w-full gap-10 overflow-hidden bg-white dark:bg-gray-900">
        <div class="py-5 md:px-[10%] flex md:justify-between gap-2 flex-col-reverse lg:flex-row px-4">
            <div class="w-[70%]">
                @forelse ($blogs as $blog)
                    <div class="flex">
                        <div
                            class="px-2 py-4 mb-4 text-white bg-white rounded-lg shadow sm:px-3 sm:py-5 dark:bg-gray-800">
                            <div class="flex items-center justify-end">
                                @php
                                    $time = $blog->created_at->diffForHumans();
                                @endphp
                                <span class="flex items-center gap-5">-&nbsp;
                                    {{ $time }}

                                    <div class="border border-white rounded-full w-[47px] h-[47px] overflow-hidden">
                                        @if (!empty($blog->user->profile_img))
                                            <img src="/profile_img/{{ $blog->user->profile_img ?: 'profile.png' }}"
                                                alt="profile_image" class="w-full rounded-full"
                                                id="profile_image_preview2">
                                        @elseif (!empty($blog->user2->profile_img) && empty($blog->user->profile_img))
                                            <img src="/profile_img/{{ $blog->user2->profile_img ?: 'profile.png' }}"
                                                alt="profile_image" class="w-full rounded-full"
                                                id="profile_image_preview2">
                                        @else
                                            <img src="/profile_img/profile.png" alt="profile_image"
                                                class="w-full rounded-full" id="profile_image_preview2">
                                        @endif
                                    </div>
                                </span>
                            </div>

                            <div class="w-full px-8 py-2 mt-2 rounded-xl">
                                <div
                                    class="overflow-hidden shadow rounded-[10px] h-[300px] flex justify-center items-center w-full object-cover">
                                    <img src="/blog_images/{{ $blog->cover_img }}" alt="blog_images"
                                        class="rounded-[15px]">
                                </div>
                            </div>

                            <div class="py-5">
                                <div class="text-center">
                                    <h3 class="text-2xl font-bold">{{ $blog->blog_title }}</h3>
                                </div>
                            </div>

                            <div class="py-2 px-5 h-[100px] overflow-hidden relative">
                                <p class="text-justify">{{ $blog->blog_description }}</p>
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

            <div
                class="p-4 py-5 text-white bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 h-fit w-[30%] overflow-hidden">
                <h3 class="text-xl font-bold text-black dark:text-white">Our popular blogs</h3>

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
                        <div class="w-full overflow-hidden">
                            <h4 class="w-full py-5 text-center">No popular blogs</h4>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
