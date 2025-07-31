<div>
    <div class="relative w-full" x-data="{ isOpen: @entangle('isOpen') }">
        <!-- Select Input -->
        <div class="relative">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                wire:click="open"
                placeholder="{{ $placeholder }}"
                class="form-control w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                autocomplete="off"
            >

            <!-- Clear Button -->
            @if($selected)
                <button
                    type="button"
                    wire:click="clearSelection"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            @endif

            <!-- Dropdown Arrow -->
            <button
                type="button"
                wire:click="{{ $isOpen ? 'close' : 'open' }}"
                class="absolute left-8 top-1/2 transform -translate-y-1/2 text-gray-400"
            >
                <svg class="w-4 h-4 transform {{ $isOpen ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Options Dropdown -->
        @if($isOpen)
            <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                @if(count($options) > 0)
                    @foreach($options as $option)
                        <div
                            wire:click="selectOption('{{ $option['value'] }}', '{{ $option['label'] }}')"
                            class="px-3 py-2 cursor-pointer hover:bg-blue-50 {{ $selected == $option['value'] ? 'bg-blue-100 text-blue-900' : 'text-gray-900' }}"
                        >
                            {{ $option['label'] }}
                        </div>
                    @endforeach
                @else
                    <div class="px-3 py-2 text-gray-500 text-center">
                        {{ empty($search) ? 'گزینه‌ای موجود نیست' : 'نتیجه‌ای یافت نشد' }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Hidden Input for Form Submission -->
        <input type="hidden" name="selected_option" value="{{ $selected }}">
    </div>

    <!-- Close dropdown when clicking outside -->
    <script>
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[x-data]')) {
            @this.call('close');
            }
        });
    </script></div>
