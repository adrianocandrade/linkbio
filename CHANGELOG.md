# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-01-12

### Added

- Initial release of the project.
- Added version control configuration.

## [1.0.1] - 2026-01-12

### Changed

- Localized default page content blocks (Portuguese/English).
- Removed external support links and "Report Error" widgets from Admin dashboard.

## [1.0.2] - 2026-01-12

### Fixed

- Added missing columns (`postedBy`, `thumbnail`, `description`, `author`, `ttr`) to `pages` table migration to resolve SQL errors during page creation.

## [1.0.3] - 2026-01-12

### Fixed

- **Discover Route Attribution:** Fixed issue where visits to workspace pages were being merged with the main user account. System now explicitly attributes visits to the correct workspace ID.
- **Discover Route Display:** Updated logic to display the specific Name, Avatar, and Slug of the workspace/page instead of defaulting to the main user's profile.
- **Visitor Tracking:** Updated `MySession` model to ensure `slug` is always saved during visitor creation, with fallbacks for legacy data.

## [1.0.4] - 2026-01-13

### Added

- **Booking Days Translation:** Wrapped day names ('Mon', 'Tue', etc.) in `__()` translation helper in `sandy/Blocks/booking/Helper/Time.php`.
- **Portuguese Translations:** Added Portuguese translations for booking days (Seg, Ter, Qua, Qui, Sex, Sáb, Dom) and contact form texts (Send Message, Message, etc.) to `resources/lang/portugues.json`.

### Fixed

- **Profile Sync to Workspace:** Modified `SettingsController@post` to sync profile updates (name, username) to the default workspace, ensuring data consistency between `users` and `workspaces` tables.
- **WhatsApp/Contact Form Layout:**
  - Added `z-index: 50` to `.auth-go-back` and `.bio-dark` buttons to prevent `bio-background` from blocking clicks.
  - Added `padding: 20px` to `.half-short` dialogs to prevent content from sticking to edges.
- **SEO Workspace Integration:** Modified `user_seo_tags()` helper function in `app/Helpers/Glob.php` to fetch SEO data (title, description, OpenGraph image) from workspace instead of user, ensuring workspace-specific SEO settings are displayed on public pages.

## [1.0.5] - 2026-01-14

### Added

- **Social Links Section in Mix Dashboard:** Added a new social links management section above the highlights in the Mix dashboard (`extension/Mix/Resources/views/index.blade.php`). Features include:
  - Grid layout displaying all available social networks (Email, WhatsApp, Facebook, Instagram, Twitter, YouTube, LinkedIn, Telegram, Snapchat, Discord, Twitch, Pinterest, TikTok, GitHub)
  - Visual indicators: green checkmark for configured networks, gray plus icon for unconfigured ones
  - "Manage" button for quick access to social settings page
  - Responsive design: 2 columns on mobile, 4 on tablet, 6 on desktop
  - Hover effects and consistent styling with the dashboard theme

### Fixed

- **Booking Past Time Blocking:** Fixed issue where users could book appointments for times that have already passed. Updated `sandy/Blocks/booking/Helper/Time.php` to:
  - Validate if selected time is in the past before checking for booking conflicts
  - Block time slots that have passed on the current day
  - Block all time slots for past dates
  - Added visual feedback in `sandy/Blocks/booking/Views/bio/livewire/booking.blade.php` with tooltips for unavailable time slots
