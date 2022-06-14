<form method="PUT" action="{{ route('settings.password.update') }}">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 id="password_settings_heading" class="text-lg leading-6 font-medium text-gray-900">
                    Password Settings
                </h2>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Update the password used for logging into your account.
                </p>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12">
                    <x-forms.label for="current_password">
                        Current Password
                    </x-forms.label>

                    <x-forms.inputs.password id="current_password" name="current_password" required />
                </div>

                <div class="col-span-12">
                    <x-forms.label for="password">New Password</x-forms.label>

                    <x-forms.inputs.password id="password" name="password" required />
                </div>

                <div class="col-span-12">
                    <x-forms.label for="password_confirmation">Confirm New Password</x-forms.label>

                    <x-forms.inputs.password id="password_confirmation" name="password_confirmation" required />
                </div>
            </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <span class="inline-flex rounded-md shadow-sm">
                <x-buttons.primary-button type="submit">
                    Update Password
                </x-buttons.primary-button>
            </span>
        </div>
    </div>
</form>
