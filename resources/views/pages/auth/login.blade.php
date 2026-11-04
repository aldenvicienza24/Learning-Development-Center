<x-layouts::auth :title="__('Login CMS')">
    <style>
        .cms-login-card {
            width: 100%;
            overflow: hidden;
            border: 1px solid var(--uisi-blue-line);
            border-radius: 24px 0 24px 0;
            background: var(--uisi-surface);
            box-shadow: 0 24px 60px rgba(16, 28, 79, 0.14);
        }

        .cms-login-header {
            padding: 30px;
            background: linear-gradient(135deg, var(--uisi-navy) 0%, var(--uisi-blue) 100%);
            color: var(--uisi-on-brand);
        }

        .cms-login-kicker {
            margin: 0;
            color: var(--uisi-blue-soft);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .cms-login-title {
            margin: 8px 0 0;
            font-size: 28px;
            line-height: 1.15;
            font-weight: 900;
            letter-spacing: 0;
        }

        .cms-login-copy {
            margin: 12px 0 0;
            color: var(--uisi-blue-soft);
            font-size: 14px;
            line-height: 1.7;
        }

        .cms-login-body {
            padding: 30px;
        }

        .cms-login-form {
            display: grid;
            gap: 18px;
        }

        .cms-login-field {
            display: grid;
            gap: 8px;
            min-width: 0;
        }

        .cms-login-label {
            color: var(--uisi-ink);
            font-size: 13px;
            font-weight: 800;
        }

        .cms-login-input {
            box-sizing: border-box;
            display: block;
            width: 100%;
            height: 48px;
            margin: 0;
            border: 1px solid var(--uisi-control-line);
            border-radius: 12px;
            background: var(--uisi-blue-subtle);
            color: var(--uisi-ink);
            padding: 0 14px;
            font-size: 14px;
            line-height: 1.5;
            outline: none;
            appearance: none;
            transition: border-color 150ms ease, box-shadow 150ms ease, background-color 150ms ease;
        }

        .cms-login-input::placeholder {
            color: var(--uisi-muted);
            opacity: 1;
        }

        .cms-login-input:hover {
            border-color: var(--color-uisi-300);
        }

        .cms-login-input:focus {
            border-color: var(--uisi-blue);
            box-shadow: 0 0 0 3px rgba(59, 91, 255, 0.14);
        }

        .cms-login-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cms-login-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--uisi-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .cms-login-link {
            color: var(--uisi-blue);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .cms-login-link:hover {
            text-decoration: underline;
        }

        .cms-login-button {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 12px 0 12px 0;
            background: linear-gradient(135deg, var(--uisi-cobalt), var(--uisi-blue));
            color: var(--uisi-on-brand);
            cursor: pointer;
            font-size: 14px;
            font-weight: 900;
            transition: background 150ms ease, transform 150ms ease;
        }

        .cms-login-button:hover {
            background: var(--uisi-navy);
            transform: translateY(-1px);
        }

        .cms-login-error {
            color: var(--uisi-danger);
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 480px) {
            .cms-login-header,
            .cms-login-body {
                padding: 22px;
            }

            .cms-login-title {
                font-size: 24px;
            }
        }

        /* Autofill Overrides */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--uisi-blue-subtle) inset !important;
            -webkit-text-fill-color: var(--uisi-ink) !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <section class="cms-login-card" aria-label="Masuk ke CMS UISI">
        <header class="cms-login-header">
            <p class="cms-login-kicker">UISI CMS</p>
            <h1 class="cms-login-title">Masuk sebagai Admin</h1>
            <p class="cms-login-copy">Kelola gambar hero, program, peserta, dan pengaturan situs web melalui panel CMS.</p>
        </header>

        <div class="cms-login-body">
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="cms-login-form">
                @csrf

                <label class="cms-login-field">
                    <span class="cms-login-label">Email Admin</span>
                    <input
                        class="cms-login-input"
                        name="email"
                        value="{{ old('email') }}"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="Masukkan email admin"
                    >
                    @error('email')
                        <span class="cms-login-error">{{ $message }}</span>
                    @enderror
                </label>

                <label class="cms-login-field">
                    <span class="cms-login-label">Kata Sandi Admin</span>
                    <input
                        class="cms-login-input"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                    >
                    @error('password')
                        <span class="cms-login-error">{{ $message }}</span>
                    @enderror
                </label>

                <div class="cms-login-row">
                    <label class="cms-login-check">
                        <input name="remember" type="checkbox" @checked(old('remember'))>
                        <span>Ingat perangkat ini</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="cms-login-link" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                    @endif
                </div>

                <button type="submit" class="cms-login-button" data-test="login-button">
                    Masuk ke CMS
                </button>
            </form>
        </div>
    </section>
</x-layouts::auth>
