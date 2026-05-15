<x-guest-layout>
<style>
    .ve-wrap {
        min-height: 100vh;
        background: #FAFAF8;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .ve-card {
        background: #FFFFFF;
        border: 1px solid #E9E9E9;
        border-radius: 24px;
        padding: 3rem 2.5rem;
        max-width: 480px;
        width: 100%;
        text-align: center;
    }
    .ve-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: #6B705C;
        display: block;
        margin-bottom: .4rem;
    }
    .ve-title {
        font-size: clamp(1.4rem, 4vw, 1.9rem);
        font-weight: 300;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #2F3526;
        margin: 0 0 .5rem;
    }
    .ve-title strong { font-weight: 900; color: #000; }
    .ve-divider {
        width: 36px; height: 1.5px;
        background: #2F3526;
        margin: 0 auto 1.75rem;
    }
    .ve-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        background: rgba(47,53,38,.06);
        display: flex; align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .ve-desc {
        font-size: 13px;
        color: #6B705C;
        line-height: 1.85;
        margin: 0 0 1.75rem;
    }
    .ve-desc strong { color: #2F3526; }
    .ve-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 28px;
        background: #2F3526;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
        text-decoration: none;
    }
    .ve-btn-primary:hover {
        background: #3b4430;
        transform: translateY(-1px);
    }
    .ve-divider-line {
        border: none;
        border-top: 1px solid #E9E9E9;
        margin: 1.5rem 0;
    }
    .ve-resend {
        font-size: 12px;
        color: #6B705C;
        margin: 0 0 .75rem;
    }
    .ve-btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 12px 24px;
        background: transparent;
        color: #2F3526;
        border: 1px solid rgba(47,53,38,.2);
        border-radius: 10px;
        font-family: inherit;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .24em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }
    .ve-btn-ghost:hover {
        background: #2F3526;
        color: #FFFFFF;
        border-color: #2F3526;
    }
    .ve-logout {
        display: block;
        margin-top: 1.25rem;
        font-size: 11px;
        color: rgba(47,53,38,.4);
        text-decoration: none;
        letter-spacing: .05em;
        transition: color .2s ease;
    }
    .ve-logout:hover { color: #2F3526; }
    .ve-status {
        font-size: 12px;
        color: #4a7c59;
        background: rgba(74,124,89,.08);
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 1rem;
    }
</style>

<div class="ve-wrap">
    <div class="ve-card">

        {{-- Icon --}}
        <div class="ve-icon">
            <svg width="28" height="28" fill="none" stroke="#2F3526" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        {{-- Header --}}
        <span class="ve-label">Satu Langkah Lagi</span>
        <h1 class="ve-title">Verifikasi <strong>Email</strong></h1>
        <div class="ve-divider"></div>

        {{-- Status sukses kirim ulang --}}
        @if (session('status') == 'verification-link-sent')
            <div class="ve-status">
                ✓ Link verifikasi baru telah dikirim ke email kamu.
            </div>
        @endif

        {{-- Deskripsi --}}
        <p class="ve-desc">
            Kami telah mengirim link verifikasi ke <strong>email kamu</strong>.<br>
            Silakan buka email dan klik tombol verifikasi untuk mengaktifkan akun kamu.
        </p>

        <hr class="ve-divider-line">

        {{-- Resend --}}
        <p class="ve-resend">Tidak menerima email? Cek folder <strong>Spam</strong> atau kirim ulang.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="ve-btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>
                </svg>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="ve-logout">Keluar dari akun</button>
        </form>

    </div>
</div>
</x-guest-layout>