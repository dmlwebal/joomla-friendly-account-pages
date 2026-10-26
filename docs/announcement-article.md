# Announcement article: Friendly Account Pages for Joomla (version 1.1.1)

*Written for Joomla site builders, agencies and community readers (forums, newsletters, social). Ready to paste; swap the byline and date as needed.*

---

## Headline options

1. **A free kit gives Joomla's sign-in, registration and profile pages the makeover they have needed for years**
2. **Friendly Account Pages: warm, plain-English sign-in, sign-up and profile screens for Joomla 5 and 6**
3. **No more "Minimum Requirements — Characters: 12": a free, drop-in redesign of Joomla's member pages**

## Article

**Free, open-source template overrides replace Joomla's dry registration and profile screens with rounded, card-based pages that follow each site's own colours and fonts.**

Every Joomla site with members has the same awkward moments. A visitor decides to sign up, and meets a screen headed "User Registration", a line reading "* Required field", and a password hint that says "Minimum Requirements — Characters: 12". It works, but it reads like a form from another decade, and it sits oddly on a carefully designed site.

**Friendly Account Pages** is a free kit that fixes that, without touching how Joomla handles accounts.

### What changes

- **Sign in and sign out:** a centred "Welcome back" card with the remember-me option, links for forgotten details and a "New here? Create an account" line. Passkey and other extra sign-in buttons that plugins add are kept. A matching "Ready to sign out?" card handles the other direction.
- **Forgotten password and username:** all three steps (ask for the email, enter the code, choose a new password) and the username reminder, in the same style and plain English.
- **Register:** a welcome panel beside a clean form card. Labels in plain English ("Your email address", "Choose a password", "Type it once more") and a button that says "Create my account".
- **Thank you:** Joomla shows only a flash message after sign-up. The kit adds a proper "Thank you for registering" page with a clear next step, written to match the site's activation setting.
- **My profile:** a greeting card ("Hello, Sam", member since…) with an Edit button, and tidy cards for the member's details.
- **Edit your details:** separate cards for personal details, password, and two-step sign-in. A field that fails validation turns red, so people can see what to fix.
- **Preferences for staff only:** the editor, time zone, language and dark-mode choices appear only for people who can log in to the administrator. Everyone else simply gets the site's defaults.

### It looks like your site, not ours

There are no fonts in the kit, so text uses the template's own typography. The coloured parts are painted by the template's own Bootstrap classes, so they take the site's primary colour. Borders and muted text follow the current text colour. Everything is rounded, with a short entrance animation that is switched off for visitors who prefer reduced motion.

### Safe by design

The kit is a set of ordinary Joomla **template overrides**. It changes the markup around the forms and nothing else: Joomla's own code still validates and saves registrations and profiles, and captcha, terms-of-use, multi-factor sign-in and flash messages all behave as before. There is no component to replace, no plugin, no JavaScript and no database change. Remove the folders and the site is back to stock.

### Installing it

Download the ZIP, copy one folder (`html`) into the template, and make sure registration and profile menu items exist. The kit carries its own wording and stylesheet, so there is nothing to merge. A step-by-step guide with a troubleshooting table is included. Wording can be edited from Joomla's own Language Overrides screen, which survives updates.

### Tested and honest about its limits

The kit supports **Joomla 5 and 6** and has been tested on fresh installs of **Joomla 5.2.6**, **5.4.10** and **6.2.0** with the stock Cassiopeia template, through 55 automated browser checks on each (Joomla 5.0 and 5.1 should work but were not run): sign-up, sign-in and sign-out, the whole forgotten-password flow, errors, the thank-you page, profile editing, who can see what, headings and landmarks, and no sideways scrolling on a phone. It has not yet been tried with other templates, captcha, passkey sign-in plugins, the optional extra-profile-fields plugin, right-to-left languages or a real dark colour scheme, and Joomla 4 is not a target. Feedback from other templates is the most useful thing anyone can send.

### Built with AI help, in the open

The kit was designed and written with the help of an AI assistant (Claude, from Anthropic), then tested as described above. It is released under the GNU General Public License version 2 or later, the same as Joomla, and the source is open for anyone to inspect, fork and improve.

### Get it

- **Download the latest version (ZIP):** https://github.com/dmlwebal/joomla-friendly-account-pages/releases/latest
- **Source code and install guide:** https://github.com/dmlwebal/joomla-friendly-account-pages (the guide is `INSTALL.md`, also inside the ZIP)
- **Report a problem or share a template:** https://github.com/dmlwebal/joomla-friendly-account-pages/issues

*Friendly Account Pages is an independent project and is not affiliated with or endorsed by the Joomla Project or Open Source Matters, Inc. Joomla® is a registered trademark of Open Source Matters, Inc.*

---

## Short versions

**Social post (under 280 characters):**
Joomla's sign-in, sign-up and profile pages are due a makeover. Friendly Account Pages is a free, drop-in kit: rounded cards, plain-English wording, follows your template's colours and fonts. Joomla 5 and 6, Bootstrap only, no plugin. https://github.com/dmlwebal/joomla-friendly-account-pages

**Forum post (three lines):**
I've released a free set of template overrides that redesign Joomla's sign-in, forgotten-password, registration, thank-you, profile and edit-profile screens (Bootstrap 5 only, Joomla 5 and 6, GPL). Copy one folder into your template; wording is editable via Language Overrides. Tested on stock Cassiopeia; I'd love reports from other templates. Download: https://github.com/dmlwebal/joomla-friendly-account-pages/releases/latest

**One-line description (for directories and the repo):**
Friendly, rounded, plain-English sign-in, forgotten-password, registration and profile pages for Joomla 5 and 6, as Bootstrap-only template overrides.
