# Installing Friendly Account Pages

About five minutes. You need to be able to put files on the site (FTP, SFTP, your hosting file manager, or a local copy of the site). Nothing is installed through Joomla's Extensions screen, and nothing changes in the database.

**Works with:** Joomla 5.4 and 6.x, on a template built on Bootstrap 5 (Cassiopeia, and most current templates).

## Before you start

- Take a backup of the template's `html` folder if it has one. A site with no `html` folder in its template has no overrides yet, which is fine.
- Find out which template the site uses: open **System**, choose **Site Template Styles**, and look for the style marked with a star (the default), or the style your registration and profile menu items are assigned to.

## Step 1: Get the kit

Download `friendly-account-pages-1.1.0.zip` from the [Releases page](https://github.com/dmlwebal/joomla-friendly-account-pages/releases/latest) and unzip it on your computer. Inside you will find a folder called **`html`**, plus this guide, the licence and screenshots.

## Step 2: Copy the `html` folder into your template

Copy the kit's `html` folder into your template's folder:

```
templates/<your template>/html/
```

For stock Cassiopeia that is `templates/cassiopeia/html/`.

If the template already has an `html` folder, **merge** the two (do not replace the existing one). When you have finished you should see:

```
templates/<your template>/html/com_users/login/default_login.php
templates/<your template>/html/com_users/login/default_logout.php
templates/<your template>/html/com_users/registration/default.php
templates/<your template>/html/com_users/registration/complete.php
templates/<your template>/html/com_users/profile/default.php
templates/<your template>/html/com_users/profile/default_core.php
templates/<your template>/html/com_users/profile/default_custom.php
templates/<your template>/html/com_users/profile/default_params.php
templates/<your template>/html/com_users/profile/edit.php
templates/<your template>/html/com_users/remind/default.php
templates/<your template>/html/com_users/reset/default.php
templates/<your template>/html/com_users/reset/confirm.php
templates/<your template>/html/com_users/reset/complete.php
templates/<your template>/html/account-pages/account-pages.css
templates/<your template>/html/account-pages/language/en-GB/en-GB.account_pages.ini
```

Notes:

- **Child template?** Put the `html` folder in the child template, not the parent.
- **Several templates or styles?** Copy it into every template your registration and profile pages can use.
- **Already have your own `com_users` overrides?** The kit replaces the files with the same names. Keep yours aside and compare before merging.

## Step 3: Make sure the pages exist and registration is on

1. **Allow registration:** Users > Manage > Options > "Allow User Registration" set to Yes. Check "New User Account Activation" is how you want it (None, Self, or Administrator).
2. **Menu items:** in the menu you want, add items of these types if they are not there already (Menus > your menu > New):
   - **Users > Login Form** (the sign-in page; it turns into the sign-out card for people who are already signed in)
   - **Users > Registration Form** (the register page)
   - **Users > User Profile** (the profile page)
   - **Users > Password Reset** and **Users > Username Reminder Request** (the forgotten-details pages; the links on the sign-in card work without them)
   - **Users > Edit User Profile** (optional; the "Edit my details" button works without it)
3. **Email:** registration sends an email, so Global Configuration > Server > Mail must work. If you are testing on a local machine with mail switched off, Joomla shows a harmless "could not send the registration email" warning above the thank-you page.

## Step 4: Check it worked

Open the sign-in page in a private browser window. You should see a rounded card headed "Welcome back" with a button saying "Sign in". Then open the Register page: a coloured welcome panel beside a rounded form card, with a button saying "Create my account".

Then sign in, open the profile page (you should see "Hello, <first name>"), press **Edit my details**, and try "Forgot your password?" from the sign-in card.

## Changing the wording

Everything people read lives in one language file, and you do not need to edit it. Use Joomla's own screen so your changes survive kit updates:

1. Open **System**, choose **Language Overrides**, then pick **Site** and **English (en-GB)**.
2. Search for `TPL_ACCOUNT_`.
3. Click a line, change the text, save.

The three "reasons to join" on the register page (`TPL_ACCOUNT_PERK_...`) are placeholders. Rewrite them for the site.

**Another language:** copy the kit's `html/account-pages/language/en-GB` folder to the new language code (for example `de-DE`), rename the file to `de-DE.account_pages.ini` and translate the values. Any line you leave out falls back to English.

## Who sees "Your preferences"

Only people who are allowed to log in to the administrator (Manager, Administrator and Super User by default). Everyone else gets the site's defaults. The rule lives in `html/com_users/profile/default_params.php` and `html/com_users/profile/edit.php`; see the README for how to change it.

## Updating

Replace the kit's files with the new ones (same folders). Your Language Overrides are untouched. Read the [changelog](CHANGELOG.md) first. After a Joomla update, open **System > Site Templates** and pick your template: Joomla lists any override whose original file has changed and lets you mark it as checked. That is your cue to compare the files.

## Uninstalling

Delete these folders from the template and clear the site cache. Joomla goes back to its own pages immediately:

```
templates/<your template>/html/com_users/login
templates/<your template>/html/com_users/registration
templates/<your template>/html/com_users/profile
templates/<your template>/html/com_users/reset
templates/<your template>/html/com_users/remind
templates/<your template>/html/account-pages
```

(Leave `html/com_users` itself if you have other overrides in it.) Remove any `TPL_ACCOUNT_` lines you added under Language Overrides.

## If something looks wrong

| What you see | Likely cause and fix |
|---|---|
| The pages look exactly as before | The files are in a template the site is not using. Check System > Site Template Styles, and the style assigned to the menu item. Clear the site cache (System > Clear Cache) and your browser cache. |
| The pages are plain, no cards or rounded corners | `account-pages.css` is missing or in the wrong place. It must be at `html/account-pages/account-pages.css` inside the template. |
| Raw text such as `TPL_ACCOUNT_REGISTER_TITLE` appears | The language file is missing or misnamed. It must be `html/account-pages/language/en-GB/en-GB.account_pages.ini`, with exactly that name. |
| The Register URL shows your home page instead of the form | Joomla needs a menu item for the page (Step 3.2). With a layout that has no main content area, a link with no menu item can land on the home page. |
| The sign-in card has no "Forgot your password?" page of its own | It uses Joomla's default reset address, so no menu item is needed. Add a Password Reset menu item only if you want it in a menu. |
| "Your preferences" is missing | Expected for ordinary members. Only people who can log in to the administrator see it. |
| Icons are missing | The template does not load Joomla's icon font. The pages still work; the icons are decoration only. |
| A page shows a PHP error after a Joomla update | Joomla changed the original file. Compare the override with the new core file (System > Site Templates, your template), or reinstall the latest kit. |
| Colours are not your brand colours | The coloured parts follow the template's primary colour. Change it in the template style, or set `--acct-accent-override` as described in the README. |

## Still stuck?

Open an issue at <https://github.com/dmlwebal/joomla-friendly-account-pages/issues> with your Joomla version, the template name and a screenshot.
