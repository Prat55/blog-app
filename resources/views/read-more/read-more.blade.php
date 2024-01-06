<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="/blog/update/{{ $blog->blog_uid }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="relative p-6 text-gray-900 dark:text-gray-100">
                        <div class="box-border flex justify-between">
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-600 dark:text-white" id="blog_old_title">
                                    {{ $blog->blog_title }}
                                </h2>

                                <x-text-input name="blog_new_title" id="blog_new_title" value="{{ $blog->blog_title }}"
                                    class="hidden p-2" />

                                @error('blog_new_title')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($blog->userID === Auth::user()->userID || Auth::user()->role === 'admin')
                                <x-secondary-button id="edit-blog">Edit Blog</x-secondary-button>
                                <div class="hidden" id="action-buttons">
                                    <x-primary-button>Confirm</x-primary-button>

                                    <x-danger-button type="button" id="cancel-edit">Cancel Edit</x-danger-button>
                                </div>
                            @else
                                <p class="font-bold text-gray-600 dark:text-white">
                                    -{{ $blog->user->name }}</p>
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
</script>
