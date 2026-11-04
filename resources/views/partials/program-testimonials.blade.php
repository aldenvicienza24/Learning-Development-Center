<section id="testimoni" class="program-documentation offers-section" aria-labelledby="documentation-title">
    @include('partials.program-ripple-background')
    <div class="documentation-inner">
        <div class="documentation-heading section-heading section-heading-on-dark reveal">
            <p class="section-eyebrow" data-id-text="Cerita & momen" data-en-text="Stories & moments">Cerita &amp; momen</p>
            <h2 id="documentation-title" class="section-title" data-id-text="Testimoni dan Dokumentasi" data-en-text="Testimonials and Documentation">Testimoni dan Dokumentasi</h2>
            <p class="section-description" data-id-text="Lihat pengalaman peserta dan momen pilihan dari berbagai program kami." data-en-text="See participant experiences and selected moments from our programs.">Lihat pengalaman peserta dan momen pilihan dari berbagai program kami.</p>
        </div>
        <div class="documentation-grid {{ $testimonials->count() === 1 ? 'documentation-grid-single' : ($testimonials->count() === 2 ? 'documentation-grid-pair' : '') }}" data-documentation-slider role="region" aria-label="Galeri dokumentasi program" tabindex="0">
            @forelse ($testimonials as $testimonial)
                <article id="documentation-story-{{ $testimonial->id }}" class="documentation-card" data-documentation-gallery>
                    <div class="documentation-panel">
                    @php($photos = $testimonial->photos ?? [])
                    <div class="documentation-visual">
                    @if ($photos)
                        <div class="documentation-media">
                        <a class="documentation-cover" data-full-photo href="{{ url('/storage/'.$photos[0]) }}" target="_blank" rel="noopener" aria-label="Buka foto dokumentasi {{ $testimonial->program->title }} ukuran penuh">
                            <img data-main-photo loading="lazy" decoding="async" src="{{ url('/storage/'.$photos[0]) }}" alt="Dokumentasi {{ $testimonial->program->title }}, foto 1">
                            <span class="documentation-photo-count"><span data-photo-index>1</span> / {{ count($photos) }} <span data-id-text="foto" data-en-text="photos">foto</span></span>
                            <span class="documentation-enlarge" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 3H3v5m13-5h5v5M3 16v5h5m13-5v5h-5"/></svg></span>
                        </a>
                        <p class="documentation-image-error" data-image-error role="status" hidden>Foto belum dapat dimuat.</p>
                        </div>
                        @if (count($photos) > 1)
                            <div class="documentation-thumbnails" role="group" aria-label="Pilih foto dokumentasi {{ $testimonial->program->title }}">
                                @foreach ($photos as $photo)
                                    <button type="button" data-photo-src="{{ url('/storage/'.$photo) }}" data-photo-alt="Dokumentasi {{ $testimonial->program->title }}, foto {{ $loop->iteration }}" data-photo-number="{{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="Lihat foto {{ $loop->iteration }}"></button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="documentation-no-photo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="9" cy="9" r="2"/><path d="m3 17 5-5 4 4 3-3 6 6"/></svg><span data-id-text="Foto belum tersedia" data-en-text="Photos are not available yet">Foto belum tersedia</span></div>
                    @endif
                    </div>
                    <div class="documentation-card-content">
                    <span class="documentation-kicker" data-id-text="DOKUMENTASI PROGRAM" data-en-text="PROGRAM DOCUMENTATION">DOKUMENTASI PROGRAM</span>
                    <h3 class="documentation-program-title"><a href="{{ route('program.show', $testimonial->program) }}">{{ $testimonial->program->title }}</a></h3>

                        <p class="documentation-description" data-documentation-text>{{ $testimonial->body }}</p>
                        <button type="button" class="documentation-read" data-read-description hidden data-id-text="Baca deskripsi" data-en-text="Read description">Baca deskripsi</button>
                        @if ($testimonial->comments)
                            <div class="documentation-comments" data-comment-carousel>
                                <h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M20 11.5a8 8 0 0 1-8 8H4l1.5-4A8 8 0 1 1 20 11.5Z"/><path d="M8 9h8m-8 4h5"/></svg><span data-id-text="Komentar kegiatan" data-en-text="Activity comments">Komentar kegiatan</span><span class="documentation-comment-count">{{ count($testimonial->comments) }}</span></h4>
                                <div class="documentation-comment-window">
                                    <div data-comment-track><ul data-comment-list>@foreach ($testimonial->comments as $comment)<li data-comment-slide><span class="documentation-quote" aria-hidden="true">“</span><span data-comment-text>{{ $comment }}</span></li>@endforeach</ul></div>
                                </div>
                            </div>
                        @endif
                        <a class="documentation-detail service-registration-link" href="{{ route('program.show', $testimonial->program) }}"><span data-id-text="Jelajahi program" data-en-text="Explore program">Jelajahi program</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
                    </div>
                    </div>
                </article>
            @empty
                <div class="documentation-empty"><h3 data-id-text="Dokumentasi kegiatan segera hadir" data-en-text="Activity documentation is coming soon">Dokumentasi kegiatan segera hadir</h3><p data-id-text="Belum ada dokumentasi yang ditampilkan untuk pilihan ini." data-en-text="No documentation is available for this selection yet.">Belum ada dokumentasi yang ditampilkan untuk pilihan ini.</p></div>
            @endforelse
        </div>
    </div>
