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

- [x] `wp-content/uploads/backup/` (292MB) moved out of the webroot to
      `/Applications/MAMP/htdocs/motioneffects-uploads-backup/uploads-backup-292mb` (sibling
      folder, matching this machine's existing `-backup` convention). Not deleted, not served.
- [x] Bulk-compressed/resized the uploads library: capped jpg/png over 2000px on either
      dimension down to 2000px via `sips -Z 2000 -s formatOptions 80`, generated a `.webp`
      sibling for every one of the 3,766 raster images via `cwebp -q 80`. CLI-only (no plugin,
      no API key/usage limits). Full `wp-content/uploads` was backed up first to
      `/Applications/MAMP/htdocs/motioneffects-uploads-backup/uploads-pre-phase2/` (1.1GB)
      before any in-place rewrite.
      **Bug found and fixed along the way:** the first pass named webp output by stripping the
      original extension (`foo.jpg` → `foo.webp`). On this machine's case-insensitive
      filesystem that collided whenever a `.jpg` and `.png` (or differently-cased duplicate)
      shared a basename — 175 such pairs/triplets (358 files total), each silently getting the
      *other* file's image as its "webp". Also discovered the site already had ~1,810
      pre-existing `.webp` siblings from when WP-Optimize was active, using an
      extension-inclusive convention (`foo.jpg.webp`). Deleted the ~3,755 buggy
      extension-stripped webp files and regenerated all 3,766 using the extension-inclusive
      convention instead (matches the pre-existing WP-Optimize naming, so there's one
      consistent scheme site-wide) — verified the colliding pairs now serve distinct, correct
      content. Also found and repaired 2 pre-existing corrupted PNGs
      (`our-work-4-1200x1800.png`, `our-work-2-1200x1800.png` — a libpng "invalid read length"
      error, present before this session touched anything) via a `sips` re-save so they could
      get a webp sibling too.
      Net result: uploads folder is 1.4GB → 1.1GB even after adding ~3,766 new webp files,
      because the dimension-capping on jpg/png originals saved more than the webp files added.
      Added a `.htaccess` rewrite (BEGIN WebP delivery block) so browsers sending
      `Accept: image/webp` transparently get the `.webp` sibling (`foo.jpg` → `foo.jpg.webp`)
      with a correct `Vary: Accept` header — verified live against the MAMP vhost, including
      the previously-colliding pairs.
- [ ] Manually re-encode the worst outliers found: a 51MB jpg and a 20MB jpg
      (`2023/05/10-Video-Editing-Tips...jpg` and similar), plus several 7-9MB blog images.
- [x] Fixed the `fetchpriority="high"` + `loading="lazy"` contradiction sitewide — found in 7
      places, not just posters.php: `posters.php` (now only the first slide gets
      `fetchpriority="high"`+eager, rest lazy with no priority hint), the `get_custom_logo`
      filter in `functions.php` (was `fetchpriority="high" loading="lazy"` on the site logo —
      the one place this really was the LCP element; now `loading="eager"`), and 5 looped
      card/slider templates (`culture_slider.php`, `testimonial.php`, `hero-lead-form.php`,
      `specialization.php`, `feature_videos.php`) where every repeated item incorrectly got
      `fetchpriority="high"` — stripped to plain `loading="lazy"` since these are never the
      single LCP candidate.
- [x] Added explicit `width`/`height` to the images that actually had CLS risk: `posters.php`
      poster-slider images, `our_team.php` member photos (added a new
      `motionedits_get_image_dimensions()` helper in `functions.php`, same pattern as the
      existing SVG-dimensions helper, since the ACF field there only returns a URL string), and
      the footer logo (`footer.php`, ACF image array already has width/height). Checked
      `testimonial.php`'s thumb and the various icon-wrapper templates (`grid_column.php`,
      `vision_section.php`, `our_services.php`, etc.) first — their containers already have a
      CSS-fixed height + `object-fit: cover`/`width:100%;height:100%`, so the browser doesn't
      need the image's intrinsic ratio to reserve space; adding width/height there would be
      cosmetic, not a real CLS fix, so left alone.
- [x] The two "self-hosted mp4s" (14-19MB) turned out to be **orphaned/unreferenced** — no
      `<video>` tag, ACF field, or DB row (post_content/postmeta/options) points at either
      `2019/03/video-gallery-plugin-with-responsive.mp4` or
      `2022/04/QuickFrame-Explainer-18-Sec-Cut-Down-HD-American-VO-1.mp4`. Per your call, left
      as-is — they aren't loaded by any page so they aren't hurting PageSpeed scores.

## Phase 3 — CSS/JS

