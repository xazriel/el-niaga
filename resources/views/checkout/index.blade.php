<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Farhana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary:     #2F3526;
            --white:       #FFFFFF;
            --black:       #000000;
            --olive-tint:  #6B705C;
            --light-gray:  #E9E9E9;
            --bg:          #F5F5F3;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--black);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Focus resets ── */
        input:focus, textarea:focus, select:focus, button:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        input:-webkit-autofill {
            -webkit-text-fill-color: var(--black);
            -webkit-box-shadow: 0 0 0px 1000px #fff inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* ── Page load animation ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.55s cubic-bezier(.22,.68,0,1.2) both; }
        .delay-1 { animation-delay: .08s; }
        .delay-2 { animation-delay: .16s; }
        .delay-3 { animation-delay: .24s; }
        .delay-4 { animation-delay: .32s; }

        /* ── Header ── */
        .site-header {
            background: var(--primary);
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 0 48px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-back {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,.55);
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            text-decoration: none;
            transition: color .2s;
        }
        .header-back:hover { color: #fff; }
        .header-logo {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .45em;
            text-transform: uppercase;
            color: var(--white);
        }
        .header-spacer { width: 80px; }

        /* ── Progress bar ── */
        .progress-bar {
            background: var(--primary);
            padding: 0 48px 16px;
        }
        .progress-steps {
            display: flex;
            align-items: center;
            gap: 0;
            max-width: 480px;
            margin: 0 auto;
        }
        .progress-step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
        }
        .progress-step.active { color: rgba(255,255,255,.9); }
        .progress-step .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            flex-shrink: 0;
        }
        .progress-step.active .dot { background: var(--white); }
        .progress-line {
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.12);
            margin: 0 12px;
        }

        /* ── Main layout ── */
        .checkout-main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 24px 80px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 40px;
            align-items: start;
        }
        @media (max-width: 900px) {
            .checkout-main { grid-template-columns: 1fr; }
            .site-header, .progress-bar { padding-left: 20px; padding-right: 20px; }
        }

        /* ── Section ── */
        .section { margin-bottom: 36px; }
        .section-label {
            font-size: 9px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--olive-tint);
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--light-gray);
        }

        /* ── Address card ── */
        .addr-display {
            background: var(--white);
            border: 1px solid var(--light-gray);
            border-radius: 16px;
            padding: 22px 26px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            transition: border-color .25s, box-shadow .25s;
        }
        .addr-display:hover { border-color: var(--olive-tint); box-shadow: 0 4px 20px rgba(47,53,38,.06); }
        .addr-name { font-size: 13px; font-weight: 700; color: var(--black); margin-bottom: 4px; }
        .addr-meta { font-size: 11px; color: var(--olive-tint); line-height: 1.8; }
        .btn-change {
            font-size: 9px;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--primary);
            background: none;
            border: 1px solid rgba(47,53,38,.3);
            padding: 7px 16px;
            border-radius: 20px;
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
            font-family: inherit;
            flex-shrink: 0;
        }
        .btn-change:hover { background: var(--primary); color: var(--white); border-color: var(--primary); }

        /* ── Courier & Payment cards ── */
        .option-card {
            background: var(--white);
            border: 1px solid var(--light-gray);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, background .2s;
            margin-bottom: 10px;
        }
        .option-card:hover { border-color: var(--olive-tint); box-shadow: 0 3px 14px rgba(47,53,38,.07); }
        .option-card.selected {
            border-color: var(--primary);
            background: rgba(47,53,38,.03);
            box-shadow: 0 4px 18px rgba(47,53,38,.1);
        }
        .option-card-left { display: flex; align-items: center; gap: 16px; }
        .option-badge {
            width: 42px; height: 42px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .06em;
            color: var(--white);
            flex-shrink: 0;
        }
        .option-badge.light {
            background: var(--light-gray);
            color: var(--primary);
        }
        .option-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--black);
            margin-bottom: 2px;
        }
        .option-desc { font-size: 10px; color: var(--olive-tint); }
        .option-price { font-size: 13px; font-weight: 700; color: var(--black); margin-right: 12px; }

        /* Radio custom */
        .radio-ring {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 1.5px solid var(--light-gray);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: border-color .2s;
        }
        .option-card.selected .radio-ring { border-color: var(--primary); }
        .radio-fill {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0;
            transition: opacity .15s;
        }
        .option-card.selected .radio-fill { opacity: 1; }

        /* ── Empty courier state ── */
        .courier-empty {
            border: 1.5px dashed var(--light-gray);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            font-size: 10px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--olive-tint);
        }

        /* ── Sidebar ── */
        .sidebar {
            position: sticky;
            top: 88px;
        }
        .sidebar-card {
            background: var(--primary);
            border-radius: 24px;
            padding: 32px 28px;
            color: var(--white);
        }
        .sidebar-title {
            font-size: 9px;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: rgba(255,255,255,.45);
            margin-bottom: 24px;
            font-weight: 600;
        }

        /* Cart items */
        .cart-item { display: flex; gap: 14px; margin-bottom: 20px; }
        .cart-img {
            width: 52px; height: 64px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            opacity: .9;
        }
        .cart-info { flex: 1; }
        .cart-name {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--white);
            line-height: 1.4;
            margin-bottom: 4px;
        }
        .cart-variant { font-size: 10px; color: rgba(255,255,255,.45); }
        .cart-price {
            font-size: 11px;
            font-weight: 700;
            color: var(--white);
            margin-top: 6px;
        }

        /* Totals */
        .totals-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 11px;
        }
        .totals-row span:first-child { color: rgba(255,255,255,.5); }
        .totals-row span:last-child { color: rgba(255,255,255,.85); font-weight: 500; }
        .totals-divider {
            height: 1px;
            background: rgba(255,255,255,.1);
            margin: 16px 0;
        }
        .totals-grand {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }
        .totals-grand-label {
            font-size: 9px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255,255,255,.5);
        }
        .totals-grand-val {
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -.02em;
        }

        /* ── CTA Button ── */
        .btn-submit {
            width: 100%;
            margin-top: 28px;
            background: var(--white);
            color: var(--primary);
            border: none;
            padding: 16px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .25em;
            text-transform: uppercase;
            border-radius: 50px;
            cursor: pointer;
            transition: all .25s;
        }
        .btn-submit:hover:not(:disabled) {
            background: var(--black);
            color: var(--white);
        }
        .btn-submit:disabled {
            opacity: .3;
            cursor: not-allowed;
        }
        .btn-notice {
            font-size: 9px;
            color: rgba(255,255,255,.3);
            text-align: center;
            margin-top: 12px;
            line-height: 1.6;
            letter-spacing: .03em;
        }

        /* ── Scrollbar ── */
        .custom-scrollbar::-webkit-scrollbar { width: 2px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); }

        /* ── Skeleton ── */
        @keyframes shimmer {
            0%   { background-position: -600px 0; }
            100% { background-position: 600px 0; }
        }
        .skeleton {
            background: #e8e8e6;
            background-image: linear-gradient(to right, #e8e8e6 0%, #d8d8d5 20%, #e8e8e6 40%, #e8e8e6 100%);
            background-repeat: no-repeat;
            background-size: 800px 104px;
            animation: shimmer 1.4s infinite linear;
            border-radius: 4px;
        }

        /* ── Modal ── */
        .modal-overlay { display: none; }
        .modal-overlay.active { display: flex; }
        .modal-wrap {
            background: var(--white);
            width: 100%;
            max-width: 520px;
            border-radius: 24px;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 32px 80px rgba(0,0,0,.18);
        }
        .modal-header {
            background: var(--primary);
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        .modal-header-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--white);
        }
        .modal-close {
            color: rgba(255,255,255,.5);
            background: none;
            border: none;
            cursor: pointer;
            transition: color .2s;
            padding: 0;
        }
        .modal-close:hover { color: var(--white); }

        /* Addr list item */
        .addr-item {
            border: 1px solid var(--light-gray);
            border-radius: 14px;
            padding: 18px 20px;
            cursor: pointer;
            transition: border-color .2s, background .2s, box-shadow .2s;
            margin-bottom: 10px;
        }
        .addr-item:hover { border-color: var(--olive-tint); box-shadow: 0 3px 12px rgba(47,53,38,.07); }
        .addr-item-selected {
            border-color: var(--primary) !important;
            background: rgba(47,53,38,.04);
        }
        .addr-item-selected .addr-ring { border-color: var(--primary) !important; }
        .addr-item-selected .addr-dot  { opacity: 1 !important; }
        .addr-ring {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 1.5px solid var(--light-gray);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: border-color .2s;
        }
        .addr-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0;
            transition: opacity .15s;
        }
        .addr-badge {
            font-size: 8px;
            background: var(--primary);
            color: var(--white);
            padding: 2px 10px;
            border-radius: 20px;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .addr-rec-name  { font-size: 12px; font-weight: 700; color: var(--black); }
        .addr-rec-meta  { font-size: 10px; color: var(--olive-tint); margin-top: 3px; line-height: 1.6; }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--light-gray);
            flex-shrink: 0;
        }
        .btn-add-addr {
            width: 100%;
            border: 1.5px dashed var(--light-gray);
            background: none;
            color: var(--olive-tint);
            font-family: inherit;
            font-size: 9px;
            letter-spacing: .18em;
            text-transform: uppercase;
            padding: 14px;
            border-radius: 14px;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-add-addr:hover { border-color: var(--primary); color: var(--primary); }

        /* Form inputs (modal) */
        .form-group {
            background: var(--bg);
            border: 1px solid var(--light-gray);
            border-radius: 12px;
            padding: 12px 16px;
            transition: border-color .25s;
        }
        .form-group:focus-within { border-color: var(--primary); background: var(--white); }
        .form-lbl {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--olive-tint);
            margin-bottom: 4px;
            display: block;
            font-weight: 600;
        }
        .form-fld {
            width: 100%;
            background: transparent;
            border: none;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: var(--black);
            outline: none;
        }
        .form-fld::placeholder { color: #bbb; }

        /* Select2 inside modal */
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-selection--single {
            background: var(--bg);
            border: 1px solid var(--light-gray);
            border-radius: 12px;
            height: 52px;
            display: flex;
            align-items: center;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            transition: border-color .25s;
        }
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 52px;
            padding-left: 16px;
            color: var(--black);
            font-size: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px;
        }

        /* Modal body scroll */
        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }
        .modal-body.custom-scrollbar::-webkit-scrollbar { width: 2px; }
        .modal-body.custom-scrollbar::-webkit-scrollbar-thumb { background: var(--light-gray); }

        /* Toast */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            font-size: 11px;
            padding: 12px 24px;
            border-radius: 50px;
            letter-spacing: .03em;
        }
    </style>
