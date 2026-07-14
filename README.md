# CozyCart 🧸

CozyCart is a modern, lightweight full-stack e-commerce storefront designed for selling premium plushies, giant teddy bears, gift hampers, and custom children's toys. Built on Laravel, it prioritizes security, visual polish, and a seamless user experience.

## ✨ Key Features
- **Smart Catalog Routing:** Interactive filtering via dynamic category tabs alongside balanced 12-item database pagination.
- **Visual Skeletons:** Animated shimmering skeleton components handle empty storage variables gracefully while you build your media library.
- **Smart Priority Sorting:** Advanced SQL indexing automatically pushes products with active images to the front pages, leaving blank items on later pages.
- **Route & History Security:** Custom `PreventBackHistory` middleware blocks browser-back caching, preventing expired session (419) loops after logouts.
- **Admin Guardrails:** Custom role-based middleware protecting administrative controls and product creation panels.

## 🚀 Technical Stack
- **Backend:** Laravel (PHP)
- **Frontend:** Tailwind CSS, Blade Template Engine
- **Database:** MySQL