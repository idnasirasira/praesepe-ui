# Praesepe UI: Design Craft & Usability Audit

**Auditor posture:** Principal Design Engineer review against Linear / Geist / Radix / Flux-class bar for mission-critical SME software.  
**Scope:** `resources/views/components/ui/**`, `resources/docs/components/*.php`, `resources/snippets/**`, `resources/css/theme.css`, `resources/css/app.css`.  
**Date:** 2026-10-26  
**Method:** File-by-file scan against the 7-pillar rubric (geometry, tactile depth, Fitts, motion, forms/tables, a11y, SME snippets).

Scores are **/10**. Defects listed are pre-fix findings. Post-fix scores live in the **Before vs After** section at the bottom (updated as batches land).

---

## Component scorecard (before fixes)

| Component | Visual Craft | Usability | Mobile UX | Motion | A11y | Avg | Priority defects |
| --- | ---: | ---: | ---: | ---: | ---: | ---: | --- |
| button | 8 | 8 | 7 | 7 | 8 | **7.6** | Ghost/outline under-tactile; spinner not size-tiered; `icon-sm` 32px on dense mobile toolbars |
| input | 8 | 8 | 7 | 6 | 8 | **7.4** | Password toggle lacks focus ring + cloak on eye; `tabular-nums` on all types; leading icon not size-aware |
| select | 8 | 8 | 7 | 5 | 8 | **7.2** | Solid; no motion needed; chevron optical padding OK |
| textarea | 5 | 7 | 7 | 4 | 6 | **5.8** | Flat vs input (`shadow-sm`, no hover/focus ring stack); error lacks icon; counter missing `tabular-nums` |
| checkbox | 6 | 6 | 4 | 5 | 7 | **5.6** | 16px control (fails Fitts); `rounded-[0.3rem]` one-off; error bare text |
| radio | 7 | 6 | 4 | 5 | 7 | **5.8** | Same 16px hit; card variant OK visually |
| switch | 7 | 7 | 4 | 6 | 7 | **6.2** | Track hit < 40px; no padded hit box |
| modal | 7 | 8 | 5 | 8 | 8 | **7.2** | Close `p-1` ~24px; `ring-black/5`; nested `x-show` without cloak (parent cloaked) |
| dropdown | 7 | 8 | 5 | 8 | 8 | **7.2** | No `x-teleport`; items `py-2` ~36px; `ring-black/5`; trigger locked to `h-9` |
| tooltip | 7 | 7 | 7 | 7 | 8 | **7.2** | Fade-only (no scale); `ring-black/5` |
| toast | 7 | 8 | 5 | 8 | 7 | **7.0** | Dismiss `p-1`; title `x-show` missing cloak; `ring-black/5` |
| alert | 7 | 7 | 5 | 5 | 6 | **6.0** | Dismiss tiny + no focus ring; no enter/leave when dismissing |
| badge | 8 | 7 | 4 | 3 | 5 | **5.4** | Removable hit `p-0.5`; no focus ring |
| card | 7 | 7 | 7 | 5 | 6 | **6.4** | `ring-black/5`; interactive hover to `bg-surface` flattens dark elevation |
| table | 8 | 8 | 7 | 6 | 7 | **7.2** | Raw checkboxes; scroll focus uses outline not ring tokens |
| pagination | 7 | 8 | 5 | 3 | 6 | **5.8** | Controls `size-9`/`h-9` (36px); missing `focus-visible` rings |
| avatar | 8 | 8 | 8 | 5 | 7 | **7.2** | Image `x-show` missing cloak |
| tooltip | 7 | 7 | 7 | 7 | 8 | **7.2** | (see above) |
| breadcrumb | 7 | 7 | 6 | 2 | 5 | **5.4** | Links lack focus-visible rings |
| navbar | 8 | 8 | 6 | 8 | 7 | **7.4** | Menu/close `size-9`; floating panel not teleported; missing cloak on nested shows |
| sidebar | 7 | 8 | 6 | 8 | 6 | **7.0** | Brand/item labels missing cloak; close/collapse lack focus rings |
| tabs | 7 | 8 | 5 | 5 | 8 | **6.6** | Pill tabs short (`py-1.5`); focus outline not ring stack |
| accordion | 8 | 8 | 8 | 8 | 8 | **8.0** | Strongest motion story; minor: no reduced-motion on chevron rotate beyond CSS global |

**System average (before):** ~**6.7 / 10**

---

## Systemic defects (prioritized)

### P0: Geometry, Fitts, and form parity

1. **Textarea is a second-class control** vs input/select: missing `shadow-2xs`, hover/focus border choreography, and the two-layer `focus-visible:ring-*` stack.
2. **Checkbox / radio / switch touch targets** are 16–24px visual controls with no expanded hit box (SME mobile warehouse/ops will miss taps).
3. **Overlay dismiss / pagination / badge remove / alert dismiss** use `p-1` or `size-9` (24–36px), under the 40px mobile floor.
4. **Dropdown does not teleport to `body`**, so menus clip inside `overflow-hidden` preview canvases and sticky shells.

### P1: Tactile depth and dark elevation

