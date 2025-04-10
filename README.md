# Translation Management API

A high-performance, API-driven translation management system built with Laravel. Designed for scalability, localization, and frontend integration (e.g., Vue.js).

---

## 🚀 Features

- 🌍 **Multi-Locale Translations** — Supports multiple languages (e.g., `en`, `fr`, `es`) with dynamic locale addition.
- 🏷️ **Contextual Tagging** — Assign tags like `mobile`, `desktop`, or `web` to categorize translations.
- 🔍 **Flexible Search** — Search by key, tag, or content.
- 📦 **JSON Export Endpoint** — Optimized for frontend consumption (e.g., Vue.js) with real-time, always-updated translations.
- ⚡ **High Performance** — Sub-200ms response time for most endpoints, <500ms for JSON export of 100k+ records.
- 🔒 **Token-Based Authentication** — Secure access for API consumers.
- 🧪 **Test Data Factory** — Artisan command to seed 100k+ translations for performance testing.

---

## 🧱 Tech Stack

- **Framework:** Laravel 11+
- **Database:** MySQL / MariaDB (with indexes)
- **Auth:** Token-based (`auth_token`)
- **Standards:** PSR-12, SOLID principles
- **Performance:** Optimized SQL queries, caching, and JSON handling

---

## 📂 Endpoints

| Method | URI                                  | Description                          | Auth Required |
|--------|--------------------------------------|--------------------------------------|----------------|
| POST   | `/api/register`                      | Create a new user                    | ✅             |
| POST   | `/api/login`                         | User login                           | ✅             |
| POST   | `/api/translations`                  | Create a new translation             | ✅             |
| PUT    | `/api/update-translations/{id}`      | Update an existing translation       | ✅             |
| GET    | `/api/get-translations`              | Get a translations                   | ✅             |
| GET    | `/api/translations-search`           | Search by `tag`, `key`, or `content` | ✅             |
| GET    | `/api/translations-export`           | Export all translations as JSON      | ✅             |

---

## 🔐 Authentication

Use the token-based approach by passing your token as a Bearer token:

```http
Authorization: Bearer YOUR_API_TOKEN
