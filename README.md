# Timeline Widget for Elementor

A beautiful, animated vertical timeline widget plugin for the Elementor page builder.

---

## Features

- **3 layout styles**: Left-aligned, Alternating (zigzag), and Center line
- **Repeater-based items**: Add unlimited timeline entries with date, title, description, and icon
- **Per-item accent colour**: Override the icon background colour for individual items
- **Scroll-reveal animations**: Items fade and slide in as the user scrolls (can be toggled off)
- **Full style controls**: Typography, colours, card shadows, border radius, spacing — all via the Elementor panel
- **Responsive**: Alternating layout collapses gracefully on mobile
- **Elementor live preview**: Changes reflect instantly in the editor

---

## Requirements

- WordPress 5.6 or higher
- Elementor (free) 3.0 or higher
- PHP 7.4 or higher

---

## Installation

1. Download / copy the `timeline-widget-elementor` folder.
2. Upload it to `/wp-content/plugins/` on your server.
3. In **WordPress Admin → Plugins**, activate **Timeline Widget for Elementor**.
4. Open any page in Elementor.
5. Search for **"Timeline"** in the widget panel — drag it onto your page.

---

## Plugin File Structure

```
timeline-widget-elementor/
├── timeline-widget.php          ← Main plugin file (activation entry point)
├── widgets/
│   └── timeline-widget.php      ← Elementor widget class (controls + render)
├── assets/
│   ├── css/
│   │   └── timeline.css         ← All styles for all 3 layouts
│   └── js/
│       └── timeline.js          ← Scroll animation (IntersectionObserver)
└── README.md
```

---

## Usage

### Adding Items
1. Drag the **Timeline** widget onto your page.
2. In the **Content → Timeline Items** section, click **Add Item**.
3. Fill in **Date / Label**, **Title**, **Description**, and choose an **Icon**.
4. Optionally set a per-item **Accent Colour** to override the default icon background.

### Choosing a Layout
In **Content → Layout**, choose:
- **Icon Left, Content Right** – a clean single-column timeline
- **Alternating (Zigzag)** – items alternate left/right of a centre line
- **Center Line** – items stacked centrally below a line marker

### Styling
All style options live in the **Style** tab:
- **Timeline Line** – colour and width
- **Icon / Marker** – size, colour, background, border radius
- **Content Card** – background, border, radius, shadow, padding
- **Typography** – separate controls for date, title, and description
- **Spacing** – gap between items and between icon and card

---

## Customisation Tips

- Use the **Accent Colour** per item to create a colour-coded visual history.
- Combine with Elementor's **Motion Effects** (scroll parallax) on the section for extra depth.
- Pair with a **Heading** widget above the timeline set to `<h2>` for SEO-friendly markup.

---

## Changelog

### 1.0.0
- Initial release
- 3 layout modes: left, alternate, center
- Repeater items with icon, date, title, description, accent colour
- Scroll-reveal animations via IntersectionObserver
- Full Elementor Style tab controls
