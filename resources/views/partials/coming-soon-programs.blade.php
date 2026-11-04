@if(($comingSoonPrograms ?? collect())->isNotEmpty())
    <section class="coming-soon-section pt-8 pb-8 mt-6" data-section="segera" aria-labelledby="coming-soon-title">
        <div class="mobile-x-20 max-w-7xl mx-auto px-4 md:px-8">
            <div class="reveal-left mb-8 text-center">
                <h2 id="coming-soon-title" data-id-text="Program Segera Dibuka" data-en-text="Upcoming Programs">Program Segera Dibuka</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 pb-6 pt-2 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($comingSoonPrograms as $program)
                    <div class="reveal delay-300 min-w-0">
                        <x-program-card :program="$program" :coming-soon="true" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
