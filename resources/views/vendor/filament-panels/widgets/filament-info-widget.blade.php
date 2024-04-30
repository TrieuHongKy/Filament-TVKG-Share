<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                <a
                    href="/"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    <img style="width: 98px" src="<?=asset('images/logo.png')?>" alt="tvkg_logo">
                </a>
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <p><?= now()->year ?> &copy; <span style="color: #18A005">Tìm Việc Kiên Giang</span></p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
