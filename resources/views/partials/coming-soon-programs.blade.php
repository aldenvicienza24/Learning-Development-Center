@if(($comingSoonPrograms ?? collect())->isNotEmpty())
    <section class="pt-16 pb-8 mt-16" data-section="segera">
        <div class="mobile-x-20 max-w-7xl mx-auto px-4 md:px-8">
            <div class="reveal-left mb-8 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#C3110C]">Program Segera Terbuka</h2>
            </div>

            <div class="relative w-full group">
                <div class="flex overflow-x-auto hide-scrollbar snap-x snap-mandatory gap-6 pb-6 pt-2 slider-container program-slider">
                    @foreach($comingSoonPrograms as $program)
                        <div class="reveal delay-300 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] flex-none snap-start">
                            <x-program-card :program="$program" :coming-soon="true" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif