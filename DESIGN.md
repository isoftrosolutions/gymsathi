# GymSathi Design System Guide

## 1. Visual Theme & Atmosphere

GymSathi embodies kinetic energy meets precision management — a design system rooted in the deepest performance black (`#001e2b`) that evokes both the intensity of high-performance training and the control of elite facility management. Against this near-black canvas, a striking electric lime (`#00ed64`) pulses as the brand accent — bright enough to feel alive, energetic enough to feel unstoppable. This isn't the cold black of data centers; it's the charged atmosphere of a world-class gym at peak hours.

The typography system is architecturally ambitious: Space Grotesk for massive hero headlines (96px) creates an athletic, commanding presence — geometric type at fitness-company scale signals power and precision. Manrope handles the heavy lifting of body and UI text with an unusually wide weight range (300–700), while Plus Jakarta Sans serves as the technical label font with distinctive uppercase treatments featuring wide letter-spacing (1px–3px). This three-font system creates a hierarchy that spans athletic authority → performance clarity → management precision.

What makes GymSathi distinctive is its dual-mode design: a dark performance/feature section world (`#001e2b` with electric lime accents) and a light management content world (white with slate-gray borders `#b8c4c2`). The transition between these modes creates dramatic contrast. The shadow system uses performance-tinted dark shadows (`rgba(0, 30, 43, 0.12)`) that maintain the high-performance atmosphere even on light surfaces. Buttons use pill shapes (100px–999px radius) with GymSathi Lime borders (`#00684a`), and the entire component system references the MongoDB-inspired Kinetic design system.

**Key Characteristics:**
- Deep performance black backgrounds (`#001e2b`) — gym-dark, not space-dark
- Electric GymSathi Lime (`#00ed64`) as the singular brand accent — energetic and unstoppable
- Space Grotesk for hero headlines — athletic authority at fitness scale
- Manrope for body with weight 300 (light) as a distinctive body weight
- Plus Jakarta Sans with wide uppercase letter-spacing (1px–3px) for technical labels
- Performance-tinted shadows: `rgba(0, 30, 43, 0.12)` — shadows carry the gym intensity
- Dual-mode: dark performance hero sections + light management content sections
- Pill buttons (100px radius) with lime borders (`#00684a`)
- Action Blue (`#006cfa`) and hover transition to `#3860be`

## 2. Color Palette & Roles

### Primary Brand
- **Performance Black** (`#0a0a0a`): Primary dark background — the deepest gym black
- **GymSathi Lime** (`#c8f135`): Primary brand accent — electric lime for highlights, underlines, gradients
- **Dark Lime** (`#65a30d`): Button borders, link text on light — muted lime for functional use

### Interactive
- **Action Blue** (`#3b82f6`): Secondary accent — links, interactive highlights
- **Hover Blue** (`#1d4ed8`): All link hover states transition to this blue
- **Active Lime** (`#84cc16`): Button hover background — bright lime

### Neutral Scale
- **Deep Slate** (`#1e293b`): Dark button backgrounds, secondary dark surfaces
- **Slate Gray** (`#475569`): Dark borders on dark surfaces
- **Dark Steel** (`#334155`): Dark link text variant
- **Cool Gray** (`#64748b`): Muted text on dark, secondary button text
- **Silver Slate** (`#94a3b8`): Borders on light surfaces, dividers
- **Light Input** (`#f1f5f9`): Input text on dark surfaces
- **Pure White** (`#ffffff`): Light section background, button text on dark
- **Black** (`#000000`): Text on light surfaces, darkest elements

### Shadows
- **Performance Shadow** (`rgba(10, 10, 10, 0.15) 0px 26px 44px, rgba(0, 0, 0, 0.13) 0px 7px 13px`): Primary card elevation — performance-tinted
- **Standard Shadow** (`rgba(0, 0, 0, 0.15) 0px 3px 20px`): General elevation
- **Subtle Shadow** (`rgba(0, 0, 0, 0.1) 0px 2px 4px`): Light card lift

## 3. Typography Rules

