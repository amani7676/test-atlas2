<div class="wrapper">

    <div class="content">
        <div class="container-fluid px-4 mt-4">

            {{-- ردیف سررسید ها و رزرو ها و شبانه ها --}}
            <div class="row">
                {{-- expir date - Static با partial --}}
                <div class="col-lg-7">
                    @include('livewire.pages.home.partials.expirs')
                </div>

                {{-- Reservations & Nightly - Static با partial --}}
                <div class="col-lg-5">
                    @include('livewire.pages.home.partials.reservations')
                    @include('livewire.pages.home.partials.nightly')
                </div>
            </div>

            {{-- ردیف های تخت خالی و خروجی ها --}}
            <div class="row mt-4">
                {{-- Exits - Static با partial --}}
                <div class="col-lg-7">
                    @include('livewire.pages.home.partials.exists')
                </div>

                {{-- Empty Beds - Interactive با Livewire --}}
                <div class="col-lg-5">
                    <livewire:pages.home.componets.empty-beds :allReportService="$allReportService" :beds="$beds"/>
                </div>
            </div>

            {{-- فرم - مدارک - توضیحات --}}
            <div class="row mt-4">
                {{-- Documents - Interactive با Livewire --}}
                <div class="col-md-4">
                    <livewire:pages.home.componets.documetns :allReportService="$allReportService"/>
                </div>

                {{-- Forms - Interactive با Livewire --}}
                <div class="col-md-4">
                    <livewire:pages.home.componets.forms :allReportService="$allReportService"/>
                </div>

                {{-- Debts - Static با partial --}}
                <div class="col-md-4">
                    @include('livewire.pages.home.partials.payments')
                </div>
            </div>

        </div>
    </div>

    @script
    <script>
        // !!! گوش دادن به رویداد 'show-toast'
        window.addEventListener('show-toast', (event) => {
            const params = event.detail[0];

            // !!! فراخوانی cuteToast به جای cuteAlert
            if (typeof window.cuteToast === 'function') {
                cuteToast({
                    type: params.type,
                    title: params.title,
                    description: params.description,
                    timer: params.timer // timer در Toast ضروری است
                });
            } else {
                console.error('cuteToast function is not available on window object.');
            }
        });
    </script>
    @endscript
</div>
