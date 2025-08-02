<div>
    <div class="search-container justify-content" wire:ignore.self>
        <div class="search-input-wrapper">
            <input
                type="text"
                class="search-input ml-5"
                placeholder="جستجو بر اساس نام یا تلفن..."
                wire:model.live.debounce.300ms="search"
                wire:focus="$set('showResults', true)"
                wire:blur="$dispatch('hideSearchResults')"
                autocomplete="off"
                id="search-input"
            >

            <!-- Loading indicator -->
            @if($isLoading)
                <div class="search-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            @endif
        </div>

        <button class="search-btn" type="button" wire:click="clearSearch">
            <i class="fas fa-{{ $search ? 'times' : 'search' }}"></i>
        </button>

        <!-- نتایج جستجو -->
        @if($showResults)
            <div
                class="search-results"
                style="
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                max-height: 300px;
                overflow-y: auto;
                z-index: 1000;
                animation: slideDown 0.2s ease-out;
            "
            >
                @if($searchResults->count() > 0)
                    @foreach($searchResults as $index => $result)

                        <div
                            class="search-result-item {{ $selectedIndex === $index ? 'selected' : '' }}"
                            wire:click="selectResult({{ $result->id }})"
                            wire:mouseenter="$set('selectedIndex', {{ $index }})"
                            style="
                            padding: 12px 16px;
                            border-bottom: 1px solid #f0f0f0;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            {{ $selectedIndex === $index ? 'background-color: #e3f2fd; border-left: 3px solid #2196f3;' : '' }}
                        "
                            onmouseover="if({{ $selectedIndex }} !== {{ $index }}) this.style.backgroundColor='#f8f9fa'"
                            onmouseout="if({{ $selectedIndex }} !== {{ $index }}) this.style.backgroundColor='white'"
                        >
                            <!-- نام اقامتگر -->
                            <div style="font-weight: 500; color: #333; margin-bottom: 4px;">
                                <i class="fas fa-user" style="margin-left: 8px; color: #6c757d;"></i>
                                {!! $this->highlightSearch($result->full_name) !!}
                                <a style="margin-right: 5px"  href="{{ route('table_list') }}#{{$result->contract->bed->room->name}}">
                                    <i class="fa-solid fa-paper-plane text-info"></i>
                                </a>
                            </div>

                            <!-- شماره تلفن -->
                            <div style="font-size: 0.9em; color: #6c757d; margin-bottom: 6px;">
                                <i class="fas fa-phone" style="margin-left: 8px;"></i>
                                {!! $this->highlightSearch($result->phone) !!}
                            </div>

                            <!-- اطلاعات تخت، اتاق و واحد -->
                            @if($result->contract && $result->contract->bed)
                                <div style="font-size: 0.85em; color: #28a745; display: flex; flex-wrap: wrap; gap: 10px;">
                                    <!-- تخت -->
                                    <span style="background: #e8f5e8; padding: 2px 6px; border-radius: 4px;">
                                    <i class="fas fa-bed" style="margin-left: 4px;"></i>
                                    تخت: {{ $result->contract->bed->name }}
                                </span>

                                    <!-- اتاق -->
                                    @if($result->contract->bed->room)
                                        <span style="background: #e3f2fd; padding: 2px 6px; border-radius: 4px;">
                                        <i class="fas fa-door-open" style="margin-left: 4px;"></i>
                                        اتاق: {{ $result->contract->bed->room->name }}
                                    </span>
                                    @endif

                                    <!-- واحد -->
                                    @if($result->contract->bed->room && $result->contract->bed->room->unit)
                                        <span style="background: #F1F0E4; padding: 2px 6px; border-radius: 4px;">
                                        <i class="fas fa-building" style="margin-left: 4px;"></i>
                                        : {{ $result->contract->bed->room->unit->name }}
                                    </span>

                                        <span style="background: #F1F0E4; padding: 2px 6px; border-radius: 4px;">
                                            <i class="fa-solid fa-calendar-days" style="margin-left: 4px;"></i>
                                        : {{ $result->contract->getPaymentDateJalaliAttribute() }}
                                    </span>
                                    @endif
                                </div>
                            @else
                                <div style="font-size: 0.85em; color: #dc3545;">
                                    <i class="fas fa-exclamation-triangle" style="margin-left: 4px;"></i>
                                    بدون تخت تخصیص یافته
                                </div>
                            @endif
                        </div>
                    @endforeach




                @elseif(strlen($search) >= 2 && !$isLoading)
                    <div style="padding: 16px; text-align: center; color: #6c757d;">
                        <i class="fas fa-search" style="margin-left: 8px;"></i>
                        نتیجه‌ای یافت نشد
                    </div>
                @endif
            </div>
        @endif
    </div>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-input-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .search-loading {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #007bff;
        }

        .search-result-item.selected {
            background-color: #e3f2fd !important;
            border-left: 3px solid #2196f3;
        }

        kbd {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 1px 4px;
            font-size: 0.8em;
            margin: 0 2px;
        }

        .search-container {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 4px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .search-container:focus-within {
            background: white;
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .search-input {
            border: none;
            background: transparent;
            outline: none;
            padding: 8px 16px;
            font-size: 14px;
            width: 250px;
            color: #333;
            direction: rtl;
        }

        .search-input::placeholder {
            color: #6c757d;
            font-size: 13px;
        }

        .search-btn {
            background: #007bff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: #0056b3;
            /*transform: scale(1.05);*/
        }
    </style>

    <script>
        // JavaScript برای بهبود تجربه کاربری
        document.addEventListener('DOMContentLoaded', function() {
            // Hide results when clicking outside
            document.addEventListener('click', function(e) {
                const searchContainer = e.target.closest('.search-container');
                if (!searchContainer) {
                @this.call('hideResults');
                }
            });
        });
    </script>
</div>