### Font Families
- **Display Serif**: `Space Grotesk` — athletic hero headlines
- **Body / UI**: `Manrope` — clean sans-serif workhorse
- **Code / Labels**: `Plus Jakarta Sans` — modern sans-serif with uppercase label treatments
- **Fallbacks**: `Inter` (with CJK: Noto Sans KR/SC/JP), `system-ui`, `sans-serif`

### Hierarchy

| Role | Font | Size | Weight | Line Height | Letter Spacing | Notes |
|------|------|------|--------|-------------|----------------|-------|
| Display Hero | Space Grotesk | 96px (6.00rem) | 700 | 1.20 (tight) | normal | Athletic authority |
| Display Secondary | Space Grotesk | 64px (4.00rem) | 700 | 1.00 (tight) | normal | Athletic sub-hero |
| Section Heading | Manrope | 36px (2.25rem) | 500 | 1.33 | normal | Performance precision |
| Sub-heading | Manrope | 24px (1.50rem) | 500 | 1.33 | normal | Feature titles |
| Body Large | Manrope | 20px (1.25rem) | 400 | 1.60 (relaxed) | normal | Introductions |
| Body | Manrope | 18px (1.13rem) | 400 | 1.33 | normal | Standard body |
| Body Light | Manrope | 16px (1.00rem) | 300 | 1.50–2.00 | normal | Light-weight reading text |
| Nav / UI | Manrope | 16px (1.00rem) | 500 | 1.00–1.88 | 0.16px | Navigation, emphasized |
| Body Bold | Manrope | 15px (0.94rem) | 700 | 1.50 | normal | Strong emphasis |
| Button | Manrope | 13.5px–16px | 500–700 | 1.00 | 0.135px–0.9px | CTA labels |
| Caption | Manrope | 14px (0.88rem) | 400 | 1.71 (relaxed) | normal | Metadata |
| Small | Manrope | 11px (0.69rem) | 600 | 1.82 (relaxed) | 0.2px | Tags, annotations |
| Tech Heading | Plus Jakarta Sans | 40px (2.50rem) | 600 | 1.60 (relaxed) | normal | Management showcase titles |
| Tech Body | Plus Jakarta Sans | 16px (1.00rem) | 400 | 1.50 | normal | Technical blocks |
| Tech Label | Plus Jakarta Sans | 14px (0.88rem) | 500–600 | 1.14 (tight) | 1px–2px | `text-transform: uppercase` |
| Tech Micro | Plus Jakarta Sans | 9px (0.56rem) | 700 | 2.67 (relaxed) | 2.5px | `text-transform: uppercase` |

### Principles
- **Bold for authority**: Space Grotesk at hero scale creates an athletic presence unusual in SaaS — it communicates that GymSathi is a performance institution, not a casual app.
- **Weight 300 as body default**: Manrope uses light (300) for body text, creating an airy reading experience that contrasts with the dense, dark backgrounds.
- **Wide-tracked sans labels**: Plus Jakarta Sans uppercase at 1px–3px letter-spacing creates technical signposts that feel like management field labels — systematic, structured, optimized.
- **Four-weight range**: 300 (light body) → 400 (standard) → 500 (UI/nav) → 700 (bold CTA) — a wider range than most systems, enabling fine-grained hierarchy.

## 4. Component Stylings

### Buttons

**Primary Lime (Dark Surface)**
- Background: `#00684a` (muted GymSathi lime)
- Text: `#000000`
- Radius: 50% (circular) or 100px (pill)
- Border: `1px solid #00684a`
- Shadow: `rgba(0,0,0,0.06) 0px 1px 6px`
- Hover: scale 1.1
- Active: scale 0.85

**Dark Slate Button**
- Background: `#1c2d38`
- Text: `#5c6c75`
- Radius: 100px (pill)
- Border: `1px solid #3d4f58`
- Hover: background `#84cc16`, text white, translateX(5px)

**Outlined Button (Light Surface)**
- Background: transparent
- Text: `#001e2b`
- Border: `1px solid #b8c4c2`
- Radius: 4px–8px
- Hover: background tint

