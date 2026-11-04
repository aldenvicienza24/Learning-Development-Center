<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            .auth-cms-page {
                min-height: 100vh;
                margin: 0;
                background:
                    radial-gradient(circle at 12% 10%, rgba(37, 99, 235, 0.08), transparent 28%),
                    radial-gradient(circle at 88% 90%, rgba(8, 20, 45, 0.07), transparent 30%),
                    var(--uisi-canvas);
                color: var(--uisi-ink);
                font-family: var(--uisi-font-family);
            }

            .auth-cms-wrap {
                box-sizing: border-box;
                display: flex;
                min-height: 100vh;
                align-items: center;
                justify-content: center;
                padding: 28px 16px;
            }

            .auth-cms-stack {
                width: 100%;
                max-width: 460px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border-width: 0;
            }
        </style>
    </head>
    <body class="auth-cms-page">
        <div class="auth-cms-wrap">
            <div class="auth-cms-stack">
                {{ $slot }}
            </div>
        </div>
        @fluxScripts
    </body>
</html>