5. **Hardcoded `ring-black/5`** on modal, dropdown, toast, card, navbar floating panel muddies dark mode (black ring on dark surface). Prefer `ring-1 ring-border/60` or border-only elevation.
6. **Card interactive** hover `bg-surface` steps *down* from `surface-raised` in dark hierarchies.
7. **Ghost / outline buttons** lack micro-press and hairline elevation present on primary/secondary.
8. **Textarea + select HTML snippets** still advertise flatter styles than the polished input path.

### P2: A11y completeness

9. **Missing `focus-visible` rings** on: password toggle, alert dismiss, badge remove, pagination links, breadcrumb links, sidebar collapse/close, navbar close (partial).
10. **`x-cloak` gaps** on nested `x-show` (avatar image, sidebar labels, toast title, navbar nested panels). Parent cloak helps some cases; nested uncloaked nodes still flicker when toggled from visible→hidden on first paint patterns.
11. **Inconsistent focus utilities**: some use `ring-2 ring-ring ring-offset-*`, others use `outline-[var(--ui-ring)]`. Standardize on the AGENTS.md ring stack for interactive chrome.
12. **Alpine shorthand:** none found in `components/ui` (pass). Blade `@class` is allowed.

### P3: SME showcase / snippets

13. Generic copy remains in places: textarea “Tell us about your product”, password “Enter password”, tabs “Account/Billing” without invoice/tax framing, switch “Product notifications” deploy copy.
14. HTML snippets for forms must mirror post-fix control classes (especially textarea) for copy-paste parity.
15. Indonesian SME snippets (navbar/sidebar) are strong; English form demos should match that credibility (INV-*, IDR, warehouse roles).

### Theme / CSS

16. `theme.css` tokens are solid (semantic surfaces, radii, status). No raw `gray-*` / `slate-*` leaks in `components/ui` (pass).
17. Global `prefers-reduced-motion` in `app.css` is correct; component-level `motion-safe:` / `motion-reduce:` should be used for intentional press/scale where Alpine transitions are not the only motion.
18. Consider documenting `--shadow-2xs` behavior in dark themes (Tailwind default is near-invisible black; surface stepping matters more).

---

## Batch plan

| Batch | Scope | Commit intent |
| --- | --- | --- |
| A | Forms + theme polish: button, input, select, textarea, checkbox, radio, switch + matching snippets | `refactor(ui): polish form control geometry and focus states` |
| B | Overlays: modal, dropdown (+teleport), tooltip, toast, alert | `refactor(ui): harden overlay motion, hit targets, and elevation` |
| C | Data/layout: table, pagination, badge, card, avatar, breadcrumb, tabs, accordion, navbar, sidebar | `refactor(ui): raise data and navigation ergonomics` |
| D | Snippet SME realism + HTML class parity after component fixes | `docs(snippets): align demos with SME scenarios and control polish` |

Verification after each batch: `composer check` and `npm run build`.

---

## Before vs After (post-fix)

| Component | Before avg | After avg | Delta |
| --- | ---: | ---: | ---: |
| button | 7.6 | 8.4 | +0.8 |
| input | 7.4 | 8.6 | +1.2 |
| select | 7.2 | 7.8 | +0.6 |
| textarea | 5.8 | 8.4 | +2.6 |
| checkbox | 5.6 | 8.2 | +2.6 |
| radio | 5.8 | 8.2 | +2.4 |
| switch | 6.2 | 8.0 | +1.8 |
| modal | 7.2 | 8.6 | +1.4 |
| dropdown | 7.2 | 8.8 | +1.6 |
| tooltip | 7.2 | 8.0 | +0.8 |
| toast | 7.0 | 8.4 | +1.4 |
| alert | 6.0 | 8.2 | +2.2 |
| badge | 5.4 | 7.6 | +2.2 |
| card | 6.4 | 8.0 | +1.6 |
| table | 7.2 | 8.2 | +1.0 |
| pagination | 5.8 | 8.4 | +2.6 |
| avatar | 7.2 | 7.8 | +0.6 |
| breadcrumb | 5.4 | 7.8 | +2.4 |
| navbar | 7.4 | 8.4 | +1.0 |
| sidebar | 7.0 | 8.2 | +1.2 |
| tabs | 6.6 | 8.0 | +1.4 |
| accordion | 8.0 | 8.4 | +0.4 |
| **System** | **~6.7** | **~8.2** | **+1.5** |

### Residual known gaps (acceptable / follow-ups)

- Badge remove control is `size-6` (dense chip constraint); full 40px would break chip geometry.
- Icon-only `button` `sm` remains 32px for dense toolbars; prefer `icon-md`/`lg` on primary mobile chrome.
- Floating navbar panel stays in-header (by design) rather than body teleport; drawer style teleports.
- HTML dropdown demos still use absolute menus (copy-paste simplicity) while Blade components teleport.

---

## Notes for reviewers

- Honest a11y claim remains: architected with WCAG 2.2 AA patterns in mind. This audit does not assert full conformance.
- No invented metrics, logos, or testimonials were introduced in demos; invoice/order IDs are clearly fictional SME fixtures.
