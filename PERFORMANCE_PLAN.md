# MotionEffects — PageSpeed Performance Plan

Goal: 80+ on both mobile and desktop PageSpeed Insights, **without CDN and without Nitropack**
(Nitropack is used on the client's other site, motionedits.com, but is off-limits here).

Baseline scores (from live motionedits.com, which currently runs Nitropack):
- Mobile: Performance 77 / Accessibility 84 / Best Practices 100 / SEO 100
- Desktop: Performance 97 / Accessibility 87 / Best Practices 100 / SEO 100

Target for motioneffects.com (no Nitropack, no CDN): **Mobile 90-97, Desktop 97-100.**
The biggest mobile penalty is almost certainly oversized images/video, so Phase 2 alone should
move mobile from the ~77 range into the high 80s/low 90s.

Status key: `[ ]` not started · `[~]` in progress · `[x]` done · `[!]` needs your decision

---

## Phase 1 — Cleanup (fastest wins, near-zero risk)

- [x] Confirm Nitropack plugin is already **inactive** (verified via `wp_options.active_plugins` —
      not present in the active list) and WP-Optimize is also installed but inactive.
- [x] Remove `wp-content/plugins/nitropack` (moved aside, not hard-deleted, in case anything
      references it — see "Where backups went" below).
- [x] Remove `wp-content/uploads/nitropack-logs/` (12KB of log residue).
- [x] Clean `wp-config.php`: removed the `/* Modified by NitroPack */` comment on `WP_CACHE`,
      set `WP_DEBUG` and `WP_DEBUG_LOG` to `false` for production.
- [x] Cleared `wp-content/debug.log`.
- [x] Stripped the stale **LiteSpeed Cache (LSCACHE)** block from `.htaccess` — no LiteSpeed
      plugin is installed, so these rules were dead weight. Kept the legitimate
      "Static asset caching" block (1yr images/fonts, 1mo css/js) and the WordPress rewrite block.
      Original `.htaccess` backed up first.
- [x] `header.php`: removed the dead **Universal Analytics** tag (`UA-141696682-1` — Google
      shut off UA data processing in July 2023, so this was firing for nothing) and the
      duplicate `gtag.js` script load. Consolidated to a single `gtag.js` load under the GA4 ID
      (`G-TQJ5NRPT4D`), keeping the **Google Ads conversion tag** (`AW-10860440795`) configured
      on it so ad-campaign tracking is unaffected. GTM is untouched.
- [!] **`wp-content/uploads/backup/` is 292MB** and mirrors the uploads folder structure
      (looks like originals kept by a prior image-optimization pass). Did **not** delete this —
      it's real data outside git, and worth a quick manual check before removal. Flagging for
      your go-ahead in Phase 2.
- [!] `wp-content/uploads/wpo/` (24KB, WP-Optimize's own cache dir) — harmless, left alone.

### Where backups went
Anything removed in Phase 1 that wasn't already tracked by git was moved (not deleted) to:
`/private/tmp/claude-501/-Applications-MAMP-htdocs-motioneffects/d3e8b828-e496-42d4-a7f6-5efae13b5f89/scratchpad/phase1-removed/`
Nothing destructive happened to the 292MB backup folder or any uploaded media.

---

## Phase 2 — Images & media (biggest point gain, mobile especially)

- [ ] Decide what to do with `wp-content/uploads/backup/` (292MB) — confirm safe to delete after
      spot-checking a few files against their live counterparts.
- [ ] Bulk-compress/resize the uploads library (1.4GB total): cap max dimensions to what's
      actually displayed, convert to WebP (AVIF as stretch goal). Recommended plugin (no CDN
      requirement): **ShortPixel**, **Imagify**, or **EWWW Image Optimizer**.
- [ ] Manually re-encode the worst outliers found: a 51MB jpg and a 20MB jpg
      (`2023/05/10-Video-Editing-Tips...jpg` and similar), plus several 7-9MB blog images.
- [ ] Fix the `fetchpriority="high"` + `loading="lazy"` contradiction on hero/poster images in
      `components/sections/posters.php` — only the true LCP image should get
      `fetchpriority="high"` + eager loading; everything else stays lazy.
- [ ] Add explicit `width`/`height` attributes on theme images to prevent layout shift (CLS).
- [ ] Re-encode the two self-hosted mp4s (14-19MB) to a smaller bitrate/resolution, add
      `preload="none"` + a poster image, and lazy-init the player instead of loading on page load.

## Phase 3 — CSS/JS

- [ ] Minify `style.css` (308KB) and `style-1920.css` (179KB); check whether `style-1920.css`
      duplicates rules already in `style.css`.
- [ ] Consolidate the scattered inline `<script>` blocks in section templates (e.g.
      `components/sections/posters.php`'s inline Slick init) into one deferred footer script.
- [ ] Conditionally enqueue Slick/AOS only on templates that actually use them, instead of
      loading them site-wide via `motionedits_scripts()` in `functions.php`.
- [ ] Add `defer`/`async` to enqueued scripts where dependency order allows.
- [ ] Audit MaxMegaMenu/ACF output for extra CSS/JS it auto-enqueues sitewide.

## Phase 4 — Server-level caching & compression

- [ ] Add `mod_deflate`/`mod_brotli` gzip rules to `.htaccess` (or enable at the MAMP/Apache
      server-config level) — no compression directives currently exist.
- [ ] Configure **WP-Optimize** (already installed, currently inactive) for full-page caching +
      minification, or switch to **WP Super Cache** / **Cache Enabler** — any non-Nitropack
      page-cache plugin works here.
- [ ] Verify the existing manual Expires/Cache-Control rules in `.htaccess` (kept from Phase 1)
      correctly cover fonts/CSS/JS.
- [ ] Enable PHP OPcache at the server level if not already on (MAMP setting).

## Phase 5 — Fonts/third-party

- [ ] Self-host any remaining Google Fonts with `font-display: swap`; preload only the primary
      weight actually used above the fold (several font preloads already exist in `header.php` —
      verify they're all actually used, drop the ones that aren't).
- [ ] Re-check `preconnect` hints in `header.php` (currently `assets.calendly.com`,
      `calendly.com`) — keep only origins still in active use.
- [ ] Review Wordfence firewall overhead — consider scheduled-scan-only mode to reduce
      per-request runtime cost.

## Phase 6 — Verification

- [ ] Re-run PageSpeed Insights (mobile + desktop) after each phase, track the delta here.
- [ ] Run WebPageTest on a real mid-tier Android profile as a second data point, since PSI
      mobile is a simulated throttled profile.

---

## Scorecard (fill in as we go)

| After phase | Mobile | Desktop | Notes |
|---|---|---|---|
| Baseline (motionedits.com w/ Nitropack) | 77 | 97 | reference only |
| Phase 1 | | | |
| Phase 2 | | | |
| Phase 3 | | | |
| Phase 4 | | | |
| Phase 5 | | | |
