# Changelog

## 1.1.1 (2026-10-26)

- Fixed: a **500 error on Joomla 5.0 to 5.2**. The overrides called `Form::renderControlFields()`, a method that only exists from Joomla 5.3. They now check that it exists and, on older Joomla 5, print the hidden form fields (the security token and the redirect) themselves. Joomla 5.3, 5.4 and 6.x behave exactly as before.
- Added a **Compatibility** section to the README and the install guide: which Joomla and PHP versions were tested, which are supported, and what is not covered.
- Tested with a fresh 55-check browser run on Joomla 5.2.6, 5.4.10 and 6.2.0 with stock Cassiopeia (all pass). On 5.2.6 the 1.1.0 files give the 500 error and the 1.1.1 files do not.
- Files changed: `login/default_login.php`, `registration/default.php`, `profile/edit.php`, `reset/default.php`, `reset/confirm.php`, `remind/default.php`.

## 1.1.0 (2026-10-16)

- New: friendly **sign-in** card and **sign-out** card (`login/default_login.php`, `login/default_logout.php`). Remember-me, passkey and other extra sign-in buttons, the menu item's description and image, the redirect field and the token are all kept.
- New: **forgotten password** in all three steps (`reset/default.php`, `reset/confirm.php`, `reset/complete.php`) and **forgotten username** (`remind/default.php`).
- Works on both Joomla 5.4 and 6.x: the overrides handle the small differences in how the two versions print the hidden fields and legends.
- New wording lines for these pages in `html/account-pages/language/en-GB/en-GB.account_pages.ini` (keys start `TPL_ACCOUNT_LOGIN_`, `TPL_ACCOUNT_LOGOUT_`, `TPL_ACCOUNT_RESET_`, `TPL_ACCOUNT_REMIND_`).
- Tested on Joomla 5.4.10 and 6.2.0 with stock Cassiopeia: 59 browser checks each (40 for register, thank-you, profile and edit profile, 19 for the new pages, including the whole forgotten-password flow).

## 1.0.0 (2026-10-16)

First release.

- Friendly registration form, thank-you page, profile view and edit-profile page as Bootstrap 5 template overrides for `com_users`.
- Plain UK English wording in one language file loaded by the overrides themselves (`html/account-pages/language/en-GB/`).
- One stylesheet (`html/account-pages/account-pages.css`) that follows the template's colours and fonts.
- "Your preferences" (editor, time zone, language, dark mode) shown only to people who may log in to the administrator.
- Visible red state for fields Joomla rejects; consistent look for select boxes, including the time-zone box.
- Tested on Joomla 5.4.10 and Joomla 6.2.0 (40 browser checks each) with stock Cassiopeia.
