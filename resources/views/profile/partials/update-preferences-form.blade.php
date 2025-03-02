<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tool Preferences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your tool preferences and settings.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.preferences.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('Profile Picture')" />
            <input type="file" name="avatar" id="avatar" 
                class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-emerald-50 file:text-emerald-700
                hover:file:bg-emerald-100"
                accept="image/*"
            />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            @if($user->avatar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <select id="timezone" name="timezone" 
                class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                @foreach(timezone_identifiers_list() as $timezone)
                    <option value="{{ $timezone }}" {{ $user->timezone === $timezone ? 'selected' : '' }}>
                        {{ $timezone }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
        </div>

        <div>
            <x-input-label for="preferred_language" :value="__('Preferred Programming Language')" />
            <select id="preferred_language" name="preferred_language" 
                class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                @foreach(['php', 'javascript', 'python', 'java', 'csharp', 'ruby'] as $lang)
                    <option value="{{ $lang }}" {{ $user->preferred_language === $lang ? 'selected' : '' }}>
                        {{ ucfirst($lang) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('preferred_language')" />
        </div>

        <div>
            <x-input-label :value="__('Tool Preferences')" />
            <div class="mt-2 space-y-2">
                @foreach([
                    'code_generation' => 'Code Generation',
                    'debugging' => 'Debugging',
                    'security' => 'Security Analysis',
                    'performance' => 'Performance Optimization',
                    'documentation' => 'Documentation Generation',
                    'domain_valuation' => 'Domain Valuation'
                ] as $key => $label)
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                name="tool_preferences[]" 
                                value="{{ $key }}"
                                {{ in_array($key, json_decode($user->tool_preferences ?? '[]', true)) ? 'checked' : '' }}
                                class="h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="{{ $key }}" class="font-medium text-gray-700">{{ $label }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('tool_preferences')" />
        </div>

        @if($user->api_requests_count > 0)
            <div class="rounded-md bg-gray-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-gray-700">
                            {{ __('Total API Requests: ') }} {{ number_format($user->api_requests_count) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Preferences') }}</x-primary-button>

            @if (session('status') === 'preferences-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