- [x] Minified `style.css` → `style.min.css` (308KB → 262KB via `clean-css-cli`) and switched
      the theme's own enqueue to serve the minified file; `style.css` itself stays unminified
      and still has the real WP theme-header metadata WordPress reads, and is the file to
      hand-edit going forward (regenerate `style.min.css` after editing it). Also fixed a
      pre-existing typo found along the way: `z-index; 1;` (colon typo, silently no-op'd) in a
      `.slick-arrow.slick-prev` rule under `.grid_column_columns.Tools`.
      `style-1920.css` (179KB) turned out to be **completely unreferenced** — grepped the whole
      theme/plugins, no enqueue, no `@import`, nothing loads it. Left in place (not deleted)
      but didn't bother minifying a dead file.
      **Bigger find while wiring this up:** the active theme is actually a child theme
      (`motionedits-child`), whose `functions.php` was separately re-enqueuing the parent's
      *full, unminified* `style.css` under a different handle (`motionedits-parent-style`) -
      so the site was about to load the stylesheet **twice** (262KB minified + 308KB
      unminified) once my change landed. Fixed by having the child theme depend on the
      parent's own `motionedits-style` handle instead of re-declaring the src. Verified live:
      homepage now loads `style.min.css` exactly once.
- [x] Consolidated 8 of the 11 section templates with inline `<script>` blocks
      (`accordian.php`, `culture_slider.php`, `one_or_more_columns.php` [4 blocks],
      `hero-lead-form.php`, `our_services.php`, `posters.php`, `our_portfolios.php`,
      `testimonial.php`) into one file, `js/components-init.js`, enqueued once with
      `defer` + `in_footer`. Each block was already self-contained (own
      `jQuery(document).ready`/IIFE) and no-ops if its section isn't on the current page, so
      concatenating them is safe regardless of which sections any given page uses. Dropped one
      block (`hero-lead-form.php`) that was 100% commented-out dead code. Verified: all 8 PHP
      files still parse clean, the new JS passes `node --check`, and the homepage loads the
      script with `defer` and no PHP warnings/errors.
      Left inline (not moved): `grid_column.php`, `feature_videos.php`, `our_blogs.php` - these
      interpolate per-instance PHP values (section IDs, slide counts, an `admin-ajax.php` AJAX
      endpoint) directly into the script, which a shared static file can't see without first
      wiring those values through `data-*` attributes or `wp_localize_script`. Worth doing as a
      follow-up but it's a different, more careful change than the other 8.
- [x] Added `defer` (via WP 6.3+'s array `$args` form on `wp_enqueue_script`) to all of the
      theme's own enqueued scripts (bootstrap bundle, navigation, AOS, Slick, custom.js, the
      new components-init.js). WP automatically falls back to plain footer-loading for a script
      if any dependency isn't itself defer-safe, so this doesn't risk breaking load order.
- [!] Conditionally enqueuing Slick/AOS only on templates that use them: **assessed, not worth
      doing.** Both are used by the large majority of ACF flexible-content pages (AOS's
      `data-aos="fade-up"` shows up on nearly every section's title block; Slick appears in 8+
      of the section templates). Making the enqueue conditional would need to inspect a page's
      flexible-content layout before `wp_enqueue_scripts` fires, for a win that's close to zero
      on most pages since they'd load it anyway. Not pursued.
- [x] Audited MaxMegaMenu: it enqueues a 68KB CSS file and 20KB JS file, unavoidable since the
      mega menu is in the header on every page. The JS is already placed right before `</body>`
      (no `defer` attribute, but it's already positioned past virtually all other content, so
      the practical win from forcing `defer` via a `script_loader_tag` filter is small weighed
      against the risk of poking a third-party plugin's own loading assumptions). Left as-is.

## Phase 4 — Server-level caching & compression

**This phase is deployment notes only — nothing in this phase was applied to the local MAMP
setup.** Local MAMP has no page-level/response caching turned on and should stay that way for
development; everything below is scoped to whatever Apache/PHP setup the production server
actually runs, not this machine.

- [!] **Gzip compression (`mod_deflate`).** Checked locally: MAMP's Apache build has
      `mod_deflate.so` on disk but it's commented out in `httpd.conf` (not loaded), so right now
      *nothing* is gzip-compressing responses — confirmed via `curl -I`, no `Content-Encoding`
      header on CSS/JS/HTML. No `mod_brotli` module ships with this MAMP Apache build at all, so
      brotli isn't an option here one way or the other.
      **On the production server:** confirm `mod_deflate` is loaded (`apachectl -M | grep
      deflate` on the server, or ask the host) and add this to `.htaccess`:
      ```
      <IfModule mod_deflate.c>
          AddOutputFilterByType DEFLATE text/html text/plain text/css text/xml text/javascript
          AddOutputFilterByType DEFLATE application/javascript application/x-javascript
          AddOutputFilterByType DEFLATE application/json application/xml application/rss+xml
          AddOutputFilterByType DEFLATE image/svg+xml font/woff font/woff2
      </IfModule>
      ```
      It's already wrapped in `<IfModule>` so it's a safe no-op if the module isn't present.
      If the host is on something like cPanel/Plesk/managed WP hosting, gzip (and often brotli)
      is frequently already on by default at the server level — worth checking with `curl -I
      -H "Accept-Encoding: gzip, br"` against the live domain before assuming it needs adding.
- [!] **Full-page caching (WP-Optimize or similar).** Not activated here — turning on a
      page-cache plugin changes response behavior (stale content windows, cache-clearing on
      publish, etc.) in a way that's a production decision, not something to flip on
      silently while this is local-only. WP-Optimize is already installed and inactive; when
      ready to deploy, either activate its page-cache module or install WP Super Cache / Cache
      Enabler (anything that isn't Nitropack, per the original constraint) and configure it on
      the production server directly.
- [x] Verified the Phase-1 Expires/Cache-Control rules in `.htaccess`: the `Cache-Control`
      block (images/fonts/css/js, via `mod_headers`) is confirmed working locally — `mod_headers`
      is loaded in this MAMP build and `curl -I` on an uploaded image shows
      `Cache-Control: public, max-age=31536000, immutable`. The `ExpiresByType` block, however,
      is currently a no-op **locally** since `mod_expires` is also commented out in this MAMP's
      `httpd.conf` (not loaded) — harmless (wrapped in `<IfModule>`), just redundant with the
      `Cache-Control` headers while inactive. On the production server, confirm `mod_expires` is
      loaded so both mechanisms are actually active (they're complementary, not conflicting).
- [!] **PHP OPcache.** Checked (read-only) the MAMP PHP builds available locally — `opcache.enable=1`
      is already set in both the PHP 8.1 and 7.4 `php.ini` files bundled with this MAMP install,
      so nothing to change here locally. On the production server, check `phpinfo()` or the
      host's control panel for the equivalent `opcache.enable` setting — most managed WP/shared
      hosts have it on by default, but it's worth a direct confirmation rather than assuming.

## Phase 5 — Fonts/third-party

- [x] Checked for remaining Google Fonts CDN usage: **none** — grepped the whole theme/child
      theme, no `fonts.googleapis.com`/`fonts.gstatic.com` reference anywhere. All fonts
      (Roboto, Liberation Sans, Boxicons) are already self-hosted as local `.woff2` files, and
      every `@font-face` in `style.css` already has `font-display: swap !important`. Nothing to
      do here - this was already done before this pass.
      Verified each of the 6 fonts preloaded in `header.php` is actually used above the fold,
      rather than just assuming: `LiberationSans-Regular` is the site-wide body-text default
      (`!important`), `Roboto-Bold` is every heading (h1-h6), `Roboto-Medium` is the main nav
      menu text, `LiberationSans-Bold` is used in the hero banner description's bold text (plus
      buttons further down), `Roboto-Regular` is used in the hero banner's "about" slider
      description, and `boxicons.woff2` backs the header/nav icon glyphs. All 6 are genuinely
      above-the-fold on at least one page template — none dropped.
- [x] Re-checked the Calendly `preconnect` hints — **tried to make them conditional and had to
      revert it.** Built a check against the ACF `one_or_more_columns` layout's structured
      `calendly` repeater field, since that's the only place `'Calendly'` appears as a defined
      field type in the codebase. Testing against the live homepage caught the actual bug: the
      homepage embeds a real Calendly widget as **raw HTML pasted into a free-text description
      field** (`<div class="calendly-inline-widget" data-url="https://calendly.com/...">` +
      `assets.calendly.com/assets/external/widget.js`), completely outside the structured field
      my check looked at. The conditional version silently dropped the preconnect hint on
      exactly the page that needs it most. Reverted both the `header.php` and `functions.php`
      changes - confirmed the hint is back and firing on the homepage. Left as unconditional
      sitewide, which was the correct call all along: editors can paste a Calendly embed into
      any rich-text field, so there's no reliable static check for "does this page use
      Calendly," and the cost of an unused `preconnect` is low enough that guessing wrong (and
      silently breaking it, the way my first attempt did) is worse than leaving it alone.
- [x] Reviewed Wordfence's actual configuration (read-only, via a `wp-load.php` bootstrap +
      direct `wfconfig` table query - no settings changed):
      - **Live Traffic logging** (`liveTrafficEnabled`) - already **off**. This is the heaviest
        per-request cost Wordfence can add (a DB write logging every single visit), so the
        biggest win here was already in place.
      - **Scheduled scans** (`scheduledScansEnabled=1`, `manualScanType=onceDaily`) - scans
        already run on a schedule (roughly every 3 days per `noc1ScanSchedule`), not
        continuously or on every request. The "switch to scheduled-scan-only" part of this item
        is effectively already satisfied.
      - **Firewall mode** (`cacheType=disabled`) - Wordfence is running in *Basic Protection*
        mode: its WAF loads as a normal plugin after WordPress fully bootstraps, on every
        request. Wordfence's *Extended Protection* mode runs the firewall check earlier via a
        small file prepended before WordPress loads (faster per-request), but switching
        requires editing `wp-config.php` and having Wordfence write an auto-prepend file - a
        real infrastructure change, not a settings tweak. Per your call, documenting this
        rather than applying it: whoever manages the live site/hosting should decide whether to
        switch protection levels, not something to flip during a local pass.

## Client feedback follow-up (2026-10-16)

Client asked for: no GIFs, 5 videos on home / 1 per service page, 5-10 vertical image carousels
(already the pattern), every image as WebP, text-first content, Calendly removed from all pages
except a thank-you page (form elsewhere), and a look at whether the hero's company-logo
carousel is worth replacing with statistics if it's adding load time.

- [x] **GIFs.** Found 150 actual `.gif` files in use as animated icons (`grid_column.php`,
      `our_services.php` - code already had `$is_gif` detection with comments anticipating a
      webp fallback that was never wired up). Converted the 104 non-backup ones to animated
      `.webp` via `gif2webp` (same `foo.gif.webp` sibling convention as Phase 2's images),
      extended the `.htaccess` WebP content-negotiation rule to also match `.gif`. Verified live:
      a 180KB gif now serves as an 87KB animated webp, ~36% smaller in aggregate (19.2MB →
      12.2MB), motion preserved, originals untouched as fallback for old browsers. Originals
      backed up to `/Applications/MAMP/htdocs/motioneffects-uploads-backup/gifs-pre-webp-*/`.
- [x] **Automatic WebP for future uploads.** The Phase 2 conversion was a one-time batch job;
      added a `wp_generate_attachment_metadata` hook (`functions.php`) so every new upload
      (and every size WordPress generates from it) automatically gets a `.webp` sibling going
      forward, same naming convention, plus a `delete_attachment` hook that removes the
      sibling(s) when the original is deleted so they don't pile up as orphans. Used GD
      (`imagewebp`) rather than shelling out to `cwebp`/`gif2webp`, since GD ships with nearly
      every PHP install (production host included) while those CLI binaries might not exist
      there. Tradeoff: GD can't write *animated* WebP, so a future animated-GIF upload would
      only get a static first-frame WebP - an acceptable gap given the whole point is to stop
      uploading GIFs. Tested end-to-end (simulated a real upload through
      `wp_generate_attachment_metadata`/`wp_update_attachment_metadata`): every generated size,
      including WordPress's own "-scaled" downsize, got a correctly-sized `.webp` sibling, and
      deleting the attachment cleaned up every one of them.
- [x] **Homepage video count** - already exactly 5 (1 showreel + 4 feature videos), matches
      the ask already. No change needed.
- [!] **Service pages: 1 video each.** Checked the "Video Editing Services" page as a sample -
      it currently has 3 videos in the `feature_videos` section. Trimming to 1 means picking
      *which* video stays, which is your call, not mine - flagging rather than guessing.
- [!] **Calendly removed except on a thank-you page.** Confirmed the homepage has a real,
      live Calendly embed - pasted as raw HTML directly into a free-text description field, not
      through any structured field. (This is also why my earlier attempt at a conditional
      `preconnect` check in Phase 5 was wrong and got reverted - it only looked at the
      structured field and missed this.) Need you to point me at which page is "the" thank-you
      page before I move the embed there and strip it from everywhere else, and confirm there
      isn't a Calendly embed pasted into any *other* page's free-text fields the same way (I
      only confirmed the homepage has one; haven't swept every page for the same raw-HTML
      pattern yet).
- [!] **Hero logo carousel → statistics.** Confirmed it's *not* adding extra script weight
      (reuses the already-loaded Slick instance, no separate library) - so this is a content
      preference, not a performance fix. `hero_banner.php` already has a built-in "About
      Company" stats mode (an ACF toggle, `show_options`) that's fully coded and ready - but the
      homepage's `about_company` field is **completely empty** (no items, no bg_color). Flipping
      the toggle right now would just leave a blank gap where the logos used to be. Waiting on
      the actual stat title/description pairs you want shown before doing anything here.
      Along the way, removed a leftover debug line (`<?php print_r($about_company); ?>`, hidden
      via a `d-none` class but still bloating every page's HTML) from `hero_banner.php` - pure
      cleanup, unrelated to the toggle decision.

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