</head>
<body>

@if(session('error'))
<div class="toast">{{ session('error') }}</div>
@endif

{{-- ══════════════════════════════════════════════════════
     MODAL: SELECT / ADD ADDRESS
══════════════════════════════════════════════════════ --}}
<div id="address-modal" class="modal-overlay fixed inset-0 z-[200] bg-black/60 items-center justify-center p-4">
    <div class="modal-wrap">

        <div class="modal-header">
            <span id="modal-title" class="modal-header-title">Select Delivery Address</span>
            <button type="button" onclick="closeAddressModal()" class="modal-close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Panel 1: List --}}
        <div id="panel-list" class="flex flex-col flex-1 overflow-hidden">
            <div class="modal-body custom-scrollbar">
                @forelse($addresses as $addr)
                <div class="addr-item {{ $addr->is_default ? 'addr-item-selected' : '' }}"
                    data-id="{{ $addr->id }}"
                    data-name="{{ $addr->recipient_name }}"
                    data-phone="{{ $addr->phone }}"
                    data-address="{{ $addr->address }}"
                    data-destination="{{ $addr->destination_id }}"
                    data-city="{{ $addr->city_name }}"
                    data-zip="{{ $addr->zip_code ?? $addr->postal_code }}"
                    data-label="{{ $addr->address_label ?? ($addr->city_name . ($addr->province_name ? ', '.$addr->province_name : '')) }}">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;">
                                <span class="addr-rec-name">{{ $addr->recipient_name }}</span>
                                @if($addr->is_default)
                                <span class="addr-badge">Default</span>
                                @endif
                            </div>
                            <div class="addr-rec-meta">
                                {{ $addr->phone }}<br>
                                {{ $addr->address }}<br>
                                {{ $addr->city_name }}{{ $addr->province_name ? ', '.$addr->province_name : '' }}
                            </div>
                            @if(!$addr->destination_id)
                            <p style="font-size:10px; color:#d97706; margin-top:6px;">⚠ Lokasi belum lengkap — perlu dipilih ulang.</p>
                            @endif
                        </div>
                        <div class="addr-ring {{ $addr->is_default ? 'border-[#2F3526]' : '' }}">
                            <div class="addr-dot {{ $addr->is_default ? '' : '' }}" style="{{ $addr->is_default ? 'opacity:1' : 'opacity:0' }}"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding:40px; text-align:center; font-size:11px; color:var(--olive-tint);">Belum ada alamat tersimpan.</div>
                @endforelse
            </div>
            <div class="modal-footer">
                <button type="button" onclick="showNewAddressPanel()" class="btn-add-addr">+ Add New Address</button>
            </div>
        </div>

        {{-- Panel 2: New address --}}
        <div id="panel-new" class="hidden flex-col flex-1 overflow-hidden">
            <div class="modal-body custom-scrollbar" style="display:flex; flex-direction:column; gap:14px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-lbl">Full Name</label>
                        <input type="text" id="new_name" class="form-fld" placeholder="Nama penerima">
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Phone</label>
                        <input type="text" id="new_phone" class="form-fld" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div>
                    <label class="form-lbl" style="margin-bottom:8px; display:block;">Sub-district, District, City</label>
                    <select id="new_destination" style="width:100%;">
                        <option value="">Search location...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-lbl">Detailed Address</label>
                    <textarea id="new_address" rows="3" class="form-fld" style="resize:none;" placeholder="Jalan, nomor rumah, RT/RW, dll."></textarea>
                </div>
                <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <input type="checkbox" id="new_is_default" style="accent-color:var(--primary); width:15px; height:15px;">
                    <span style="font-size:11px; color:var(--olive-tint);">Set as default address</span>
                </label>
            </div>
            <div class="modal-footer" style="display:flex; gap:10px;">
                <button type="button" onclick="showListPanel()"
                    style="flex:1; padding:14px; border:1px solid var(--light-gray); border-radius:50px; font-family:inherit; font-size:9px; letter-spacing:.15em; text-transform:uppercase; cursor:pointer; background:none; color:var(--olive-tint); transition:all .2s;">
                    ← Back
                </button>
                <button type="button" id="btn-save-new-addr"
                    style="flex:2; padding:14px; background:var(--primary); color:var(--white); border:none; border-radius:50px; font-family:inherit; font-size:9px; letter-spacing:.18em; text-transform:uppercase; font-weight:800; cursor:pointer; transition:background .2s;">
                    Save Address
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     HEADER
══════════════════════════════════════════════════════ --}}
<header class="site-header fade-up">
    <a href="{{ route('cart.index') }}" class="header-back">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Cart
    </a>
    <div class="header-logo">Farhana</div>
    <div class="header-spacer"></div>
