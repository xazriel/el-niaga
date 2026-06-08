<section id="contact-section" class="py-24 md:py-32 scroll-mt-20 relative overflow-hidden" style="background:#FFFFFF;">
<style>
    /* ── CONTACT SECTION ── */
    .fc-label {
        display: block;
        font-size: 9px; font-weight: 700;
        letter-spacing: .3em; text-transform: uppercase;
        color: #6B705C; margin-bottom: .4rem;
    }
    .fc-title {
        font-size: clamp(1.7rem, 4vw, 2.6rem);
        font-weight: 300; letter-spacing: .08em;
        text-transform: uppercase; color: #2F3526;
        line-height: 1.2; margin: 0;
    }
    .fc-title strong { font-weight: 900; color: #000; }
    .fc-divider { width: 36px; height: 1.5px; background: #2F3526; }

    /* ── INFO PANEL ── */
    .fc-tagline {
        font-size: 13px; color: #6B705C;
        line-height: 1.85; margin: .5rem 0 2rem;
    }
    .fc-contact-list { display: flex; flex-direction: column; gap: 1.5rem; }
    .fc-contact-item { display: flex; align-items: flex-start; gap: 1rem; }
    .fc-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: rgba(47,53,38,.06);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background .3s ease, transform .3s ease;
    }
    .fc-contact-item:hover .fc-icon {
        background: #2F3526;
    }
    .fc-contact-item:hover .fc-icon svg {
        stroke: #FFFFFF;
    }
    .fc-detail-label {
        font-size: 8px; font-weight: 700;
        letter-spacing: .28em; text-transform: uppercase;
        color: #6B705C; margin: 0 0 3px;
    }
    .fc-detail-val {
        font-size: 13px; font-weight: 500;
        color: #000; margin: 0; line-height: 1.55;
    }

    /* ── SOCIAL BUTTONS ── */
    .fc-social { display: flex; flex-wrap: wrap; gap: .6rem; margin-top: 2rem; }
    .fc-social-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 99px;
        border: 1px solid rgba(47,53,38,.18);
        font-size: 9px; font-weight: 700;
        letter-spacing: .2em; text-transform: uppercase;
        color: #6B705C; text-decoration: none;
        transition: background .25s ease, color .25s ease, border-color .25s ease;
    }
    .fc-social-btn:hover {
        background: #2F3526; color: #FFFFFF; border-color: #2F3526;
    }

    /* ── CENTER LAYOUT (tanpa form) ── */
    .fc-center-wrap {
        display: flex;
        justify-content: center;
    }
    .fc-info-inner {
        max-width: 520px;
        width: 100%;
    }
</style>

<div class="max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20">

    {{-- Header --}}
    <div style="text-align:center; margin-bottom: 3rem;">
        <span class="fc-label">Reach Us</span>
        <h2 class="fc-title">Get In <strong>Touch</strong></h2>
        <div class="fc-divider" style="margin: 1.1rem auto 0;"></div>
    </div>

    <div class="fc-center-wrap">
        <div class="fc-info-inner">

            <span class="fc-label">Contact Information</span>
            <p class="fc-tagline">
                Have questions about products or collaborations?<br>
                Feel free to reach out to us anytime.
            </p>

            <div class="fc-contact-list">
                <div class="fc-contact-item">
                    <div class="fc-icon">
                        <svg width="18" height="18" fill="none" stroke="#2F3526" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="transition:stroke .3s ease">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="fc-detail-label">Our Studio</p>
                        <p class="fc-detail-val">Jalan pintu air 2, kav 6. Optima residence indonesia<br>Depok</p>
                    </div>
                </div>

                <div class="fc-contact-item">
                    <div class="fc-icon">
                        <svg width="18" height="18" fill="none" stroke="#2F3526" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="transition:stroke .3s ease">
                            <path d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="fc-detail-label">WhatsApp Only</p>
                        <p class="fc-detail-val">+62 822-6060-0099</p>
                    </div>
                </div>

                <div class="fc-contact-item">
                    <div class="fc-icon">
                        <svg width="18" height="18" fill="none" stroke="#2F3526" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="transition:stroke .3s ease">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="fc-detail-label">Email</p>
                        <p class="fc-detail-val">mgmt.ssubsclub@gmail.com</p>
                    </div>
                </div>
            </div>

            {{-- Social --}}
            <div class="fc-social">
                <a href="https://www.instagram.com/ssubsclubs.id" class="fc-social-btn">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    Instagram
                </a>
                <a href="https://www.tiktok.com/@ssubsclubs.id" class="fc-social-btn">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.3 6.3 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V8.69a8.24 8.24 0 004.84 1.56V6.79a4.85 4.85 0 01-1.08-.1z"/>
                    </svg>
                    TikTok
                </a>
            </div>

        </div>
    </div>

</div>
</section>