### Cards & Containers
- Light mode: white background with `1px solid #b8c4c2` border
- Dark mode: `#001e2b` or `#1c2d38` background with `1px solid #3d4f58`
- Radius: 16px (standard), 24px (medium), 48px (large/hero)
- Shadow: `rgba(0,30,43,0.12) 0px 26px 44px` (forest-tinted)
- Image containers: 30px–32px radius

### Inputs & Forms
- Textarea: text `#e8edeb`, padding 12px 12px 12px 8px
- Borders: `1px solid #b8c4c2` on light, `1px solid #3d4f58` on dark
- Input radius: 4px

### Navigation
- Dark header on forest-black background
- Euclid Circular A 16px weight 500 for nav links
- MongoDB logo (leaf icon + wordmark) left-aligned
- Green CTA pill buttons right-aligned
- Mega-menu dropdowns with product categories

### Image Treatment
- Dashboard screenshots on dark backgrounds
- Green-accented UI elements in screenshots
- 30px–32px radius on image containers
- Full-width dark sections for product showcases

### Distinctive Components

**Neon Green Accent Underlines**
- `0px 2px 2px 0px solid #00ed64` — bottom + right border creating accent underlines
- Used on feature headings and highlighted text
- Also appears as `#006cfa` (blue) variant

**Source Code Label System**
- 14px uppercase Source Code Pro with 1px–2px letter-spacing
- Used as section category markers above headings
- Creates a "database field label" aesthetic

## 5. Layout Principles

### Spacing System
- Base unit: 8px
- Scale: 1px, 4px, 7px, 8px, 10px, 12px, 14px, 15px, 16px, 18px, 20px, 24px, 32px

### Grid & Container
- Max content width centered
- Dark hero section with contained content
- Light content sections below
- Card grids: 2–3 columns
- Full-width dark footer

### Whitespace Philosophy
- **Dramatic mode transitions**: The shift from dark teal sections to white content creates built-in visual breathing through contrast, not just space.
- **Generous dark sections**: Dark hero and feature areas use extra vertical padding (80px+) to let the forest-dark background breathe.
- **Compact light sections**: White content areas are denser, with tighter card grids and less vertical spacing.

### Border Radius Scale
- Minimal (1px–2px): Small spans, badges
- Subtle (4px): Inputs, small buttons
- Standard (8px): Cards, links
- Card (16px): Standard cards, containers
- Toggle (20px): Switch elements
- Large (24px): Large panels
- Image (30px–32px): Image containers
- Hero (48px): Hero cards
- Pill (100px–999px): Buttons, navigation pills
- Full (9999px): Maximum pill

## 6. Depth & Elevation

| Level | Treatment | Use |
|-------|-----------|-----|
| Flat (Level 0) | No shadow | Default surfaces |
| Subtle (Level 1) | `rgba(0,0,0,0.1) 0px 2px 4px` | Light card lift |
| Standard (Level 2) | `rgba(0,0,0,0.15) 0px 3px 9px` | Standard cards |
| Prominent (Level 3) | `rgba(0,0,0,0.15) 0px 3px 20px` | Elevated panels |
| Forest (Level 4) | `rgba(0,30,43,0.12) 0px 26px 44px, rgba(0,0,0,0.13) 0px 7px 13px` | Hero cards — teal-tinted |

**Shadow Philosophy**: MongoDB's shadow system is unique in that the primary elevation shadow uses `rgba(0, 30, 43, 0.12)` — a teal-tinted shadow that carries the forest-dark brand color into the depth system. This means even on white surfaces, shadows feel like they belong to the MongoDB color world rather than being generic neutral black.

## 7. Do's and Don'ts

### Do
- Use `#001e2b` (performance-black) for dark sections — not pure black
- Apply GymSathi Lime (`#00ed64`) sparingly for maximum electric impact
- Use Space Grotesk ONLY for hero/display headings — Manrope for everything else
- Apply Plus Jakarta Sans uppercase with wide tracking (1px–3px) for technical labels
- Use performance-tinted shadows (`rgba(0,30,43,0.12)`) for primary card elevation
- Maintain the dark/light section duality — dramatic contrast between modes
- Use weight 300 for body text — the light weight is the readable voice
- Apply pill radius (100px) to primary action buttons

