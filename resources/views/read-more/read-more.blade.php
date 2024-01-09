<x-app-layout>
    <div class="px-2 py-5 md:px-0">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="/blog/update/{{ $blog->blog_uid }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="relative p-3 text-gray-900 md:p-6 dark:text-gray-100">
                        <div class="box-border flex items-center justify-between">
                            <div>
                                <h2 class="font-semibold text-gray-600 text-md md:text-2xl dark:text-white"
                                    id="blog_old_title">
                                    {{ $blog->blog_title }}
                                </h2>

                                <x-text-input name="blog_new_title" id="blog_new_title" value="{{ $blog->blog_title }}"
                                    class="hidden p-2" />

                                @error('blog_new_title')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($blog->userID === Auth::user()->userID || Auth::user()->role === 'admin')
                                <div class="flex items-center justify-end">
                                    <x-secondary-button id="edit-blog">Edit Blog</x-secondary-button>
                                    <div class="flex flex-col hidden gap-1" id="action-buttons">
                                        <x-primary-button>Confirm</x-primary-button>

                                        <x-danger-button type="button" class="mt-2 sm:mt-0"
                                            id="cancel-edit">Cancel</x-danger-button>
                                    </div>
                                </div>
                            @else
                                <span class="flex items-center gap-5">
                                    <p class="font-bold text-gray-600 dark:text-white">
                                        -{{ $blog->user->name }}</p>

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
                            @endif
                        </div>

                        <div class="relative object-cover w-full mt-3 overflow-hidden rounded-lg">
                            <img src="/blog_images/{{ $blog->cover_img }}" alt="blog_image" id="blog_img_preview">

                            <div class="absolute top-0 flex items-center justify-center hidden w-full h-full"
                                id="blog_camera">
                                <i class="cursor-pointer fa fa-camera" id="blog_image"
                                    style="color: rgba(255, 255, 255, 0.824); font-size: 2.4rem"
                                    title="change blog cover image"></i>

                                <input type="file" name="blog_cover_img" id="blog_cover_img" class="hidden">
                            </div>
                        </div>
                        @error('blog_cover_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <div class="p-5 mt-3 bg-gray-400 rounded-md dark:bg-gray-700">
                            <p class="text-justify text-black dark:text-white" id="description-readonly">
                                {{ $blog->blog_description }}
                            </p>

                            <textarea name="description" id="description" cols="30" rows="10"
                                class="hidden w-full p-2 mt-1 mb-5 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                {{ $blog->blog_description }}
                            </textarea>
                        </div>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-5">
        <h4 class="mb-5 text-2xl font-bold text-center text-black dark:text-white">Comments</h4>

        <div class="flex items-center justify-center w-full py-5">
            <div class="md:px-12 md:w-[70%] w-[80%] relative px-5">
                <input type="text" name="comment" id="comment"
                    class="bg-white border border-t-0 border-b-2 border-l-0 border-r-0 outline-none sm:w-full w-[92%] dark:bg-transparent border-b-blue-500 focus:outline-none dark:text-white text-black"
                    placeholder="Type your comment here&nbsp;.&nbsp;.&nbsp;.&nbsp;.">

                <input type="hidden" name="blog-id" id="blog-id" value="{{ $blog->blog_uid }}">

                <span
                    class="absolute top-0 right-0 flex items-center justify-center w-[50px] h-full p-2 bg-blue-500 rounded-sm cursor-pointer"
                    id="send-comment">
                    <i class="fa fa-share" style="color: #fff"></i>
                </span>
                <div class="overflow-hidden absolute top-0 right-0 flex items-center justify-center w-[50px] h-full p-2 bg-blue-500 rounded-sm cursor-pointer hidden"
                    id="sending-animation">
                    <i class="fa fa-paper-plane sended" style="color: #fff;"></i>
                </div>
            </div>

        </div>
        <div class="flex items-center justify-center w-full pb-5">
            <div class="px-12 w-[70%] relative">
                <ul id="error-list" class="text-red-500">

                </ul>
            </div>
        </div>

        @if ($comments->count() > 0)
            <div class="flex items-center justify-center w-full pb-5 text-black dark:text-white">
                Total comments:&nbsp;{{ $comments->count() }}
            </div>
        @endif

        <div class="w-full px-2 md:flex md:flex-col sm:justify-center sm:items-center md:px-0">
            @forelse ($comments as $comment)
                <figure
                    class="mb-2 bg-white shadow-lg md:w-1/2 rounded-2xl ring-1 ring-gray-900/5 sm:col-span-2 xl:col-start-2 xl:row-end-1 dark:bg-gray-700 dark:text-white">

                    <blockquote
                        class="flex items-end gap-2 p-6 overflow-hidden text-lg font-semibold leading-7 tracking-tight text-gray-900 sm:p-5 sm:text-xl sm:leading-8 dark:text-white">
                        <p class="overflow-hidden">
                            {{ $comment->comment }}
                        </p>
                    </blockquote>
                    <figcaption class="flex flex-wrap items-center px-6 py-4 gap-x-4 gap-y-4 sm:flex-nowrap">
                        @if (!empty($comment->user->profile_img))
                            <img class="flex-none w-10 h-10 rounded-full bg-gray-50"
                                src="/profile_img/{{ $comment->user->profile_img }}" alt="user">
                        @elseif (empty($comment->user->profile_img) && !empty($comment->user2->profile_img))
                            <img class="flex-none w-10 h-10 rounded-full bg-gray-50"
                                src="/profile_img/{{ $comment->user2->profile_img }}" alt="user">
                        @else
                            <img class="flex-none w-10 h-10 rounded-full" src="/profile_img/profile.png"
                                alt="user">
                        @endif

                        <div class="flex-auto">
                            <div class="font-semibold">
                                @if (!empty($comment->user->name))
                                    {{ $comment->user->name }}
                                @else
                                    {{ $comment->user2->name }}
                                @endif
                            </div>

                        </div>
                        <div class="flex items-center justify-end w-full gap-3 sm:w-auto">
                            @if (Auth::check() || Auth::user()->role === 'admin')
                                @if ($comment->userID == Auth::user()->userID)
                                    <div>
                                        <form action="/comment/remove/{{ $comment->comment_uid }}" method="post">
                                            @csrf
                                            <x-danger-button type="submit" id="remove-comment">
                                                Remove&nbsp;<i class="fa fa-message"></i>
                                            </x-danger-button>
                                        </form>
                                    </div>
                                @endif
                            @endif

                            @php
                                $time = $comment->created_at->diffForHumans();
                            @endphp
                            <span class="text-end">-&nbsp;{{ $time }}</span>
                        </div>
                    </figcaption>
                </figure>
            @empty
                <div>
                    <h4 class="text-black dark:text-white">No comments.</h4>
                </div>
            @endforelse

        </div>
    </div>

</x-app-layout>

<script>
    $('#edit-blog').click(function() {
        // adding classes
        $(this).addClass('hidden');
        $('#description-readonly').addClass('hidden');
        $('#blog_old_title').addClass('hidden');

        // removing classes
        $('#action-buttons').removeClass('hidden');
        $('#blog_new_title').removeClass('hidden');
        $('#blog_camera').removeClass('hidden');
        $('#description').removeClass('hidden');
    });

    $('#cancel-edit').click(function() {
        // adding classes
        $('#action-buttons').addClass('hidden');
        $('#blog_camera').addClass('hidden');
        $('#blog_new_title').addClass('hidden');
        $('#description').addClass('hidden');

        // removing classes
        $('#description-readonly').removeClass('hidden');
        $('#edit-blog').removeClass('hidden');
        $('#blog_old_title').removeClass('hidden');
    });

    $('#blog_image').click(function() {
        $('#blog_cover_img').click();
    });

    // use to preview image
    $('#blog_cover_img').change(function(e) {
        let reader = new FileReader();

        reader.onload = (e) => {

            $('#blog_img_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
    });

    $('#send-comment').click(function() {
        let blogID = $('#blog-id').val();
        let comment = $('#comment').val();

        $(this).addClass('hidden');
        $('#sending-animation').removeClass('hidden');

        $.ajax({
            type: "post",
            url: "/blog/comment",
            data: {
                blogID,
                comment
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 404) {
                    $('#error-list').html("");
                    $('#error-list').addClass('text-danger');
                    $.each(response.errors, function(key, err_values) {
                        $('#error-list').append('<li>' + err_values +
                            '</li>');
                    });
                    $('#send-comment').removeClass('hidden');
                    $('#sending-animation').addClass('hidden');
                } else {
                    $('#send-comment').removeClass('hidden');
                    $('#sending-animation').addClass('hidden');
                    $('#comment').val('');
                    location.reload()
                }
            }
        });
    });

    $('#show-more').click(function() {
        $(this).addClass('hidden');
        $('#show-less').removeClass('hidden');
        $('.show-comment').addClass('h-auto');
    });

    $('#show-less').click(function() {
        $(this).addClass('hidden');
        $('#show-more').removeClass('hidden');
        $('.show-comment').removeClass('h-auto');
    });
</script>
