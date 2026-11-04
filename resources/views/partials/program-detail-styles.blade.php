<style>
    .public-program-detail {
        --detail-navy: var(--public-navy);
        --detail-blue: var(--public-blue);
        --detail-soft: var(--public-blue-soft);
        --detail-line: var(--public-line);
        --detail-muted: var(--public-muted);
        --detail-white: var(--public-surface);
        background: var(--public-canvas) !important;
    }
    .public-program-detail .detail-page { width: min(1160px, calc(100% - 48px)); margin: 0 auto; padding: 8px 0 40px; }
    .public-program-detail .detail-hero {
        position: relative;
        display: grid;
        grid-template-columns: 1.08fr 1fr;
        overflow: hidden;
        border: 1px solid var(--detail-line);
        border-radius: 22px;
        background: linear-gradient(135deg, var(--detail-navy), var(--public-navy-soft) 60%, var(--detail-blue));
        box-shadow: 0 12px 28px rgb(16 28 79 / 8%);
    }
    .public-program-detail .detail-hero-copy { position: relative; isolation: isolate; display: flex; flex-direction: column; justify-content: center; min-width: 0; padding: 28px 32px; overflow: hidden; }
    .public-program-detail .detail-hero-copy::before,
    .public-program-detail .detail-hero-copy::after { position: absolute; z-index: -1; pointer-events: none; content: ''; }
    .public-program-detail .detail-hero-copy::before { top: -112px; right: -72px; width: 336px; height: 336px; border: 1px solid rgb(255 255 255 / 12%); border-radius: 50%; box-shadow: 0 0 0 34px rgb(255 255 255 / 3.5%), 0 0 0 74px rgb(255 255 255 / 2.5%); }
    .public-program-detail .detail-hero-copy::after { bottom: -138px; left: -100px; width: 180px; height: 180px; border: 1px solid rgb(255 255 255 / 8%); border-radius: 50%; box-shadow: 0 0 0 24px rgb(255 255 255 / 2%); }
    .public-program-detail .detail-hero-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 10px 14px; }
    .public-program-detail .detail-category { color: var(--detail-white); font-size: 12px; font-weight: 650; }
    .public-program-detail .detail-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px; border: 1px solid rgb(255 255 255 / 24%); border-radius: 999px; background: var(--detail-soft); color: var(--detail-navy); font-size: 10px; font-weight: 600; line-height: 1.5; }
    .public-program-detail .detail-status::before { width: 5px; height: 5px; flex: 0 0 5px; border-radius: 50%; background: var(--detail-blue); content: ''; }
    .public-program-detail .detail-status.is-closed { background: var(--detail-white); color: var(--detail-muted); }
    .public-program-detail .detail-status.is-closed::before { background: var(--detail-muted); }
    .public-program-detail .detail-title { margin: 16px 0 0; color: var(--detail-white); font-size: clamp(25px, 2.7vw, 32px); font-weight: 800; line-height: 1.2; letter-spacing: -.035em; overflow-wrap: anywhere; text-wrap: balance; }
    .public-program-detail .detail-subtitle { margin: 14px 0 0; color: var(--detail-soft); font-size: 13px; line-height: 1.75; }
    .public-program-detail .detail-organizer { display: flex; align-items: center; gap: 10px; margin: 20px 0 0; padding-top: 16px; border-top: 1px solid rgb(255 255 255 / 18%); color: var(--detail-soft); font-size: 11px; line-height: 1.7; }
    .public-program-detail .detail-organizer svg { box-sizing: content-box; width: 17px; height: 17px; flex: 0 0 17px; padding: 8px; border: 1px solid rgb(255 255 255 / 24%); border-radius: 50%; background: rgb(255 255 255 / 6%); }
    .public-program-detail .detail-hero-media { position: relative; isolation: isolate; display: grid; place-items: center; min-width: 0; min-height: 226px; margin: 12px 12px 12px 0; overflow: hidden; border: 1px solid rgb(255 255 255 / 22%); border-radius: 14px; background: var(--detail-soft); }
    .public-program-detail .detail-hero-media img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .public-program-detail .detail-image-empty { max-width: 240px; padding: 24px; color: var(--detail-white); font-size: 11px; line-height: 1.6; text-align: center; }
    .public-program-detail .detail-image-empty svg { display: block; width: 50px; height: 50px; margin: 0 auto 12px; padding: 13px; border: 1px solid rgb(255 255 255 / 24%); border-radius: 50%; background: rgb(255 255 255 / 8%); }
    .public-program-detail .detail-hero-media figcaption { position: absolute; right: 12px; bottom: 12px; left: 12px; padding: 9px 12px; border: 1px solid var(--detail-line); border-radius: 10px; background: var(--detail-white); color: var(--detail-navy); font-size: 11px; font-weight: 600; line-height: 1.5; }
    .public-program-detail .detail-hero-media.is-unavailable { background: rgb(255 255 255 / 5%); }
    .public-program-detail .detail-hero-media.is-unavailable::before { position: absolute; z-index: -1; top: -96px; right: -76px; width: 240px; height: 240px; border: 1px solid rgb(255 255 255 / 12%); border-radius: 50%; box-shadow: 0 0 0 30px rgb(255 255 255 / 3.5%), 0 0 0 62px rgb(255 255 255 / 2.5%); content: ''; pointer-events: none; }
    .public-program-detail .detail-hero-media.is-unavailable figcaption { display: none; }
    .public-program-detail .detail-layout { display: grid; grid-template-columns: minmax(0,1fr) 304px; align-items: start; gap: 24px; margin-top: 24px; }
    .public-program-detail .detail-content { min-width: 0; }
    .public-program-detail .detail-about { overflow: hidden; border: 1px solid var(--detail-line); border-radius: 18px; background: var(--detail-white); }
    .public-program-detail .detail-section-title { display: flex; align-items: center; gap: 12px; min-width: 0; margin: 0; color: var(--detail-navy); font-size: 18px; font-weight: 750; letter-spacing: -.02em; line-height: 1.45; }
    .public-program-detail .detail-about > .detail-section-title { position: relative; isolation: isolate; overflow: hidden; padding: 14px 20px; border-bottom: 1px solid var(--detail-line); background: linear-gradient(110deg, var(--detail-soft), var(--detail-white) 75%); }
    .public-program-detail .detail-about > .detail-section-title::after { position: absolute; z-index: -1; top: -100px; right: -28px; width: 170px; height: 170px; border: 1px solid var(--detail-line); border-radius: 50%; box-shadow: 0 0 0 22px rgb(29 78 216 / 3%), 0 0 0 46px rgb(29 78 216 / 2%); content: ''; pointer-events: none; }
    .public-program-detail .detail-about-body { padding: 16px 20px 20px; }
    .public-program-detail .detail-about-body > .detail-prose { margin: 0; max-width: 72ch; }
    .public-program-detail .detail-heading-icon { display: grid; place-items: center; flex: 0 0 32px; width: 32px; height: 32px; border: 1px solid var(--detail-blue); border-radius: 50%; background: var(--detail-blue); color: var(--detail-white); box-shadow: 0 0 0 4px var(--detail-soft); }
    .public-program-detail .detail-heading-icon svg { width: 17px; height: 17px; }
    .public-program-detail .detail-section-heading { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px 12px; padding: 0 0 16px; border-bottom: 1px solid var(--detail-line); }
    .public-program-detail .detail-trainer-count { padding: 5px 10px; border: 1px solid var(--detail-line); border-radius: 999px; color: var(--detail-navy); font-size: 10px; line-height: 1.6; background: var(--detail-white); }
    .public-program-detail .detail-prose { margin: 14px 0 0; color: var(--detail-muted); font-size: 13px; line-height: 1.85; white-space: pre-line; overflow-wrap: anywhere; }
    .public-program-detail .detail-material { position: relative; overflow: hidden; margin-top: 18px; padding: 16px 18px; border: 1px solid var(--detail-line); border-radius: 12px; background: var(--public-blue-subtle); }
    .public-program-detail .detail-material::after { position: absolute; top: -32px; right: -32px; width: 64px; height: 64px; border: 1px solid var(--detail-line); border-radius: 50%; background: var(--detail-soft); box-shadow: 0 0 0 14px rgb(29 78 216 / 2.5%); content: ''; pointer-events: none; }
    .public-program-detail .detail-material h3 { margin: 0; padding-right: 16px; color: var(--detail-navy); font-size: 13px; font-weight: 600; }
    .public-program-detail .detail-material .detail-prose { margin-top: 10px; }
    .public-program-detail .detail-document-link,
    .public-program-detail .detail-trainer-cv { display: inline-flex; align-items: center; gap: 8px; min-height: 44px; color: var(--detail-blue); font-size: 12px; font-weight: 600; text-decoration: underline; text-underline-offset: 4px; }
    .public-program-detail .detail-document-link { display: inline-grid; grid-template-columns: 36px minmax(0,1fr) 28px; align-items: center; gap: 12px; width: fit-content; max-width: 100%; min-height: 58px; margin-top: 16px; padding: 10px 12px; border: 1px solid var(--detail-line); border-radius: 12px; background: var(--public-blue-subtle); text-decoration: none; transition: background-color 150ms ease, border-color 150ms ease; }
    .public-program-detail .detail-document-link > span:nth-child(2) { min-width: 0; overflow-wrap: anywhere; }
    .public-program-detail .detail-document-icon { display: grid; place-items: center; width: 36px; height: 36px; border: 1px solid var(--detail-line); border-radius: 50%; background: var(--detail-white); transition: background-color 180ms ease, border-color 180ms ease, color 180ms ease, transform 180ms ease; }
    .public-program-detail .detail-document-icon svg { width: 18px; height: 18px; animation: detail-syllabus-ready 650ms ease-out 150ms both; }
    .public-program-detail .detail-document-arrow { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 50%; background: var(--detail-soft); }
    .public-program-detail .detail-document-arrow svg { width: 14px; height: 14px; transition: transform 180ms ease; }
    .public-program-detail .detail-document-link:is(:hover, :focus, :active) .detail-document-icon { border-color: var(--detail-blue); background: var(--detail-blue); color: var(--detail-white); }
    .public-program-detail .detail-document-link:is(:hover, :focus, :active) .detail-document-download-arrow { animation: detail-syllabus-download 720ms ease-in-out 2; }
    .public-program-detail .detail-document-link:is(:hover, :focus-visible) .detail-document-arrow { background: var(--detail-blue); color: var(--detail-white); }
    .public-program-detail .detail-document-link:is(:hover, :focus-visible) .detail-document-arrow svg { transform: translate(1px, -1px); }
    .public-program-detail .detail-document-link:active .detail-document-icon { transform: scale(.92); }
    @keyframes detail-syllabus-ready {
        0% { transform: translateY(-3px); opacity: 0; }
        45% { opacity: 1; }
        70% { transform: translateY(2px); }
        100% { transform: translateY(0); opacity: 1; }
    }
    @keyframes detail-syllabus-download {
        0%, 100% { transform: translateY(0); opacity: 1; }
        30% { transform: translateY(2px); opacity: 1; }
        48% { transform: translateY(5px); opacity: 0; }
        49% { transform: translateY(-4px); opacity: 0; }
        80% { transform: translateY(0); opacity: 1; }
    }
    @media (prefers-reduced-motion: reduce) {
        .public-program-detail .detail-document-icon,
        .public-program-detail .detail-document-icon svg,
        .public-program-detail .detail-document-download-arrow,
        .public-program-detail .detail-document-arrow svg { animation: none !important; transition: none !important; transform: none !important; }
    }
    .public-program-detail .detail-trainers { margin-top: 20px; border: 1px solid var(--detail-line); border-radius: 18px; background: var(--detail-white); }
    .public-program-detail .detail-trainers > .detail-section-heading { position: relative; isolation: isolate; overflow: hidden; gap: 12px; padding: 16px 20px; border-radius: 17px 17px 0 0; background: linear-gradient(110deg, var(--detail-soft), var(--detail-white) 75%); }
    .public-program-detail .detail-trainers > .detail-section-heading::after { position: absolute; z-index: -1; top: -110px; right: -20px; width: 180px; height: 180px; border: 1px solid var(--detail-line); border-radius: 50%; box-shadow: 0 0 0 22px rgb(29 78 216 / 3%), 0 0 0 46px rgb(29 78 216 / 2%); content: ''; pointer-events: none; }
    .public-program-detail .detail-trainer-list { display: grid; grid-template-columns: repeat(auto-fit,minmax(min(100%,280px),1fr)); gap: 12px; padding: 20px; }
    .public-program-detail .detail-trainer { --trainer-ring: var(--detail-soft); --trainer-photo-scale: 1; display: grid; grid-template-columns: 64px minmax(0,1fr); align-items: start; gap: 14px; min-width: 0; padding: 16px; border: 1px solid var(--detail-line); border-radius: 14px; background: linear-gradient(145deg, var(--public-blue-subtle), var(--detail-white) 65%); transition: border-color 180ms ease; }
    .public-program-detail .detail-trainer-photo { display: grid; place-items: center; width: 64px; height: 64px; overflow: hidden; border: 3px solid var(--detail-white); outline: 1px solid var(--detail-line); border-radius: 50%; background: var(--detail-soft); color: var(--detail-navy); box-shadow: 0 0 0 5px var(--trainer-ring); transition: box-shadow 220ms ease; }
    .public-program-detail .detail-trainer-photo img { width: 100%; height: 100%; object-fit: cover; transform: scale(var(--trainer-photo-scale)); transition: transform 260ms cubic-bezier(.2,.8,.2,1); }
    .public-program-detail .detail-trainer-initial { font-size: 22px; font-weight: 700; }
    .public-program-detail .detail-trainer-copy { min-width: 0; }
    .public-program-detail .detail-trainer h3 { margin: 0; color: var(--detail-navy); font-size: 16px; font-weight: 750; line-height: 1.5; overflow-wrap: anywhere; }
    .public-program-detail .detail-trainer-description { margin: 5px 0 0; color: var(--detail-muted); font-size: 12px; line-height: 1.75; white-space: pre-line; overflow-wrap: anywhere; }
    .public-program-detail .detail-trainer-cv { justify-content: center; gap: 8px; width: fit-content; max-width: 100%; margin-top: 12px; padding: 6px 8px 6px 12px; border: 1px solid var(--detail-line); border-radius: 999px; background: var(--detail-soft); font-size: 11px; line-height: 1.5; text-decoration: none; transition: background-color 150ms ease, border-color 150ms ease, color 150ms ease; }
    .public-program-detail .detail-trainer-cv > span:first-child { min-width: 0; overflow-wrap: anywhere; }
    .public-program-detail .detail-trainer-cv-icon { display: grid; place-items: center; flex: 0 0 24px; width: 24px; height: 24px; border-radius: 50%; background: var(--detail-white); color: var(--detail-blue); }
    .public-program-detail .detail-trainer-cv svg { width: 13px; height: 13px; transition: transform 180ms ease; }
    .public-program-detail .detail-trainers .detail-trainer-cv:is(:hover, :focus-visible) { border-color: var(--detail-blue); background: var(--detail-blue); color: var(--detail-white); }
    .public-program-detail .detail-trainer-cv:is(:hover, :focus-visible) svg { transform: translate(1px,-1px); }
    .public-program-detail .detail-trainer:focus-within { --trainer-ring: var(--detail-line); --trainer-photo-scale: 1.04; border-color: var(--detail-blue); }
    @media (hover: hover) and (pointer: fine) {
        .public-program-detail .detail-trainer:hover { --trainer-ring: var(--detail-line); --trainer-photo-scale: 1.04; border-color: var(--detail-blue); }
    }
    @media (prefers-reduced-motion: reduce) {
        .public-program-detail .detail-trainer,
        .public-program-detail .detail-trainer-photo,
        .public-program-detail .detail-trainer-photo img,
        .public-program-detail .detail-trainer-cv,
        .public-program-detail .detail-trainer-cv svg { transition: none !important; transform: none !important; }
    }
    .public-program-detail .detail-registration { overflow: hidden; border: 1px solid var(--detail-line); border-radius: 20px; background: var(--detail-white); box-shadow: 0 10px 28px rgb(16 28 79 / 8%); }
    .public-program-detail .detail-registration-heading { position: relative; isolation: isolate; display: flex; align-items: center; gap: 10px; overflow: hidden; padding: 16px; border-bottom: 3px solid var(--detail-blue); background: linear-gradient(115deg, var(--detail-navy), var(--public-navy-soft)); }
    .public-program-detail .detail-registration-heading::after { position: absolute; z-index: -1; top: -90px; right: -32px; width: 160px; height: 160px; border: 1px solid rgb(255 255 255 / 12%); border-radius: 50%; box-shadow: 0 0 0 24px rgb(255 255 255 / 3.5%), 0 0 0 48px rgb(255 255 255 / 2.5%); content: ''; pointer-events: none; }
    .public-program-detail .detail-registration-icon { display: grid; place-items: center; flex: 0 0 30px; width: 30px; height: 30px; border: 1px solid rgb(255 255 255 / 24%); border-radius: 50%; background: rgb(255 255 255 / 8%); color: var(--detail-white); }
    .public-program-detail .detail-registration-icon svg { width: 16px; height: 16px; }
    .public-program-detail .detail-registration-heading h2 { margin: 0; color: var(--detail-white); font-size: 14px; font-weight: 700; line-height: 1.5; }
    .public-program-detail .detail-registration-body { padding: 16px; }
    .public-program-detail .detail-fee { position: relative; isolation: isolate; overflow: hidden; padding: 17px 16px; border: 1px solid var(--detail-line); border-radius: 14px; background: linear-gradient(125deg, var(--detail-soft), var(--public-blue-subtle)); }
    .public-program-detail .detail-fee::after { position: absolute; z-index: -1; top: -42px; right: -30px; width: 110px; height: 110px; border: 1px solid var(--detail-line); border-radius: 50%; box-shadow: 0 0 0 20px rgb(29 78 216 / 3%), 0 0 0 40px rgb(29 78 216 / 2%); content: ''; pointer-events: none; }
    .public-program-detail .detail-fee > span { display: block; color: var(--detail-muted); font-size: 11px; line-height: 1.5; }
    .public-program-detail .detail-fee strong { display: block; margin-top: 5px; color: var(--detail-navy); font-size: 26px; font-weight: 800; letter-spacing: -.035em; line-height: 1.3; overflow-wrap: anywhere; }
    .public-program-detail .detail-facts { margin: 8px 0 14px; }
    .public-program-detail .detail-facts > div { display: grid; grid-template-columns: 98px minmax(0,1fr); align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--detail-line); font-size: 12px; line-height: 1.6; }
    .public-program-detail .detail-facts > div:last-child { border-bottom: 0; }
    .public-program-detail .detail-facts dt { display: flex; align-items: center; gap: 7px; color: var(--detail-muted); }
    .public-program-detail .detail-facts dt svg { box-sizing: content-box; width: 14px; height: 14px; flex: 0 0 14px; padding: 6px; border-radius: 50%; background: var(--detail-soft); color: var(--detail-blue); }
    .public-program-detail .detail-facts dd { margin: 0; color: var(--detail-navy); font-weight: 550; text-align: right; overflow-wrap: anywhere; }
    .public-program-detail .detail-facts > div:last-child dd { justify-self: end; padding: 3px 8px; border: 1px solid var(--detail-line); border-radius: 999px; background: var(--public-blue-subtle); font-size: 11px; font-weight: 600; }
    .public-program-detail .detail-action { display: flex; align-items: center; justify-content: center; gap: 10px; min-height: 44px; padding: 8px 12px 8px 18px; border: 1px solid var(--detail-blue); border-radius: 999px; background: linear-gradient(115deg, var(--detail-blue), var(--public-accent)); color: var(--detail-white); font-size: 12px; font-weight: 700; line-height: 1.5; text-align: center; text-decoration: none; box-shadow: 0 6px 14px rgb(29 78 216 / 16%); }
    .public-program-detail a.detail-action:hover { border-color: var(--detail-navy); background: var(--detail-navy); }
    .public-program-detail .detail-action svg { width: 26px; height: 26px; flex: 0 0 26px; padding: 5px; border-radius: 50%; background: rgb(255 255 255 / 16%); }
    .public-program-detail .detail-registration-state { padding: 12px; border: 1px solid var(--detail-line); border-radius: 14px; background: var(--public-blue-subtle); }
    .public-program-detail .detail-state-heading { display: flex; align-items: center; gap: 8px; color: var(--detail-navy); font-size: 12px; font-weight: 700; line-height: 1.5; }
    .public-program-detail .detail-state-icon { display: grid; place-items: center; width: 24px; height: 24px; flex: 0 0 24px; border-radius: 50%; background: var(--detail-soft); color: var(--detail-blue); }
    .public-program-detail .detail-state-icon svg { width: 14px; height: 14px; }
    .public-program-detail .detail-opening-date { display: flex; align-items: baseline; justify-content: space-between; flex-wrap: wrap; gap: 4px 10px; margin-top: 10px; color: var(--detail-muted); font-size: 11px; line-height: 1.6; }
    .public-program-detail .detail-opening-date time { color: var(--detail-navy); font-weight: 650; }
    .public-program-detail .detail-countdown { margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--detail-line); }
    .public-program-detail .detail-countdown-label { margin: 0 0 8px; color: var(--detail-muted); font-size: 10px; line-height: 1.5; }
    .public-program-detail .detail-countdown-units { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 6px; }
    .public-program-detail .detail-countdown-units[hidden] { display: none; }
    .public-program-detail .detail-countdown-unit { display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 0; gap: 2px; padding: 8px 3px; border: 1px solid var(--detail-line); border-radius: 9px; background: var(--detail-white); }
    .public-program-detail .detail-countdown-unit strong { color: var(--detail-navy); font-size: 18px; font-weight: 750; line-height: 1.2; font-variant-numeric: tabular-nums; overflow-wrap: anywhere; }
    .public-program-detail .detail-countdown-unit > span { color: var(--detail-muted); font-size: 9px; line-height: 1.4; }
    .public-program-detail .detail-countdown-expired { margin: 0; color: var(--detail-muted); font-size: 11px; line-height: 1.6; }
    .public-program-detail .detail-footer { display: flex; margin-top: 28px; padding-top: 22px; border-top: 1px solid var(--detail-line); }
    .public-program-detail .detail-back { display: inline-flex; align-items: center; gap: 8px; min-height: 44px; padding: 0 14px; border: 1px solid var(--detail-line); border-radius: 8px; background: var(--detail-white); color: var(--detail-navy); font-size: 12px; font-weight: 550; text-decoration: none; }
    .public-program-detail .detail-back svg { width: 16px; height: 16px; }
    .public-program-detail .detail-back:hover,
    .public-program-detail .detail-trainer-cv:hover,
    .public-program-detail .detail-document-link:hover { border-color: var(--detail-blue); background: var(--detail-soft); }
    .public-program-detail .detail-page a:focus-visible { outline: 3px solid var(--detail-blue); outline-offset: 4px; }
    @media (max-width: 900px) {
        .public-program-detail .detail-layout { grid-template-columns: minmax(0,1fr) 290px; gap: 20px; }
        .public-program-detail .detail-hero-copy { padding: 26px; }
    }
    @media (max-width: 720px) {
        .public-program-detail .detail-page { width: calc(100% - 24px); padding-bottom: 32px; }
        .public-program-detail .detail-hero { grid-template-columns: minmax(0,1fr); border-radius: 18px; }
        .public-program-detail .detail-hero-copy { padding: 22px 20px; }
        .public-program-detail .detail-hero-copy::before { top: -85px; right: -75px; width: 240px; height: 240px; box-shadow: 0 0 0 24px rgb(255 255 255 / 3.5%), 0 0 0 52px rgb(255 255 255 / 2.5%); }
        .public-program-detail .detail-hero-copy::after { bottom: -144px; }
        .public-program-detail .detail-title { font-size: 26px; }
        .public-program-detail .detail-hero-media { min-height: 180px; margin: 0 10px 10px; border-radius: 12px; }
        .public-program-detail .detail-hero-media figcaption { right: 12px; bottom: 12px; left: 12px; font-size: 10px; }
        .public-program-detail .detail-hero-media.is-unavailable { min-height: 110px; }
        .public-program-detail .detail-image-empty { display: flex; align-items: center; gap: 12px; max-width: none; padding: 16px; text-align: left; }
        .public-program-detail .detail-image-empty[hidden] { display: none; }
        .public-program-detail .detail-image-empty svg { flex: 0 0 40px; width: 40px; height: 40px; margin: 0; padding: 10px; }
        .public-program-detail .detail-layout { grid-template-columns: minmax(0,1fr); gap: 24px; margin-top: 24px; }
        .public-program-detail .detail-about { border-radius: 16px; }
        .public-program-detail .detail-about > .detail-section-title { padding: 14px 16px; }
        .public-program-detail .detail-about-body { padding: 16px; }
        .public-program-detail .detail-document-link { grid-template-columns: 32px minmax(0,1fr) 24px; gap: 10px; }
        .public-program-detail .detail-document-icon { width: 32px; height: 32px; }
        .public-program-detail .detail-document-arrow { width: 24px; height: 24px; }
        .public-program-detail .detail-trainers > .detail-section-heading { padding: 14px 16px; }
        .public-program-detail .detail-trainer-list { padding: 16px; }
        .public-program-detail .detail-section-title { font-size: 17px; }
    }
    @media (max-width: 380px) {
        .public-program-detail .detail-trainer { grid-template-columns: 52px minmax(0,1fr); gap: 12px; padding: 14px; }
        .public-program-detail .detail-trainer-photo { width: 52px; height: 52px; }
        .public-program-detail .detail-trainer-cv { gap: 6px; padding-inline: 9px; }
    }
</style>
