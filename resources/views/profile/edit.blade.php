<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center w-full p-5 bg-white rounded justify-evenly dark:bg-gray-800">
                <div class="w-[150px] h-[150px] flex justify-center items-center object-cover overflow-hidden relative">
                    <img src="/profile_img/{{ Auth::user()->profile_img ?: 'profile.png' }}" alt="profile_image"
                        class="object-cover w-full h-full border border-black rounded-full dark:border-white"
                        id="profile_image_preview">

                    <input type="hidden" name="UserId" id="UserId" value="{{ Auth::user()->userID }}">

                    @if (Auth::user()->profile_img)
                        <div class="absolute top-0 flex items-center justify-center w-full h-full">
                            <i class="cursor-pointer fa fa-times" style="color: red; font-size: 1.5rem"
                                title="Remove profile image" data-modal-target="remove-image"
                                data-modal-toggle="remove-image"></i>
                        </div>
                    @endif

                    <i class="absolute cursor-pointer bottom-2 right-5 fa fa-camera profile_change"
                        style="color: grey; font-size: 1.5rem" title="Change profile image"></i>

                    <div class="hidden">
                        <input type="file" name="profile_image" id="profile_image">
                    </div>

                    {{-- ? <!--Profile Image Delete modal --> --}}
                    <div id="remove-image" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-2xl max-h-full p-4">
                            {{-- ! <!-- Modal content --> --}}
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                {{-- ? <!-- Modal body --> --}}
                                <div class="p-4 space-y-4 md:p-5">
                                    <form method="post" action="/profile/image/remove/{{ Auth::user()->userID }}"
                                        class="p-6" enctype="multipart/form-data">
                                        @csrf
                                        @method('delete')

                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Are you sure you want to delete your profile photo?') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Once your profile image is deleted, will not be recovered.') }}
                                        </p>

                                        <div class="flex justify-center mt-6">
                                            <button data-modal-hide="remove-image" type="button"
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                                Cancel
                                            </button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Image') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-white">
                    <h4>Name: {{ Auth::user()->name }}</h4>
                    <h6>Email: {{ Auth::user()->email }}</h6>
                    <h6>Phone: {{ Auth::user()->phone }}</h6>
                </div>
            </div>

            @if (!Auth::user()->email_verified_at)
                <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                    <section>
                        <div class="flex items-center justify-center w-full" style="margin-bottom: 25px">
                            <h3 class="text-white" style="font-size: 20px">Verify Email</h3>
                        </div>

                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf

                                <div>
                                    <x-primary-button>
                                        {{ __('Resend Verification Email') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                    class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                    </section>
                </div>
            @endif

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $('.profile_change').click(function() {
        $('#profile_image').click();
    });

    $('#profile_image').change(function() {
        let reader = new FileReader();

        reader.onload = (e) => {

            $('#profile_image_preview').attr('src', e.target.result);
            $('#profile_image_preview2').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);


    });

    $('#profile_image').on('change', function() {

        var userid = $('#UserId').val();
        var formData = new FormData();

        // Append the selected image to the FormData object
        formData.append('profile_image', $(this)[0].files[0]);

        // Send the image using jQuery AJAX
        $.ajax({
            type: 'POST',
            url: 'change-profile/' + userid,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#errstatus').html("");
                    $('#errstatus').addClass('alert alert-danger');
                    $.each(response.errors, function(key, err_values) {
                        $('#errstatus').append('<li>' + err_values +
                            '</li>');
                    }).delay(200).fadeOut(2000);
                } else if (response.status == 404) {
                    $('#errstatus').html("");
                    $('#sStatus').addClass('alert alert-danger');
                    $('#sStatus').text(response.message);
                } else {
                    $('#errstatus').html("");
                    $('#sStatus').html("");
                    $('#sStatus').addClass('alert alert-success');
                    $('#sStatus').text(response.message).delay(200).fadeOut(2000);
                }
            },
        });
    });
</script>
