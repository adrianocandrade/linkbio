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