### Don't
- Don't use pure black (`#000000`) for dark backgrounds — always use performance-black (`#001e2b`)
- Don't use GymSathi Lime (`#00ed64`) on backgrounds — it's an accent for text, underlines, and small highlights
- Don't use standard gray shadows — always use performance-tinted (`rgba(0,30,43,...)`)
- Don't apply bold font to body text — Space Grotesk is hero-only
- Don't use narrow letter-spacing on Plus Jakarta Sans labels — the wide tracking IS the identity
- Don't mix dark and light section treatments within the same section
- Don't use warm colors — the palette is strictly cool (black, lime, blue)
- Don't forget the lime accent underlines — they're the signature decorative element

## 8. Responsive Behavior

### Breakpoints
| Name | Width | Key Changes |
|------|-------|-------------|
| Mobile Small | <425px | Tight single column |
| Mobile | 425–768px | Standard mobile |
| Tablet | 768–1024px | 2-column grids begin |
| Desktop | 1024–1280px | Standard layout |
| Large Desktop | 1280–1440px | Expanded layout |
| Ultra-wide | >1440px | Maximum width, generous margins |

### Touch Targets
- Pill buttons with generous padding
- Navigation links at 16px with adequate spacing
- Card surfaces as full-area touch targets

### Collapsing Strategy
- Hero: MongoDB Value Serif 96px → 64px → scales further
- Navigation: horizontal mega-menu → hamburger
- Feature cards: multi-column → stacked
- Dark/light sections maintain their mode at all sizes
- Source Code Pro labels maintain uppercase treatment

### Image Behavior
- Dashboard screenshots scale proportionally
- Dark section backgrounds maintained full-width
- Image radius maintained across breakpoints

## 9. Agent Prompt Guide

### Quick Color Reference
- Dark background: Performance Black (`#001e2b`)
- Brand accent: GymSathi Lime (`#00ed64`)
- Functional lime: Dark Lime (`#00684a`)
- Link blue: Action Blue (`#006cfa`)
- Text on light: Black (`#000000`)
- Text on dark: White (`#ffffff`) or Light Input (`#e8edeb`)
- Border light: Silver Slate (`#b8c4c2`)
- Border dark: Slate Gray (`#3d4f58`)

### Example Component Prompts
- "Create a hero on performance-black (#001e2b) background. Headline at 96px Space Grotesk weight 700, line-height 1.20, white text with 'performance' highlighted in GymSathi Lime (#00ed64). Subtitle at 18px Manrope weight 400. Lime pill CTA (#00684a, 100px radius). Electric lime gradient glow behind gym dashboard screenshot."
- "Design a card on white background: 1px solid #b8c4c2 border, 16px radius, shadow rgba(0,30,43,0.12) 0px 26px 44px. Title at 24px Manrope weight 500. Body at 16px weight 300. Plus Jakarta Sans 14px uppercase label above title with 2px letter-spacing."
- "Build a dark section: #001e2b background, 1px solid #3d4f58 border on cards. White text. GymSathi Lime (#00ed64) accent underlines on headings using bottom-border 2px solid."
- "Create technical label: Plus Jakarta Sans 14px, text-transform uppercase, letter-spacing 2px, weight 600, #00ed64 color on dark background."
- "Design a pill button: #1c2d38 background, 1px solid #3d4f58 border, 100px radius, #5c6c75 text. Hover: #84cc16 background, white text, translateX(5px)."

### Iteration Guide
1. Start with the mode decision: dark (#001e2b) for hero/features, white for content
2. GymSathi Lime (#00ed64) is electric — use once per section for maximum impact
3. Bold headlines (Space Grotesk) create the athletic authority — never use for body
4. Weight 300 body text creates the airy reading experience — don't default to 400
5. Plus Jakarta Sans uppercase with wide tracking for technical labels — the management voice
6. Performance-tinted shadows keep everything in the GymSathi color world