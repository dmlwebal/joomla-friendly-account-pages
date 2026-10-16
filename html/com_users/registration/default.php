<?php

/**
 * Friendly account pages (Bootstrap) - registration form.
 *
 * Template override for com_users > registration > default.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Built with Bootstrap 5 classes only (the framework Joomla core ships), so it needs no extra library.
 * Joomla's own field rendering, validation script, hidden fields and captcha are kept, so
 * registration.register validates and saves exactly as before.
 *
 * Wording: html/account-pages/language/en-GB/en-GB.account_pages.ini (keys start TPL_ACCOUNT_).
 * One <h1> only: the menu item's "Show page heading" option is deliberately ignored.
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Registration\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
// The wording and the stylesheet live in the kit's own folder: templates/<template>/html/account-pages/.
// Site edits made in System > Language Overrides still win over the kit's wording.
$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$form = $this->form;

// Friendly label and hint for each core field: field name => [label key, hint key or null]
$copy = [
    'name'      => ['TPL_ACCOUNT_NAME_LABEL', null],
    'email1'    => ['TPL_ACCOUNT_EMAIL_LABEL', 'TPL_ACCOUNT_EMAIL_HINT'],
    'username'  => ['TPL_ACCOUNT_USERNAME_LABEL', 'TPL_ACCOUNT_USERNAME_HINT'],
    'password1' => ['TPL_ACCOUNT_PASSWORD_LABEL', null],
    'password2' => ['TPL_ACCOUNT_PASSWORD_CONFIRM_LABEL', null],
];

foreach ($copy as $fieldName => [$labelKey, $hintKey]) {
    $form->setFieldAttribute($fieldName, 'label', $labelKey);

    if ($hintKey) {
        $form->setFieldAttribute($fieldName, 'description', $hintKey);
    }
}

// Friendlier order than Joomla's default (email before username); the "* Required field" spacer is dropped.
$order     = ['name', 'email1', 'username', 'password1', 'password2'];
$fieldOpts = ['class' => 'mb-3'];

// Fieldsets added by plugins (terms of use, profile fields, consent...) are shown after the core fields.
$extraFieldsets = array_diff(array_keys($form->getFieldsets()), ['default', 'captcha']);

$perks = [
    ['lock', 'TPL_ACCOUNT_PERK_1_TITLE', 'TPL_ACCOUNT_PERK_1_TEXT'],
    ['heart', 'TPL_ACCOUNT_PERK_2_TITLE', 'TPL_ACCOUNT_PERK_2_TEXT'],
    ['bolt', 'TPL_ACCOUNT_PERK_3_TITLE', 'TPL_ACCOUNT_PERK_3_TEXT'],
];
?>
<div class="com-users-registration registration acct acct-register my-4 my-md-5">
    <div class="row g-4 justify-content-center">

        <?php // Welcome panel: heading, a warm line and three reasons to join (reasons hidden on small screens). ?>
        <div class="col-md-5 col-lg-4 acct-reveal">
            <div class="card acct-welcome text-bg-primary">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="display-6 fw-semibold mb-3"><?php echo Text::_('TPL_ACCOUNT_REGISTER_TITLE'); ?></h1>
                    <p class="lead mb-0"><?php echo Text::_('TPL_ACCOUNT_REGISTER_LEAD'); ?></p>

                    <ul class="list-unstyled d-none d-md-block mt-4 mb-0">
                        <?php foreach ($perks as [$icon, $titleKey, $textKey]) : ?>
                            <li class="d-flex gap-3 mb-3">
                                <?php // Joomla's own icon font (icon-*): already on the page, nothing extra to load. ?>
                                <span class="acct-chip flex-shrink-0 rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center" aria-hidden="true"><span class="icon-<?php echo $icon; ?>"></span></span>
                                <div>
                                    <p class="fw-semibold mb-0"><?php echo Text::_($titleKey); ?></p>
                                    <p class="mb-0 opacity-75"><?php echo Text::_($textKey); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php // The form itself. ?>
        <div class="col-md-7 col-lg-8 acct-reveal acct-reveal-2">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="h4 fw-semibold mb-1"><?php echo Text::_('TPL_ACCOUNT_REGISTER_FORM_TITLE'); ?></h2>
                    <p class="text-body-secondary mb-4"><?php echo Text::_('TPL_ACCOUNT_REGISTER_FORM_LEAD'); ?></p>

                    <form id="member-registration" action="<?php echo Route::_('index.php?task=registration.register'); ?>" method="post" class="com-users-registration__form form-validate" enctype="multipart/form-data">
                        <?php foreach ($order as $fieldName) : ?>
                            <?php echo $form->renderField($fieldName, null, null, $fieldOpts); ?>
                        <?php endforeach; ?>

                        <?php foreach ($extraFieldsets as $fieldsetName) : ?>
                            <?php echo $form->renderFieldset($fieldsetName); ?>
                        <?php endforeach; ?>

                        <?php if ($this->captchaEnabled) : ?>
                            <?php echo $form->renderFieldset('captcha'); ?>
                        <?php endif; ?>

                        <div class="com-users-registration__submit mt-4">
                            <?php // The "validate" class is what makes Joomla's form.validate script check the form on click. ?>
                            <button type="submit" class="com-users-registration__register btn btn-primary btn-lg w-100 validate">
                                <?php echo Text::_('TPL_ACCOUNT_REGISTER_BUTTON'); ?>
                            </button>
                            <input type="hidden" name="option" value="com_users">
                            <input type="hidden" name="task" value="registration.register">
                        </div>

                        <?php echo $form->renderControlFields(); ?>
                    </form>
                </div>
            </div>

            <p class="acct-switch text-center mt-4 mb-0">
                <?php echo Text::_('TPL_ACCOUNT_REGISTER_HAVE_ACCOUNT'); ?>
                <a href="<?php echo Route::_('index.php?option=com_users&view=login'); ?>"><?php echo Text::_('TPL_ACCOUNT_REGISTER_SIGN_IN'); ?></a>
            </p>
        </div>
    </div>
</div>
