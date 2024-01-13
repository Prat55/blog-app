<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div
        class="relative w-full max-w-lg px-6 pt-10 mx-auto bg-white shadow-xl pb-9 rounded-2xl dark:bg-gray-700 dark:text-white">
        <div class="flex flex-col w-full max-w-md mx-auto space-y-16">
            <div class="flex flex-col items-center justify-center space-y-2 text-center">
                <div class="text-3xl font-semibold">
                    <p class="">Email Verification</p>
                </div>
                <div class="flex flex-row text-sm font-medium text-gray-400">
                    <p>We have sent a code to your email</p>
                </div>
            </div>

            <div>
                <form action="{{ route('login.verified', ['token' => $token]) }}" method="post">
                    @csrf

                    <div class="flex flex-col space-y-8">
                        <div
                            class="flex flex-row items-center justify-between w-full max-w-xs gap-2 mx-auto text-black">
                            <div class="w-16 h-16">
                                <input
                                    class="flex flex-col items-center justify-center w-full h-full px-5 text-lg text-center bg-white border border-gray-200 outline-none rounded-xl focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                    type="text" name="char1" id="char1" max="1" min="1">
                            </div>
                            <div class="w-16 h-16 ">
                                <input
                                    class="flex flex-col items-center justify-center w-full h-full px-5 text-lg text-center bg-white border border-gray-200 outline-none rounded-xl focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                    type="text" name="char2" id="char2" max="1" min="1">
                            </div>
                            <div class="w-16 h-16 ">
                                <input
                                    class="flex flex-col items-center justify-center w-full h-full px-5 text-lg text-center bg-white border border-gray-200 outline-none rounded-xl focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                    type="text" name="char3" id="char3" max="1" min="1">
                            </div>
                            <div class="w-16 h-16 ">
                                <input
                                    class="flex flex-col items-center justify-center w-full h-full px-5 text-lg text-center bg-white border border-gray-200 outline-none rounded-xl focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                    type="text" name="char4" id="char4" max="1" min="1">
                            </div>
                            <div class="w-16 h-16 ">
                                <input
                                    class="flex flex-col items-center justify-center w-full h-full px-5 text-lg text-center bg-white border border-gray-200 outline-none rounded-xl focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                    type="text" name="char5" id="char5" max="1" min="1">
                            </div>
                        </div>

                        <div>
                            @error('char1')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('char2')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('char3')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('char4')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('char5')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col space-y-5">
                            <div>
                                <button type="submit"
                                    class="flex flex-row items-center justify-center w-full py-5 text-sm text-center text-white bg-blue-700 border border-none shadow-sm outline-none rounded-xl">
                                    Verify Code
                                </button>
                            </div>

                            <div
                                class="flex flex-row items-center justify-center space-x-1 text-sm font-medium text-center text-gray-500">
                                <p>
                                    Didn't recieve code?
                                </p>
                                <a class="flex flex-row items-center text-blue-600" href="" target="_blank"
                                    rel="noopener noreferrer">
                                    Resend
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</x-guest-layout>