</header>

{{-- Progress --}}
<div class="progress-bar fade-up delay-1">
    <div class="progress-steps">
        <div class="progress-step">
            <div class="dot"></div>
            Cart
        </div>
        <div class="progress-line"></div>
        <div class="progress-step active">
            <div class="dot"></div>
            Checkout
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="dot"></div>
            Confirm
        </div>
    </div>
</div>

<main>
    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        {{-- Hidden fields --}}
        <input type="hidden" name="email"            value="{{ $user->email }}">
        <input type="hidden" name="receiver_name"    id="hidden_receiver_name"    value="{{ $defaultAddr?->recipient_name ?? $user->name }}">
        <input type="hidden" name="receiver_phone"   id="hidden_receiver_phone"   value="{{ $defaultAddr?->phone ?? $user->phone }}">
        <input type="hidden" name="receiver_address" id="hidden_receiver_address" value="{{ $defaultAddr?->address ?? $user->address }}">
        <input type="hidden" name="destination_id"   id="hidden_destination_id"   value="{{ $defaultAddr?->destination_id ?? $user->destination_id }}">
        <input type="hidden" name="receiver_city"    id="hidden_receiver_city"    value="{{ $defaultAddr?->city_name }}">
        <input type="hidden" name="receiver_zip"     id="hidden_receiver_zip"     value="{{ $defaultAddr?->zip_code ?? $defaultAddr?->postal_code }}">
        <input type="hidden" name="shipping_cost"    id="hidden_shipping_cost">
        <input type="hidden" name="courier_name"     id="hidden_courier_name">
        <input type="hidden" name="service_code"     id="hidden_service_code">

        <div class="checkout-main">

            {{-- LEFT COLUMN --}}
            <div>

                {{-- ── 01 SHIPPING ADDRESS ── --}}
                <div class="section fade-up delay-2">
                    <div class="section-label">01 — Shipping Address</div>

                    @if($defaultAddr)
                    <div class="addr-display">
                        <div>
                            <div class="addr-name" id="display-name">{{ $defaultAddr->recipient_name }}</div>
                            <div class="addr-meta">
                                <span id="display-phone">{{ $defaultAddr->phone }}</span><br>
                                <span id="display-address">{{ $defaultAddr->address }}</span><br>
                                <span id="display-location">{{ $defaultAddr->address_label ?? ($defaultAddr->city_name . ($defaultAddr->province_name ? ', '.$defaultAddr->province_name : '')) }}</span>
                            </div>
                        </div>
                        <button type="button" onclick="openAddressModal()" class="btn-change">Change</button>
                    </div>
                    @else
                    <div class="addr-display" style="border-color:#fcd34d; background:#fffbeb;">
                        <div>
                            <div class="addr-name" id="display-name">{{ $user->name }}</div>
                            <div class="addr-meta">
                                <span id="display-phone">{{ $user->phone ?? '—' }}</span><br>
                                <span id="display-address" style="color:#d97706;">Belum ada alamat — klik Change untuk menambah.</span><br>
                                <span id="display-location"></span>
                            </div>
                        </div>
                        <button type="button" onclick="openAddressModal()" class="btn-change">Change</button>
                    </div>
                    @endif
                </div>

                {{-- ── 02 SHIPPING METHOD ── --}}
                <div class="section fade-up delay-3">
                    <div class="section-label">02 — Shipping Method</div>
                    <div id="courier_list">
                        <div class="courier-empty">Select location to calculate shipping</div>
                    </div>
                </div>

                {{-- ── 03 PAYMENT METHOD ── --}}
                <div class="section fade-up delay-4">
                    <div class="section-label">03 — Payment Method</div>
                    <div>
                        @php
                        $payments = [
                            ['id' => 'bca_va',     'name' => 'BCA Virtual Account',     'desc' => 'ATM / m-Banking / i-Banking BCA',     'icon' => 'BCA'],
                            ['id' => 'bni_va',     'name' => 'BNI Virtual Account',     'desc' => 'ATM / m-Banking / i-Banking BNI',     'icon' => 'BNI'],
                            ['id' => 'bri_va',     'name' => 'BRI Virtual Account',     'desc' => 'ATM / m-Banking / i-Banking BRI',     'icon' => 'BRI'],
                            ['id' => 'mandiri_va', 'name' => 'Mandiri Virtual Account', 'desc' => 'ATM / m-Banking / Livin Mandiri',     'icon' => 'MND'],
                            ['id' => 'permata_va', 'name' => 'Permata Virtual Account', 'desc' => 'ATM / m-Banking Permata',             'icon' => 'PRM'],
                            ['id' => 'gopay',      'name' => 'GoPay',                   'desc' => 'Aplikasi Gojek atau GoPay',           'icon' => 'GP'],
                            ['id' => 'shopeepay',  'name' => 'ShopeePay',               'desc' => 'Aplikasi Shopee',                     'icon' => 'SP'],
                            ['id' => 'qris',       'name' => 'QRIS',                    'desc' => 'Scan QR dari e-wallet atau m-banking', 'icon' => 'QR'],
                        ];
                        @endphp
                        @foreach($payments as $pay)
                        <label style="cursor:pointer; display:block;">
                            <input type="radio" name="payment_method" value="{{ $pay['id'] }}" class="hidden payment-radio" required>
                            <div class="option-card payment-card">
                                <div class="option-card-left">
                                    <div class="option-badge light">{{ $pay['icon'] }}</div>
                                    <div>
                                        <div class="option-title">{{ $pay['name'] }}</div>
                                        <div class="option-desc">{{ $pay['desc'] }}</div>
                                    </div>
                                </div>
                                <div class="radio-ring">
                                    <div class="radio-fill"></div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ── SIDEBAR ── --}}
            <aside class="sidebar fade-up delay-3">
                <div class="sidebar-card">
                    <div class="sidebar-title">Your Order</div>

                    <div class="custom-scrollbar" style="max-height:260px; overflow-y:auto; margin-bottom:24px; padding-right:4px;">
                        @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <img src="{{ asset('storage/' . $item['image']) }}" class="cart-img" alt="{{ $item['name'] }}">
                            <div class="cart-info">
                                <div class="cart-name">{{ $item['name'] }}</div>
                                <div class="cart-variant">{{ $item['size'] }} / {{ $item['color'] }} · Qty {{ $item['quantity'] }}</div>
                                <div class="cart-price">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="totals-divider"></div>

                    <div class="totals-row" style="margin-top:16px;">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="totals-row">
                        <span>Shipping</span>
                        <span id="shipping_cost_display" style="font-style:italic; color:rgba(255,255,255,.35); font-size:10px;">Select method</span>
                    </div>

                    <div class="totals-divider"></div>

                    <div class="totals-grand">
                        <span class="totals-grand-label">Total</span>
                        <span class="totals-grand-val" id="grand_total_display">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" id="btn-place-order" disabled class="btn-submit">
                        Complete Purchase
                    </button>
                    <p class="btn-notice">By proceeding, you agree to our Terms of Service and Privacy Policy.</p>
                </div>
            </aside>

        </div>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    const subtotal     = {{ $totalAmount }};
    const isProduction = {{ app()->isProduction() ? 'true' : 'false' }};
    const excludedServices = isProduction
        ? ['JTR250', 'JTR<150', 'JTR<130', 'PELIKAN', 'POPBOX', 'CTCSPS', 'SPS']
        : [];
    const serviceLabels = {
        'REG':    { label: 'Reguler',         desc: 'Estimasi 2–3 hari kerja' },
        'YES':    { label: 'YES (Esok Sampai)',desc: 'Estimasi 1 hari kerja' },
        'OKE':    { label: 'OKE (Ekonomis)',   desc: 'Estimasi 3–5 hari kerja' },
        'CTC':    { label: 'City Courier',     desc: 'Pengiriman dalam kota' },
        'CTCYES': { label: 'City Courier YES', desc: 'Estimasi 1 hari kerja dalam kota' },
        'CTCOKE': { label: 'City Courier OKE', desc: 'Ekonomis dalam kota' },
        'JTR':    { label: 'JNE Trucking',     desc: 'Estimasi 3–4 hari kerja' },
    };

    // ── Select2 ───────────────────────────────────────────
    function makeSelect2(selector, parentSelector) {
        const opts = {
            ajax: {
                url: "{{ route('api.locations') }}",
                dataType: 'json', delay: 250,
                data: p => ({ q: p.term }),
                processResults: data => ({
                    results: data.results.map(i => ({ id: i.id, text: i.text, city: i.city, zip_code: i.zip_code }))
                }),
                cache: true
            },
            placeholder: "Type sub-district or city...",
            minimumInputLength: 3
        };
        if (parentSelector) opts.dropdownParent = $(parentSelector);
        $(selector).select2(opts);
    }
    makeSelect2('#new_destination', '#address-modal');

    // ── Modal ─────────────────────────────────────────────
    window.openAddressModal = function () {
        showListPanel();
        $('#address-modal').addClass('active');
    };
    window.closeAddressModal = function () {
        $('#address-modal').removeClass('active');
    };
    $('#address-modal').on('click', function (e) {
        if ($(e.target).is('#address-modal')) closeAddressModal();
    });

    window.showListPanel = function () {
        $('#panel-list').removeClass('hidden').css('display', 'flex').addClass('flex-col overflow-hidden');
        $('#panel-new').addClass('hidden').css('display', 'none');
        $('#modal-title').text('Select Delivery Address');
    };
    window.showNewAddressPanel = function () {
        $('#panel-list').addClass('hidden').css('display', 'none');
        $('#panel-new').removeClass('hidden').css('display', 'flex').addClass('flex-col overflow-hidden');
        $('#modal-title').text('Add New Address');
        $('#new_name, #new_phone, #new_address').val('');
        $('#new_is_default').prop('checked', false);
        if ($('#new_destination').data('select2')) {
            $('#new_destination').val(null).trigger('change');
        }
    };

    // ── Select address ────────────────────────────────────
    $(document).on('click', '.addr-item', function () {
        const d = $(this).data();
        $('.addr-item').removeClass('addr-item-selected');
        $('.addr-dot').css('opacity', 0);
        $('.addr-ring').css('border-color', '');
        $(this).addClass('addr-item-selected');
        $(this).find('.addr-dot').css('opacity', 1);
        $(this).find('.addr-ring').css('border-color', 'var(--primary)');

        $('#hidden_receiver_name').val(d.name);
        $('#hidden_receiver_phone').val(d.phone);
        $('#hidden_receiver_address').val(d.address);
        $('#hidden_destination_id').val(d.destination || '');
        $('#hidden_receiver_city').val(d.city || '');
        $('#hidden_receiver_zip').val(d.zip || '');

        $('#display-name').text(d.name);
        $('#display-phone').text(d.phone);
        $('#display-address').text(d.address);
        $('#display-location').text(d.label || d.city);

        if (d.destination) {
            fetchShippingRates(d.destination);
        } else {
            $('#courier_list').html(`
                <div style="background:#fffbeb; border:1.5px solid #fcd34d; border-radius:4px; padding:20px; text-align:center;">
                    <p style="font-size:11px; color:#d97706;">Alamat ini belum punya kode lokasi JNE.</p>
                    <p style="font-size:10px; color:#b45309; margin-top:4px;">Pilih alamat lain atau tambah alamat baru.</p>
                </div>`);
        }

        setTimeout(() => closeAddressModal(), 250);
    });

    // ── Save new address ──────────────────────────────────
    $('#btn-save-new-addr').on('click', function () {
        const name   = $('#new_name').val().trim();
        const phone  = $('#new_phone').val().trim();
        const detail = $('#new_address').val().trim();
        const dest   = $('#new_destination').select2('data')[0];

        if (!name || !phone || !detail || !dest) {
            alert('Mohon lengkapi semua field alamat.');
            return;
        }

        const btn = $(this).text('Saving...').prop('disabled', true);

        $.ajax({
            url:  "{{ route('address.store') }}",
            type: 'POST',
            data: {
                _token:         "{{ csrf_token() }}",
                recipient_name: name,
                phone:          phone,
                address:        detail,
                destination_id: dest.id,
                address_label:  dest.text,
                city_name:      dest.city || '',
                zip_code:       dest.zip_code || '',
                postal_code:    dest.zip_code || '',
                is_default:     $('#new_is_default').is(':checked') ? 1 : 0,
                from_checkout:  1,
            },
            success: () => window.location.reload(),
            error: function (xhr) {
                btn.text('Save Address').prop('disabled', false);
                const errors = xhr.responseJSON?.errors;
                alert(errors ? Object.values(errors).flat().join('\n') : 'Gagal menyimpan alamat.');
            }
        });
    });

    // ── Init shipping ─────────────────────────────────────
    const initDest = $('#hidden_destination_id').val();
    if (initDest) fetchShippingRates(initDest);

    // ── Fetch shipping ────────────────────────────────────
    function fetchShippingRates(destId) {
        if (!destId) return;

        $('#hidden_shipping_cost, #hidden_courier_name, #hidden_service_code').val('');
        $('#shipping_cost_display').text('Calculating...').css({ fontStyle: 'italic', color: 'rgba(255,255,255,.35)', fontSize: '10px' });
        $('#grand_total_display').text('Rp ' + subtotal.toLocaleString('id-ID'));
        checkFormValidity();

        $('#courier_list').html(`
            <div class="skeleton" style="height:68px; margin-bottom:8px;"></div>
            <div class="skeleton" style="height:68px; margin-bottom:8px;"></div>
            <div class="skeleton" style="height:68px;"></div>`);

        $.post("{{ route('api.shipping') }}", {
            _token: "{{ csrf_token() }}",
            destination_id: destId,
            weight: 1
        }, function (res) {
            if (res.success && res.pricing?.length > 0) {
                const rates = excludedServices.length > 0
                    ? res.pricing.filter(c => !excludedServices.some(ex => c.service_code.includes(ex)))
                    : res.pricing;

                if (rates.length > 0) {
                    let html = '';
                    rates.forEach(c => {
                        const key  = Object.keys(serviceLabels).find(k => c.service_code.startsWith(k));
                        const info = key ? serviceLabels[key] : null;
                        const name = info ? info.label : c.courier_service_name;
                        const desc = info ? info.desc : (c.duration && c.duration !== 'null-null null' ? c.duration : 'Standard delivery');
                        html += `
                        <label style="cursor:pointer; display:block;">
                            <input type="radio" name="shipping_option" value="${c.price}"
                                data-courier="JNE ${c.courier_service_name}"
                                data-service-code="${c.service_code}"
                                class="hidden courier-radio">
                            <div class="option-card courier-card">
                                <div class="option-card-left">
                                    <div class="option-badge" style="border-radius:10px;">JNE</div>
                                    <div>
                                        <div class="option-title">${name}</div>
                                        <div class="option-desc">${desc}</div>
                                    </div>
                                </div>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span class="option-price">Rp ${c.price.toLocaleString('id-ID')}</span>
                                    <div class="radio-ring">
                                        <div class="radio-fill"></div>
                                    </div>
                                </div>
                            </div>
                        </label>`;
                    });
                    $('#courier_list').html(html);
                } else {
                    $('#courier_list').html('<div class="courier-empty" style="color:#f87171; border-color:#fca5a5;">Shipping unavailable for this area.</div>');
                }
            } else {
                $('#courier_list').html('<div class="courier-empty" style="color:#fb923c; border-color:#fed7aa;">Could not load shipping rates.</div>');
            }
            $('#shipping_cost_display').text('Select method');
        }).fail(() => {
            $('#courier_list').html('<div class="courier-empty" style="color:#f87171; border-color:#fca5a5;">Connection error. Please try again.</div>');
        });
    }

    // ── Pick courier ──────────────────────────────────────
    $(document).on('change', 'input[name="shipping_option"]', function () {
        const cost = parseInt($(this).val());
        $('#shipping_cost_display').text('Rp ' + cost.toLocaleString('id-ID'))
            .css({ fontStyle: 'normal', color: 'rgba(255,255,255,.85)', fontSize: '11px' });
        $('#grand_total_display').text('Rp ' + (subtotal + cost).toLocaleString('id-ID'));
        $('#hidden_shipping_cost').val(cost);
        $('#hidden_courier_name').val($(this).data('courier'));
        $('#hidden_service_code').val($(this).data('service-code'));

        $('.courier-card').removeClass('selected');
        $('.courier-card .radio-fill').css('opacity', 0);
        $(this).closest('label').find('.courier-card').addClass('selected');
        $(this).closest('label').find('.radio-fill').css('opacity', 1);
        checkFormValidity();
    });

    // ── Pick payment ──────────────────────────────────────
    $(document).on('change', 'input[name="payment_method"]', function () {
        $('.payment-card').removeClass('selected');
        $('.payment-card .radio-fill').css('opacity', 0);
        $(this).closest('label').find('.payment-card').addClass('selected');
        $(this).closest('label').find('.radio-fill').css('opacity', 1);
        checkFormValidity();
    });

    // ── Validity ──────────────────────────────────────────
    function checkFormValidity() {
        const ok = $('#hidden_destination_id').val() !== ''
                && $('#hidden_shipping_cost').val() !== ''
                && $('input[name="shipping_option"]:checked').length > 0
                && $('input[name="payment_method"]:checked').length > 0;

        $('#btn-place-order').prop('disabled', !ok);
    }
});
</script>
</body>
</html>