</section>
<dialog class="documentation-text-dialog" aria-labelledby="documentation-text-title">
    <div><h3 id="documentation-text-title"></h3><button type="button" data-close-documentation aria-label="Tutup">×</button></div>
    <p data-documentation-full-text></p>
</dialog>
<dialog class="documentation-photo-dialog" aria-labelledby="documentation-photo-title">
    <div class="documentation-viewer-heading"><div><span data-id-text="GALERI KEGIATAN" data-en-text="ACTIVITY GALLERY">GALERI KEGIATAN</span><h3 id="documentation-photo-title"></h3></div><button type="button" data-close-photo aria-label="Tutup galeri">×</button></div>
    <div class="documentation-viewer-image"><img data-viewer-photo alt=""></div>
    <div class="documentation-viewer-footer"><div data-viewer-choices role="group" aria-label="Pilih foto"></div><a data-original-photo target="_blank" rel="noopener" data-id-text="Buka ukuran asli" data-en-text="Open original image">Buka ukuran asli</a></div>
</dialog>
<style>
    .program-documentation { position:relative; isolation:isolate; overflow:hidden; padding:48px clamp(24px,6vw,60px); background:linear-gradient(135deg,#08142D 0%,#2563EB 100%); scroll-margin-top:100px; }
    .documentation-inner { position:relative; z-index:10; width:100%; max-width:1280px; margin:auto; }








    .program-documentation :is(a,button,select):focus-visible { outline:3px solid #3B82F6; outline-offset:3px; }
    .documentation-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:22px; align-items:stretch; width:100%; max-width:1040px; margin-inline:auto; }
    .documentation-grid-single { grid-template-columns:minmax(0,430px); justify-content:center; }
    .documentation-card { min-width:0; scroll-snap-align:start; }
    .documentation-panel { position:relative; isolation:isolate; display:grid; grid-template-columns:minmax(0,.92fr) minmax(0,1.08fr); height:100%; min-height:244px; padding:8px; gap:6px; overflow:hidden; border:0; border-radius:23px; background:#BFD7F5; box-shadow:none; transition:transform .35s cubic-bezier(.2,.8,.2,1); }
    .documentation-panel::before { content:""; position:absolute; z-index:-2; inset:-100%; background:conic-gradient(from 0deg,#0E214A 0deg,#0E214A 55deg,#9CB0CF 95deg,#2563EB 125deg,#0E214A 145deg,#0E214A 175deg,#0E214A 235deg,#9CB0CF 275deg,#2563EB 305deg,#0E214A 325deg,#0E214A 360deg); pointer-events:none; }
    .documentation-panel::after { content:""; position:absolute; z-index:-1; inset:3px; border:1px solid #F2F6FF; border-radius:20px; background:linear-gradient(145deg,#0E214A 55%,#0E214A); pointer-events:none; }
    .documentation-card:hover .documentation-panel { box-shadow:none; }
    .documentation-visual { min-width:0; position:relative; align-self:stretch; min-height:228px; overflow:hidden; border:1px solid #ffffffb0; border-radius:15px; background:#BFD7F5; box-shadow:none; }
    .documentation-media,.documentation-cover { display:block; position:relative; height:100%; }
    .documentation-media { position:absolute; inset:0; }
    .documentation-cover > [data-main-photo] { position:absolute; inset:0; display:block; width:100%; height:100%; object-fit:cover; object-position:center; z-index:1; }
    .documentation-cover::after { content:""; position:absolute; inset:0; z-index:1; background:linear-gradient(#160c1828,transparent 28%,transparent 65%,#160c1870); pointer-events:none; }
    .documentation-photo-count { position:absolute; z-index:2; top:12px; left:12px; padding:7px 10px; border:1px solid #ffffff50; border-radius:9px; background:#201b217a; backdrop-filter:blur(14px); box-shadow:none; color:#F2F6FF; font-size:10px; font-weight:550; }
    .documentation-enlarge { display:grid; place-items:center; position:absolute; z-index:2; top:12px; right:12px; width:32px; height:32px; border:1px solid #ffffff50; border-radius:9px; background:#201b217a; backdrop-filter:blur(14px); color:#F2F6FF; }
    .documentation-enlarge svg { width:14px; height:14px; }
    .documentation-image-error { position:absolute; z-index:3; inset:40% 8px auto; padding:8px; border-radius:6px; background:#0E214A; color: #F2F6FF; font-size:11px; text-align:center; }
    .documentation-image-error[hidden] { display:none; }
    .documentation-thumbnails { position:absolute; z-index:2; bottom:8px; left:12px; right:12px; display:flex; justify-content:center; align-items:center; gap:2px; min-height:28px; }
    .documentation-thumbnails [data-photo-src] { display:grid; place-items:center; width:22px; height:32px; padding:0; background:transparent; cursor:pointer; flex-shrink:1; }
    .documentation-thumbnails [data-photo-src]::after { content:""; width:5px; height:5px; border-radius:4px; background:#ffffff80; transition:width .2s ease,background .2s ease; }
    .documentation-thumbnails [aria-pressed="true"]::after { width:18px; background:#0E214A; }
    .documentation-card-content { display:flex; flex-direction:column; min-width:0; padding:10px 9px 8px; text-align:left; }
    .documentation-kicker { display:inline-flex; align-self:flex-start; align-items:center; gap:6px; margin:0 0 7px; padding:0; font-size:8px; font-weight:700; line-height:1.5; letter-spacing:.08em; color: #9CB0CF; }
    .documentation-kicker::before { content:""; width:5px; height:5px; flex-shrink:0; border-radius:50%; background:#2563EB; }
    .documentation-program-title { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; margin:0 0 5px; font-size:17px; font-weight:700; line-height:1.3; letter-spacing:-.025em; color:#302a29; overflow-wrap:anywhere; text-wrap:pretty; }
    .documentation-program-title a:hover { color: #F2F6FF; }
    .documentation-description { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; margin:0; color:#777076; font-size:11px; line-height:1.5; white-space:pre-line; overflow-wrap:anywhere; flex-shrink:0; }
    .documentation-read { align-self:flex-start; padding:4px 0; color: #9CB0CF; font-size:10px; text-decoration:underline; text-underline-offset:3px; cursor:pointer; }
    .documentation-read[hidden] { display:none; }
    .documentation-comments { position:relative; margin:8px 0; padding:8px 9px 5px; border:1px solid #29446F; border-radius:10px; background:#0E214A; }
    .documentation-comments h4 { display:flex; align-items:center; gap:6px; margin:0 0 5px; font-size:9px; font-weight:600; line-height:1.4; color:#7d6570; }
    .documentation-comments h4 svg { width:12px; height:12px; flex-shrink:0; }
    .documentation-comment-count { display:grid; place-items:center; margin-left:auto; min-width:18px; height:18px; padding:0 4px; border-radius:6px; background:#0E214A; color: #9CB0CF; font-size:9px; font-weight:600; }
    .documentation-comment-window { height:42px; overflow:hidden; mask-image:linear-gradient(transparent,#000 4px,#000 calc(100% - 4px),transparent); }
    [data-comment-track] { will-change:auto; }
    .documentation-comments ul { display:grid; gap:4px; list-style:none; margin:0; padding:0 0 4px; }
    .documentation-comments li { display:flex; align-items:center; gap:6px; height:38px; padding:3px 0; font-size:12px; line-height:1.4; color:#61565c; }
    .documentation-quote { display:block; align-self:center; flex-shrink:0; height:22px; font:27px/1 Georgia,serif; color:#3B82F6; }
    [data-comment-text] { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; white-space:pre-line; overflow-wrap:anywhere; }
    .documentation-detail { display:flex; align-items:center; justify-content:space-between; gap:8px; min-height:35px; margin-top:auto; padding:7px 10px; border:1px solid #2563EB; border-radius:9px; background:linear-gradient(120deg,#0E214A,#2563EB); box-shadow:none; font-size:11px; font-weight:650; line-height:1.4; color:#F2F6FF; transition:background .2s ease; }
    .documentation-detail svg { width:20px; height:20px; padding:2px; flex-shrink:0; transition:transform .25s ease; }
    .documentation-detail:hover svg { transform:translateX(3px); }
    .documentation-detail:hover { color:#F2F6FF; background:#0E214A; box-shadow:none; }
    .documentation-pagination { margin-top:6px; padding:4px 10px; border-radius:6px; background:#0E214A; }
    .documentation-no-photo { display:grid; height:100%; min-height:inherit; place-content:center; justify-items:center; gap:10px; color: #9CB0CF; font-size:11px; }
    .documentation-no-photo svg { width:40px; height:40px; }
    .documentation-empty { grid-column:1/-1; padding:40px 20px; text-align:center; border-radius:16px; background:#0E214A; color: #F2F6FF; }
    .documentation-empty h3 { font-size:18px; font-weight:600; }
    .documentation-empty p { margin-top:8px; font-size:13px; }


    .documentation-text-dialog { width:min(520px,calc(100% - 32px)); max-height:80dvh; margin:auto; padding:24px; border:0; border-radius:16px; color: #F2F6FF; box-shadow:0 24px 80px #0003; }
    .documentation-text-dialog::backdrop { background:#26080580; }
    .documentation-text-dialog > div { display:flex; align-items:center; justify-content:space-between; gap:16px; }
    .documentation-text-dialog h3 { font-size:18px; font-weight:700; }
    .documentation-text-dialog button { width:36px; height:36px; flex-shrink:0; background:#0E214A; border-radius:8px; cursor:pointer; font-size:24px; }
    .documentation-text-dialog p { margin-top:16px; white-space:pre-line; overflow-wrap:anywhere; font-size:14px; line-height:1.8; }
    .documentation-photo-dialog { width:min(1080px,calc(100% - 32px)); max-height:calc(100dvh - 32px); margin:auto; padding:0; border:1px solid #ffffff20; border-radius:18px; background:#171717; color:#F2F6FF; overflow:hidden; box-shadow:0 24px 90px #0007; }
    .documentation-photo-dialog::backdrop { background:#100a09cf; backdrop-filter:blur(5px); }
    .documentation-viewer-heading { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:18px 22px; }
    .documentation-viewer-heading span { font-size:9px; letter-spacing:.14em; color:#b5a8a3; }
    .documentation-viewer-heading h3 { font-size:17px; font-weight:600; margin-top:3px; overflow-wrap:anywhere; }
    .documentation-viewer-heading button { flex-shrink:0; width:34px; height:34px; border-radius:50%; background:#ffffff16; color:#F2F6FF; font-size:24px; cursor:pointer; }
    .documentation-viewer-image { display:grid; place-items:center; height:min(65dvh,660px); background:#0e0e0e; }
    .documentation-viewer-image img { display:block; width:100%; height:100%; min-height:0; object-fit:contain; }
    .documentation-viewer-footer { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 22px; }
    .documentation-viewer-footer [data-viewer-choices] { display:flex; flex-wrap:wrap; gap:6px; }
    .documentation-viewer-footer button { width:30px; height:30px; border:1px solid #ffffff20; border-radius:7px; font-size:11px; cursor:pointer; }
    .documentation-viewer-footer button[aria-pressed="true"] { background:#0E214A; color:#232323; }
    .documentation-viewer-footer a { color:#9CB0CF; font-size:11px; text-decoration:underline; text-underline-offset:3px; }
    @media(min-width:1051px) {
        .documentation-grid { grid-template-columns:none; grid-auto-flow:column; grid-auto-columns:min(430px,calc((100% - 22px)/2)); overflow-x:auto; padding-bottom:6px; scroll-snap-type:x mandatory; scrollbar-width:thin; scrollbar-color:#ffffff50 transparent; }
        .documentation-grid-single { grid-auto-columns:minmax(0,430px); justify-content:center; }
        .program-documentation { min-height:max(460px,var(--documentation-section-height,500px)); padding-top:18px; padding-bottom:18px; display:flex; align-items:center; content-visibility:visible; }

        .documentation-card:focus-within { scroll-margin:10px; }
    }
    @media(max-width:1050px) {
        .documentation-panel { display:flex; flex-direction:column; gap:8px; }
        .documentation-visual { height:165px; min-height:165px; flex-shrink:0; }
        .documentation-card-content { padding:12px 10px 8px; flex:1; }
    }
    @media(max-width:650px) {
        .documentation-grid { grid-template-columns:1fr; }

        .documentation-visual { height:175px; min-height:175px; }
        .documentation-card-content { padding:12px 10px 8px; }
        .documentation-viewer-footer { flex-wrap:wrap; }
    }
    .documentation-grid { position:relative; grid-template-columns:none; grid-auto-flow:column; grid-auto-columns:min(430px,calc((100% - 22px)/2)); overflow-x:auto; padding-block:8px 14px; scroll-snap-type:x mandatory; overscroll-behavior-x:contain; scrollbar-width:thin; scrollbar-color:#ffffff50 transparent; }
    .documentation-grid-single { grid-auto-columns:minmax(0,430px); justify-content:center; }
    .documentation-grid:focus-visible { outline:2px solid #F2F6FF; outline-offset:4px; border-radius:8px; }
    .documentation-grid > .documentation-empty { grid-column:auto; }
    .documentation-grid:has(> .documentation-empty) { grid-auto-columns:100%; }
    @media(max-width:650px) {
        .documentation-grid { grid-template-columns:none; grid-auto-columns:min(340px,100%); }
    }
    .documentation-grid.documentation-continuous { display:block; overflow:hidden; scroll-snap-type:none; touch-action:pan-y pinch-zoom; }
    .documentation-belt { display:flex; align-items:stretch; gap:22px; width:100%; }
    .documentation-belt-static { justify-content:center; }
    .documentation-card.documentation-recycled { animation:none; }
    .documentation-belt > .documentation-card { flex:0 0 min(430px,calc((100% - 22px)/2)); }
    @media(min-width:1101px) {
        .documentation-grid { max-width:1280px; grid-auto-columns:calc((100% - 44px)/3); }
        .documentation-grid-single { grid-auto-columns:minmax(0,412px); }
        .documentation-belt > .documentation-card { flex-basis:calc((100% - 44px)/3); }
    }
    @media(max-width:650px) {
        .documentation-belt > .documentation-card { flex-basis:min(340px,100%); }
    }
    .documentation-card.documentation-entered { animation:documentation-card-arrive .65s cubic-bezier(.2,.8,.2,1) both; animation-delay:var(--documentation-delay,0ms); }
    .documentation-cover > [data-main-photo] { transition:scale .7s cubic-bezier(.2,.8,.2,1); }
    .documentation-enlarge { transition:background .25s ease,transform .25s ease; }
    .documentation-visual::after { content:""; position:absolute; z-index:1; inset:0; background:linear-gradient(110deg,transparent 25%,#ffffff18 48%,transparent 70%); transform:translateX(-160%); pointer-events:none; }
    .documentation-card:focus-within .documentation-panel { box-shadow:none; }
    @media(hover:hover) and (pointer:fine) {
        .documentation-card:hover .documentation-panel { transform:translateY(-5px); }
        .documentation-card:hover .documentation-cover > [data-main-photo] { scale:1.045; }
        .documentation-card:hover .documentation-enlarge { background:#2563EB; transform:scale(1.08); }
    }
    @keyframes documentation-border-orbit { to { transform:rotate(360deg); } }
    @keyframes documentation-photo-light { 0%,65% { transform:translateX(-160%); } 90%,100% { transform:translateX(160%); } }
    @keyframes documentation-card-arrive { from { opacity:.3; transform:translateY(18px) scale(.98); } to { opacity:1; transform:translateY(0) scale(1); } }
    @keyframes documentation-live-pulse { 0%,100% { box-shadow:0 0 0 3px rgba(37,99,235,.08); } 50% { box-shadow:0 0 0 5px rgba(37,99,235,.16); } }

    /* Compact story cards keep the photograph and latest comment visible together. */
    .public-dashboard .program-documentation {
        min-height:0 !important;
        display:block !important;
        padding-block:clamp(26px,3vw,36px) !important;
    }
    .program-documentation .documentation-heading { margin-bottom:20px !important; }
    .program-documentation .documentation-grid { padding-block:4px 8px; }
    .program-documentation .documentation-panel {
        display:grid !important;
        grid-template-columns:minmax(0,1fr) !important;
        grid-template-rows:auto 132px !important;
        height:auto !important;
        min-height:0 !important;
        gap:5px !important;
        padding:4px !important;
        border:1px solid rgba(37,99,235,.28) !important;
        border-radius:20px !important;
        background:#fff !important;
        box-shadow:0 0 0 4px rgba(37,99,235,.035),0 12px 28px rgba(23,57,147,.1) !important;
        transition:transform .35s cubic-bezier(.2,.8,.2,1),border-color .3s ease,box-shadow .3s ease !important;
    }
    .program-documentation .documentation-panel::before {
        content:"";
        display:block !important;
        position:absolute;
        z-index:4;
        inset:-1px auto auto 50%;
        width:72px;
        height:3px;
        border-radius:0 0 999px 999px;
        background:linear-gradient(90deg,#93b3ff,#2563eb,#93b3ff);
        transform:translateX(-50%);
        animation:none !important;
        transition:width .3s ease;
        pointer-events:none;
    }
    .program-documentation .documentation-panel::after {
        display:none !important;
    }
    .program-documentation .documentation-visual {
        width:100% !important;
        height:auto !important;
        min-height:0 !important;
        aspect-ratio:16 / 9 !important;
        border:0 !important;
        border-radius:15px 15px 11px 11px !important;
        background:#e8effd !important;
    }
    .program-documentation .documentation-cover > [data-main-photo] {
        object-fit:cover !important;
        object-position:center 45% !important;
    }
    .program-documentation .documentation-cover::after {
        background:linear-gradient(180deg,rgba(8,25,66,.08),transparent 45%,rgba(8,25,66,.38)) !important;
    }
    .program-documentation .documentation-photo-count {
        top:8px;
        left:8px;
        padding:5px 7px;
        border-radius:7px;
        font-size:8px;
    }
    .program-documentation .documentation-enlarge {
        top:8px;
        right:8px;
        width:28px;
        height:28px;
        border-radius:8px;
    }
    .program-documentation .documentation-card-content {
        display:grid !important;
        grid-template-columns:minmax(0,.86fr) minmax(0,1.14fr);
        grid-template-rows:auto auto minmax(0,1fr) 31px;
        column-gap:9px;
        row-gap:2px;
        min-height:0;
        height:132px;
        padding:4px 7px 6px !important;
        overflow:hidden;
        border-top:1px solid #edf2ff;
        border-radius:0 0 14px 14px;
        background:#fff;
    }
    .program-documentation .documentation-kicker {
        grid-column:1;
        grid-row:1;
        max-width:100%;
        margin-bottom:0;
        font-size:7px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .program-documentation .documentation-program-title {
        grid-column:1;
        grid-row:2;
        margin-bottom:1px;
        font-size:14px;
        line-height:1.22;
    }
    .program-documentation .documentation-description {
        grid-column:1;
        grid-row:3;
        display:block;
        max-width:100%;
        max-height:13px;
        padding-bottom:0;
        overflow:hidden;
        font-size:9px;
        line-height:1.4;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    .program-documentation .documentation-card-content > .documentation-read {
        display:none !important;
    }
    .program-documentation .documentation-comments {
        grid-column:2;
        grid-row:1 / 4;
        align-self:stretch;
        margin:0 !important;
        padding:6px 7px !important;
        border-color:#d9e4fb !important;
        border-radius:9px !important;
        background:linear-gradient(145deg,#f7f9ff,#edf3ff) !important;
        box-shadow:inset 0 1px 0 #fff,0 5px 12px rgba(37,99,235,.07) !important;
    }
    .program-documentation .documentation-comments h4 {
        min-width:0;
        margin-bottom:4px;
        gap:4px;
        font-size:8px;
        white-space:nowrap;
    }
    .program-documentation .documentation-comments h4 svg {
        width:11px;
        height:11px;
        padding:2px;
        border-radius:50%;
        background:#2563eb;
        color:#fff;
        box-sizing:content-box;
        animation:documentation-live-pulse 2.2s ease-in-out infinite;
    }
    .program-documentation .documentation-comment-count {
        min-width:16px;
        height:16px;
        font-size:8px;
        border-radius:5px;
    }
    .program-documentation .documentation-comment-window {
        height:53px;
        overflow:hidden;
        mask-image:linear-gradient(transparent 0,#000 7px,#000 calc(100% - 5px),transparent 100%);
    }
    .program-documentation [data-comment-track] { padding-top:2px; }
    .program-documentation .documentation-comments ul {
        display:flex;
        flex-direction:column;
        gap:4px;
        padding:0;
    }
    .program-documentation .documentation-comments li {
        height:24px;
        min-height:24px;
        padding:3px 6px 3px 3px;
        gap:4px;
        border:1px solid rgba(37,99,235,.1);
        border-radius:8px;
        background:rgba(255,255,255,.86);
        box-shadow:0 2px 7px rgba(18,48,120,.06);
        font-size:9px;
        line-height:1.2;
    }
    .program-documentation .documentation-quote {
        display:grid;
        place-items:center;
        align-self:center;
        width:17px;
        height:17px;
        flex:0 0 17px;
        border-radius:50%;
        background:linear-gradient(135deg,#2563eb,#5b7cff);
        color:#fff;
        font-size:14px;
        line-height:1;
        box-shadow:0 2px 6px rgba(37,99,235,.2);
    }
    .program-documentation [data-comment-text] {
        -webkit-line-clamp:1;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    .program-documentation .documentation-detail {
        grid-column:1 / -1;
        grid-row:4;
        min-height:31px;
        padding:5px 9px;
        border-radius:8px;
        font-size:10px;
    }
    .program-documentation .documentation-detail svg { width:17px; height:17px; }
    .program-documentation .documentation-no-photo { min-height:0; font-size:9px; text-align:center; }
    .program-documentation .documentation-no-photo svg { width:30px; height:30px; }
    .program-documentation .documentation-card-content:not(:has(.documentation-comments)) > :not(.documentation-detail) {
        grid-column:1 / -1;
    }
    @media(hover:hover) and (pointer:fine) {
        .program-documentation .documentation-card:hover .documentation-panel {
            border-color:rgba(37,99,235,.52) !important;
            box-shadow:0 0 0 5px rgba(37,99,235,.06),0 18px 36px rgba(23,57,147,.15) !important;
        }
        .program-documentation .documentation-card:hover .documentation-panel::before { width:112px; }
    }
    .program-documentation .documentation-card:focus-within .documentation-panel {
        border-color:#2563eb !important;
        box-shadow:0 0 0 4px rgba(37,99,235,.12),0 16px 32px rgba(23,57,147,.14) !important;
    }

    @media(max-width:650px) {
        .public-dashboard .program-documentation { padding-block:24px !important; }
        .program-documentation .documentation-heading { margin-bottom:16px !important; }
        .program-documentation .documentation-panel {
            grid-template-columns:minmax(0,1fr) !important;
            grid-template-rows:auto 128px !important;
            height:auto !important;
            min-height:0 !important;
            padding:3px !important;
            gap:4px !important;
            border-radius:18px !important;
        }
        .program-documentation .documentation-visual { border-radius:14px 14px 10px 10px !important; }
        .program-documentation .documentation-card-content {
            grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);
            height:128px;
            padding:4px 6px 5px !important;
        }
        .program-documentation .documentation-program-title { font-size:13px; }
        .program-documentation .documentation-description { font-size:9px; }
        .program-documentation .documentation-photo-count > span:last-child { display:none; }
        .program-documentation .documentation-enlarge { width:26px; height:26px; }
        .program-documentation .documentation-comments { padding-inline:6px !important; }
        .program-documentation .documentation-comments h4 > span:nth-child(2) {
            overflow:hidden;
            text-overflow:ellipsis;
        }
    }

    @media(prefers-reduced-motion:reduce) {
        .program-documentation .animate-ripple { animation:none; }
        .program-documentation .reveal { opacity:1!important; transform:none!important; transition:none; }
        .documentation-panel,.documentation-detail svg,.documentation-thumbnails [data-photo-src]::after { transition:none; }
        .documentation-card:hover .documentation-panel { transform:none; }
        .documentation-card.documentation-entered,.documentation-panel::before,.documentation-visual::after { animation:none; }
        .program-documentation .documentation-comments h4 svg { animation:none; }
        .documentation-cover > [data-main-photo],.documentation-enlarge { transition:none; scale:1!important; transform:none!important; }
    }

</style>
<script>
    (() => {
        const section = document.querySelector('#testimoni');
        const frameCards = [...section.querySelectorAll('[data-documentation-gallery]')];
        if ('IntersectionObserver' in window) {
            const frameObserver = new IntersectionObserver(entries => {
                entries.forEach(({target,isIntersecting}) => {
                    target.classList.toggle('documentation-in-view', isIntersecting);
                    if (isIntersecting) target.classList.add('documentation-entered');
                });
            }, {threshold:.12});
            frameCards.forEach((card,index) => {
                card.style.setProperty('--documentation-delay', (index % 2) * 120 + 'ms');
                frameObserver.observe(card);
            });
        } else {
            frameCards.forEach(card => card.classList.add('documentation-in-view'));
        }
        const services = document.querySelector('#layanan');
        const dialog = document.querySelector('.documentation-text-dialog');
        const photoDialog = document.querySelector('.documentation-photo-dialog');
        function viewerState() { document.dispatchEvent(new Event('uisi:documentation-viewer')); }
        photoDialog.querySelector('[data-close-photo]').addEventListener('click', () => photoDialog.close());
        photoDialog.addEventListener('close', viewerState);
        section.querySelectorAll('[data-full-photo]').forEach(link => link.addEventListener('click', event => {
            if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
            event.preventDefault();
            const card = link.closest('[data-documentation-gallery]');
            const choices = [...card.querySelectorAll('[data-photo-src]')];
            const photos = choices.length ? choices.map(button => ({src:button.dataset.photoSrc,alt:button.dataset.photoAlt})) : [{src:link.href,alt:card.querySelector('[data-main-photo]').alt}];
            const controls = photoDialog.querySelector('[data-viewer-choices]');
            controls.replaceChildren();
            photoDialog.querySelector('h3').textContent = card.querySelector('h3').textContent;
            function select(index) {
                const image = photoDialog.querySelector('[data-viewer-photo]');
                image.src = photos[index].src;
                image.alt = photos[index].alt;
                photoDialog.querySelector('[data-original-photo]').href = photos[index].src;
                [...controls.children].forEach((button,i) => button.setAttribute('aria-pressed',String(i === index)));
            }
            photos.forEach((photo,index) => {
                const button = document.createElement('button');
                button.type = 'button'; button.textContent = index + 1;
                button.setAttribute('aria-label', `Foto ${index + 1}`);
                button.addEventListener('click', () => select(index));
                controls.append(button);
            });
            select(Math.max(0,photos.findIndex(photo => photo.src === link.href)));
            photoDialog.showModal(); viewerState();
        }));
        const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const automaticDocumentationMotion = false;
        const slider = section.querySelector('[data-documentation-slider]');
        const sliderCards = [...slider.querySelectorAll('[data-documentation-gallery]')];
        if (automaticDocumentationMotion && sliderCards.length > 1) {
            const belt = document.createElement('div');
            belt.className = 'documentation-belt';
            sliderCards.forEach(card => belt.append(card));
            slider.append(belt);
            slider.classList.add('documentation-continuous');
            let offset = 0, frame = 0, previousTime = null, visible = false, overflowing = false;
            const speed = 24; // Pixels per second, independent of display refresh rate.
            function stepSize() { return belt.firstElementChild.getBoundingClientRect().width + 22; }
            function paint() {
                const step = stepSize();
                if (!overflowing || step <= 22) { offset = 0; }
                else {
                    while (offset >= step) {
                        const first = belt.firstElementChild;
                        first.classList.add('documentation-recycled');
                        belt.append(first);
                        offset -= step;
                    }
                    while (offset < 0) {
                        const last = belt.lastElementChild;
                        last.classList.add('documentation-recycled');
                        belt.prepend(last);
                        offset += step;
                    }
                }
                belt.style.transform = 'translate3d(' + (-offset) + 'px,0,0)';
            }
            function tick(time) {
                if (previousTime !== null) offset += Math.min(time - previousTime, 64) * speed / 1000;
                previousTime = time;
                paint();
                frame = requestAnimationFrame(tick);
            }
            function scheduleBelt() {
                cancelAnimationFrame(frame);
                previousTime = null;
                if (overflowing && visible && !document.hidden && !motion.matches) frame = requestAnimationFrame(tick);
            }
            function measureBelt() {
                overflowing = sliderCards.length * stepSize() - 22 > slider.clientWidth + 2;
                belt.classList.toggle('documentation-belt-static', !overflowing);
                paint();
                scheduleBelt();
            }
            slider.addEventListener('keydown', event => {
                if (event.target !== slider || !['ArrowLeft','ArrowRight'].includes(event.key)) return;
                event.preventDefault();
                offset += (event.key === 'ArrowRight' ? 1 : -1) * stepSize();
                paint();
            });
            // Swiping adjusts the running belt; it never adds a timed pause.
            let gesture = null, dragged = false;
            slider.addEventListener('pointerdown', event => {
                if (!event.isPrimary || event.button !== 0) return;
                gesture = {id:event.pointerId, x:event.clientX, y:event.clientY, lastX:event.clientX};
                dragged = false;
            });
            slider.addEventListener('pointermove', event => {
                if (!gesture || gesture.id !== event.pointerId || !overflowing) return;
                const dx = event.clientX - gesture.x;
                if (!dragged && Math.abs(dx) < 8) return;
                if (!dragged && Math.abs(event.clientY - gesture.y) > Math.abs(dx)) { gesture = null; return; }
                dragged = true;
                slider.setPointerCapture(event.pointerId);
                if (event.cancelable) event.preventDefault();
                offset += gesture.lastX - event.clientX;
                gesture.lastX = event.clientX;
                paint();
            });
            function release(event) {
                if (!gesture || gesture.id !== event.pointerId) return;
                if (slider.hasPointerCapture(event.pointerId)) slider.releasePointerCapture(event.pointerId);
                gesture = null;
            }
            window.addEventListener('pointerup', release);
            window.addEventListener('pointercancel', release);
            slider.addEventListener('click', event => {
                if (!dragged) return;
                event.preventDefault();
                event.stopPropagation();
                dragged = false;
            }, true);
            slider.addEventListener('dragstart', event => event.preventDefault());
            slider.addEventListener('wheel', event => {
                const distance = Math.abs(event.deltaX) > Math.abs(event.deltaY) ? event.deltaX : event.shiftKey ? event.deltaY : 0;
                if (!distance || !overflowing) return;
                event.preventDefault();
                offset += distance;
                paint();
            }, {passive:false});
            document.addEventListener('visibilitychange', scheduleBelt);
            motion.addEventListener('change', scheduleBelt);
            window.addEventListener('resize', measureBelt);
            if ('ResizeObserver' in window) new ResizeObserver(measureBelt).observe(slider);
            if ('IntersectionObserver' in window) {
                new IntersectionObserver(entries => {
                    visible = entries[0].isIntersecting;
                    scheduleBelt();
                }, {threshold:.1}).observe(slider);
            } else { visible = true; }
            measureBelt();
        }
        function matchHeight() {
            if (services) section.style.setProperty('--documentation-section-height', `${services.getBoundingClientRect().height}px`);
        }
        if (services && 'ResizeObserver' in window) new ResizeObserver(matchHeight).observe(services);
        window.addEventListener('resize', matchHeight);
        matchHeight();
        function read(text, title) {
            dialog.querySelector('h3').textContent = title;
            dialog.querySelector('[data-documentation-full-text]').textContent = text;
            dialog.showModal();
            viewerState();
        }
        dialog.querySelector('[data-close-documentation]').addEventListener('click', () => dialog.close());
        section.querySelectorAll('[data-documentation-gallery]').forEach(card => {
            const description = card.querySelector('[data-documentation-text]');
            const readDescription = card.querySelector('[data-read-description]');
            function descriptionOverflow() { readDescription.hidden = description.scrollHeight <= description.clientHeight + 1; }
            readDescription.addEventListener('click', () => read(description.textContent, card.querySelector('h3').textContent));
            if ('ResizeObserver' in window) new ResizeObserver(descriptionOverflow).observe(description);
            descriptionOverflow();
            const carousel = card.querySelector('[data-comment-carousel]');
            if (!carousel || !automaticDocumentationMotion) return;
            const list = carousel.querySelector('[data-comment-list]');
            const slides = [...list.children];
            const track = carousel.querySelector('[data-comment-track]');
            let visible = false, paused = motion.matches, timer, animation;
            function isBlocked() {
                return paused || !visible || document.hidden || dialog.open || photoDialog.open || carousel.matches(':hover, :focus-within');
            }
            function stop() {
                clearTimeout(timer);
                if (animation) animation.cancel();
                animation = null;
            }
            function schedule(delay = 2300) {
                clearTimeout(timer);
                if (slides.length < 2 || isBlocked()) return;
                timer = setTimeout(advance, delay);
            }
            function advance() {
                if (isBlocked()) { schedule(); return; }
                const first = list.firstElementChild;
                if (!first) return;
                const gap = Number.parseFloat(getComputedStyle(list).rowGap) || 0;
                const distance = first.getBoundingClientRect().height + gap;
                const move = track.animate(
                    [{transform:'translateY(0)',opacity:1},{transform:`translateY(-${distance}px)`,opacity:.94}],
                    {duration:520,easing:'cubic-bezier(.22,.72,.24,1)'}
                );
                animation = move;
                move.finished.then(() => {
                    if (animation !== move) return;
                    list.append(first);
                    animation = null;
                    schedule();
                }).catch(() => {});
            }
            carousel.addEventListener('mouseenter', stop);
            carousel.addEventListener('mouseleave', () => schedule(350));
            carousel.addEventListener('focusin', stop);
            carousel.addEventListener('focusout', () => setTimeout(() => schedule(350), 0));
            document.addEventListener('visibilitychange', schedule);
            document.addEventListener('uisi:documentation-viewer', schedule);
            dialog.addEventListener('close', schedule);
            motion.addEventListener('change', () => {
                paused = motion.matches;
                paused ? stop() : schedule(350);
            });
            if ('IntersectionObserver' in window) new IntersectionObserver(entries => {
                visible = entries[0].isIntersecting;
                visible ? schedule(350) : stop();
            }, {threshold:.1}).observe(carousel);
            else { visible = true; schedule(350); }
        });
    })();
    const automaticPhotoMotion = false;
    document.querySelectorAll('[data-documentation-gallery]').forEach(gallery => {
        const image = gallery.querySelector('[data-main-photo]');
        if (!image) return;
        const error = gallery.querySelector('[data-image-error]');
        image.addEventListener('error', () => { error.hidden = false; });
        image.addEventListener('load', () => { error.hidden = true; });
        if (image.complete && image.currentSrc && !image.naturalWidth) error.hidden = false;
        const thumbnails = [...gallery.querySelectorAll('[data-photo-src]')];
        if (thumbnails.length < 2) return;

        const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const failed = new Set();
        let index = 0, revision = 0, timer, visible = false, loading = false, paused = motion.matches;
        gallery.setAttribute('aria-roledescription', 'carousel');
        function stop() { clearTimeout(timer); }
        function schedule() {
            stop();
            if (paused || !visible || loading || document.hidden || document.querySelector('.documentation-photo-dialog[open]') || gallery.matches(':hover, :focus-within')) return;
            timer = setTimeout(() => advance(1), 4500);
        }
        function show(next, manual = false) {
            stop();
            if (manual) failed.delete(next);
            const button = thumbnails[next];
            const request = ++revision;
            loading = true;
            const preload = new Image();
            preload.onload = () => {
                if (request !== revision) return;
                loading = false;
                index = next;
                image.src = button.dataset.photoSrc;
                image.alt = button.dataset.photoAlt;
                gallery.querySelector('[data-full-photo]').href = button.dataset.photoSrc;
                gallery.querySelector('[data-photo-index]').textContent = button.dataset.photoNumber;
                thumbnails.forEach(thumbnail => thumbnail.setAttribute('aria-pressed', String(thumbnail === button)));
                error.hidden = true;
                if (!motion.matches) image.animate([{opacity: .4, transform: 'translateX(10px)'}, {opacity: 1, transform: 'translateX(0)'}], {duration: 250, easing: 'ease-out'});
                schedule();
            };
            preload.onerror = () => { if (request !== revision) return; loading = false; failed.add(next); if (manual) error.hidden = false; schedule(); };
            preload.src = button.dataset.photoSrc;
        }
        function advance(direction, manual = false) {
            for (let offset = 1; offset < thumbnails.length; offset++) {
                const next = (index + direction * offset + thumbnails.length) % thumbnails.length;
                if (!failed.has(next) || manual) { show(next, manual); return; }
            }
        }

        thumbnails.forEach((button, next) => button.addEventListener('click', () => show(next, true)));
        if (!automaticPhotoMotion) return;
        gallery.addEventListener('mouseenter', stop);
        gallery.addEventListener('mouseleave', schedule);
        gallery.addEventListener('focusin', stop);
        gallery.addEventListener('focusout', () => setTimeout(schedule, 0));
        document.addEventListener('visibilitychange', schedule);
        document.addEventListener('uisi:documentation-viewer', schedule);
        motion.addEventListener('change', () => { paused = motion.matches; schedule(); });
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(entries => { visible = entries[0].isIntersecting; schedule(); }, {threshold: .1}).observe(gallery);
        } else { visible = true; schedule(); }
    });
</script>
