# Cleaned University Evening College website

## What changed
- Removed the duplicate, invalid nested chatbot HTML document that had been appended after `</body>` on the pages.
- Moved chatbot styles and behavior into `css/chatbot.css` and `js/chatbot.js`; the popup still opens only when the chat button is clicked.
- Improved keyboard support, mobile sizing, accessibility labels, and safe message rendering (`textContent`/text nodes rather than injecting user input as HTML).
- Removed the uncompiled `scss/` source tree (the site already uses `css/bootstrap.min.css`).
- Removed `database.php`, which was an unused duplicate of the form handler; `submit.php` remains the form endpoint.
- Hardened `submit.php` with input validation, prepared SQL statements, UTF-8 support, and generic user-facing database errors.

## Run locally
1. Copy the folder into XAMPP's `htdocs` directory.
2. Start Apache and MySQL.
3. Create the `college_form` database and an `admissions` table with columns `name`, `email`, `phone`, `address`, `course`, and `message` (use suitable VARCHAR/TEXT types).
4. Ensure the contact form submits to `submit.php` using POST and its existing field names: `name`, `email`, `phone`, `project`, `subject`, `message`.
5. Open `http://localhost/<folder-name>/index.html`.

## Before public deployment
- Set `DB_HOST`, `DB_USER`, `DB_PASSWORD`, and `DB_NAME` in the hosting environment. Do not use the XAMPP `root`/blank-password defaults on a public server.
- Verify the admissions table schema and all contact form field names against your actual database.
- The chatbot currently uses local rule-based replies; it does not call a Python backend or an AI API.
- Test all pages and form submission on the actual hosting environment. This cleanup was statically inspected; a live database-backed submission could not be tested here.
