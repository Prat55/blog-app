<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center w-full p-5 bg-white rounded justify-evenly dark:bg-gray-800">
                <div class="w-[150px] h-[150px] flex justify-center items-center object-cover overflow-hidden relative">
                    <img src="/profile_img/{{ Auth::user()->profile_img ?: 'profile.png' }}" alt="profile_image"
                        class="object-cover w-full h-full border border-black rounded-full dark:border-white ">

                    <i class="absolute bottom-2 right-5 fa fa-camera profile_change"
                        style="color: grey; font-size: 1.5rem" title="change profile image"></i>

                    <div class="hidden">
                        <input type="file" name="profile_image" id="profile_image">
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
</script>
