# Design System Strategy: Kinetic High-Performance Editorial

## 1. Overview & Creative North Star
The Creative North Star for this design system is **"Kinetic High-Performance Editorial."** 

We are moving away from the static, boxy constraints of traditional fitness apps. Instead, we treat the screen as a dynamic editorial canvas. This system captures the high-intensity energy of a premium training facility and the refined clarity of a luxury wellness journal. We achieve this through "The Pulse"—a design philosophy where intentional asymmetry, overlapping elements, and extreme typographic scale create a sense of motion even in static layouts. 

The goal is to make every screen feel like a custom-designed magazine spread rather than a generic dashboard.

---

## 2. Colors & Surface Philosophy
This system utilizes a high-contrast palette to drive focus and adrenaline. The primary electric lime (`primary_container`: #DAFF01) is used surgically to highlight "The Action," while the deep purples and blacks provide the sophisticated, "dark mode" foundation of a premium gym.

### The "No-Line" Rule
Standard 1px borders are strictly prohibited for sectioning. They create visual noise and "trap" content. Instead:
- **Boundaries:** Defined solely through background color shifts. A `surface-container-low` section should sit on a `surface` background to define its territory.
- **Visual Breath:** Use the spacing scale to create separation. Content should be grouped by proximity, not by containment lines.

### Surface Hierarchy & Nesting
Think of the UI as physical layers of premium materials—matte metal, dark glass, and vibrant high-performance fabrics.
- **Layer 0 (Background):** `surface` (#131313) — The foundation.
- **Layer 1 (The Track):** `surface-container-low` (#1C1B1B) — For secondary content blocks.
- **Layer 2 (The Equipment):** `surface-container-high` (#2A2A2A) — For interactive cards or prominent modules.
- **Layer 3 (The Focus):** `surface-bright` (#393939) — For floating elements or active states.

### The "Glass & Gradient" Rule
To add soul to the digital experience:
- **Glassmorphism:** For floating navbars or overlays, use `surface` at 70% opacity with a `20px` backdrop blur. This allows the energetic background colors to bleed through.
- **Signature Gradients:** Use a subtle "Momentum Gradient" for main CTAs: a linear transition from `primary` (#FFFFFF) to `primary_container` (#DAFF01) at a 135-degree angle.

---

## 3. Typography
Our typography is a dialogue between athletic intensity and technical precision.

- **Display & Headlines (Space Grotesk):** These are the "Shouts." Use `display-lg` and `headline-lg` with tight letter-spacing (-2%) and extreme weights to mimic high-end sports branding. 
- **Body & Labels (Plus Jakarta Sans):** These are the "Instructions." This typeface provides a modern, geometric clarity that ensures accessibility during high-activity use.
- **Editorial Hierarchy:** Don't be afraid of "hero" typography. A headline can intentionally overlap an image or extend slightly off the grid to create a sense of scale and momentum.

---

## 4. Elevation & Depth
Depth is achieved through **Tonal Layering** rather than traditional drop shadows.

### The Layering Principle
Place a `surface-container-lowest` card on a `surface-container-low` section. The subtle shift in hex value creates a soft, natural lift that feels integrated into the hardware.

### Ambient Shadows
If an element must "float" (e.g., a workout-start button), use an **Extra-Diffused Ambient Shadow**:
- **Blur:** 40px - 60px.
- **Opacity:** 6% - 10%.
- **Color:** Use a tinted version of `secondary_container` (#5602C9) rather than pure black to create a "glow" that feels organic.

### The "Ghost Border" Fallback
If contrast is required for accessibility in input fields or selection states, use a **Ghost Border**:
- `outline-variant` (#454932) at 15% opacity. It should be felt, not seen.

---

## 5. Components

### Buttons
- **Primary Action:** Ultra-pill shape (`rounded-full`). Background: `primary_container` (#DAFF01). Text: `on_primary_fixed` (#181E00). This is the highest energy point on the screen.
- **Secondary Action:** Glassmorphic background (30% opacity `surface_bright`) with a `primary` text label.
- **Interaction:** On hover/active, use a slight scale-up (1.02x) rather than a simple color change to simulate physical responsiveness.

### Cards
- **The Editorial Card:** Forbid divider lines. Separate "Heading," "Metric," and "Time" using vertical white space (at least `2rem`). 
- **Nesting:** Place a `surface-container-high` card inside a `surface-container-low` wrapper to create focus without clutter.

### Inputs & Selection
- **Text Inputs:** Use a `surface-container-highest` background with a 2px "Focus Bar" on the left side in `primary_container` when active.
- **Chips:** Selection chips should use `secondary_container` for the "Active" state to provide a visual break from the high-energy lime accents.

### Lists
- **The "Clean Flow" List:** No dividers. Each list item is separated by a 12px gap. The `on_surface_variant` is used for sub-labels to maintain a clear visual hierarchy.

---

## 6. Do's and Don'ts

### Do:
- **Use Asymmetry:** Place high-energy imagery slightly off-center to suggest movement.
- **Surgical Accents:** Use #DAFF01 only for the most important action on the screen. Too much of it creates visual fatigue.
- **High-Contrast Scale:** Use a massive `display-lg` headline next to a tiny `label-sm` to create a professional, editorial look.

### Don't:
- **Don't use 1px borders:** It breaks the "premium material" illusion.
- **Don't use standard Grey shadows:** Always tint your shadows with the brand's purple or lime to keep the UI from looking "muddy."
- **Don't crowd the edges:** High-performance design requires high-performance breathing room. Maintain a minimum 24px (1.5rem) margin on all mobile screens.
- **Don't use center-alignment for everything:** Stick to strong left-aligned editorial grids with occasional right-aligned "accent" metrics.