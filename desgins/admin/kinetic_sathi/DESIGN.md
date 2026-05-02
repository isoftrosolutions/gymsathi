# Design System: High-Performance Editorial

## 1. Overview & Creative North Star: "The Kinetic Pulse"
This design system is built to bridge the gap between high-octane athletic performance and professional management precision. Moving beyond the "standard SaaS dashboard," this system adopts a **Kinetic Pulse** philosophy—where the UI feels alive, responsive, and authoritative. 

We reject the "boxy" nature of traditional software. By utilizing intentional asymmetry, oversized typography scales, and layered glass surfaces, we create a digital environment that feels as premium as a high-end boutique fitness center. The "Sathi" (Companion) personality is expressed through an interface that guides rather than dictates, using light and depth to highlight what matters most.

---

## 2. Colors & Surface Architecture
Our palette is anchored in deep, obsidian depths with high-chroma electric accents.

### The Palette (Core Tokens)
- **Background**: `#111318` (The deep stage)
- **Primary (Lime)**: `#C8F135` (Energy & Action)
- **Secondary (Teal)**: `#44FAA4` (Flow & Success)
- **Surface-Container-Lowest**: `#0C0E13` (Recessed areas)
- **Surface-Container-Highest**: `#33353A` (Elevated interactive cards)

### The "No-Line" Rule
To maintain a high-end editorial feel, **1px solid borders are strictly prohibited for sectioning.** 
*   **Definition through Tonality:** Boundaries must be defined by shifts in background color (e.g., a `surface-container-low` sidebar against a `surface` main content area).
*   **The Glass & Gradient Rule:** For primary CTAs, use a subtle linear gradient from `primary` (#FFFFEF) to `primary_container` (#C8F135) at a 135-degree angle. This adds "soul" and prevents the flat look of generic UI.

### Surface Hierarchy & Nesting
Think of the UI as physical layers of frosted obsidian. 
- **Level 0 (Base):** `surface`
- **Level 1 (Sections):** `surface-container-low` 
- **Level 2 (Cards):** `surface-container-high` with `backdrop-blur: 12px` and 40% opacity.

---

## 3. Typography: Editorial Authority
We pair the brutalist, wide-character energy of **Syne** (Space Grotesk equivalent) with the technical precision of **DM Sans** (Manrope equivalent).

*   **Display (Syne):** Used for "Hero" moments—total revenue, active members, or gym slogans. Set with tight letter-spacing (-2%) to feel aggressive and modern.
*   **Headlines (Syne):** Bold and unapologetic. Use `headline-lg` for page titles to establish instant hierarchy.
*   **Body & Labels (DM Sans):** The "Sathi" voice. Clean, highly legible, and calm. Body text should never be pure white; use `on_surface_variant` (#C5C9AE) to reduce eye strain during long management sessions.

---

## 4. Elevation & Depth: The Layering Principle
We achieve depth through **Tonal Layering** rather than structural scaffolding.

*   **Ambient Shadows:** Floating elements (like Modals or Hovering Action Menus) use an "Atmospheric Shadow." 
    *   *Spec:* `0px 20px 40px rgba(0, 0, 0, 0.4)`. The shadow color should never be grey; it must be a darker tint of the background to feel integrated.
*   **The "Ghost Border" Fallback:** If a divider is mandatory for accessibility, use a `Ghost Border`—the `outline_variant` (#444934) at **15% opacity**.
*   **Glassmorphism:** All top-level cards must utilize `surface_container_high` with a 20% transparency and a `saturate(180%)` backdrop filter. This allows the high-energy lime accents to "glow" through the glass as the user scrolls.

---

## 5. Components: Style Guide

### Buttons (The Kinetic Triggers)
- **Primary**: Gradient fill (Lime to Primary Light), 18px rounded corners. No border. Text is `on_primary` (#293500) for maximum contrast.
- **Secondary**: `Ghost Border` with Lime text. 
- **Tertiary**: Text-only with a subtle `surface-bright` hover state.

### Input Fields (Professional Precision)
- **Default State**: `surface-container-lowest` background. No visible border until focus.
- **Focus State**: 1px border of `primary_fixed_dim` (#AED50D) with a soft outer glow.
- **Label**: Always `label-md` in `on_surface_variant`.

### Cards & Lists (The Editorial Feed)
- **Rule**: **Forbid divider lines.** 
- Use 24px - 32px of vertical white space to separate list items. 
- For list items, use a subtle `surface-container-low` background on hover to indicate interactivity.
- **Action Chips**: High-contrast `secondary_container` (#00DC8A) with `on_secondary_container` text for positive statuses (e.g., "Paid").

### Custom Component: "The Pulse Card"
Specifically for GymSathi: Use a large-scale card with a `surface-container-highest` background and an asymmetric "accent bar" of 4px width on the left side using the `primary` Lime. This is for high-priority member alerts.

---

## 6. Do’s and Don’ts

### Do:
- **Use Asymmetry:** Place large display numbers offset to the right or left to break the "grid" feel.
- **Leverage "Breathing Room":** If you think there’s enough padding, add 8px more. White space is a luxury signal.
- **High-Contrast Data:** Ensure numbers and metrics are the most vibrant elements on the screen.

### Don't:
- **No 100% Opaque Borders:** Never use a solid, high-contrast line to separate content. It kills the "flow."
- **No Pure Black:** Avoid #000000. Use `surface_container_lowest` (#0C0E13) to allow for depth and shadows.
- **No Generic Icons:** Avoid thin-line "wire" icons. Use minimalist, bold-stroke icons that match the weight of the `DM Sans` body text.