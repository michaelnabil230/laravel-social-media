<form method="PUT" action="{{ route('settings.profile.update') }}">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 class="text-lg leading-6 font-medium text-gray-900">
                    Profile
                </h2>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Update your profile information.
                </p>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6">
                    <x-forms.label for="name">
                        Name
                    </x-forms.label>

                    <x-forms.inputs.input type="text" id="name" name="name" :value="auth()->user()->name" required />
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <x-forms.label for="username">
                        Username
                    </x-forms.label>

                    <x-forms.inputs.input type="text" id="username" name="username" :value="auth()->user()->username" required />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12">
                    <x-forms.label for="email">
                        Email
                    </x-forms.label>

                    <x-forms.inputs.email name="email" id="email" :value="auth()->user()->email" required />

                    @unless(Auth::user()->hasVerifiedEmail())
                        <span class="mt-2 text-sm text-gray-500">
                            This email address is not verified yet.
                            <a href="{{ route('verification.notice') }}" class="text-red-500">
                                Resend verification email.
                            </a>
                        </span>
                    @endunless
                </div>
            </div>

            <div class="space-y-1">
                <x-forms.label for="bio">
                    Bio
                </x-forms.label>

                <x-forms.inputs.textarea name="bio" id="bio" rows="3" maxlength="160">
                    {{ auth()->user()->bio }}
                </x-forms.inputs.textarea>

                <span class="mt-2 text-sm text-gray-500">
                    The user bio is limited to 160 characters.
                </span>
            </div>

        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <span class="inline-flex rounded-md shadow-sm">
                <x-buttons.primary-button type="submit">
                    Update Profile
                </x-buttons.primary-button>
            </span>
        </div>
    </div>
</form>
