<?php

/**
 * Friendly account pages (Bootstrap) - edit your profile.
 *
 * Template override for com_users > profile > edit.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Layout: heading and one line of reassurance, then "About you" and "Change your password" side by side,
 * then any other fieldsets (preferences, plugin fields) and the extra-security (MFA) panel, each as a card,
 * then Save / Cancel. Joomla's renderField() output, form.validate script, task values (profile.save /
 * profile.cancel), hidden fields and the MFA panel are unchanged, so saving works exactly as before.
 * Bootstrap 5 classes only.
 *
 * Wording: html/account-pages/language/en-GB/en-GB.account_pages.ini (keys start TPL_ACCOUNT_).
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/** @var Joomla\Component\Users\Site\View\Profile\HtmlView $this */

HTMLHelper::_('bootstrap.tooltip', '.hasTooltip');

// Load user_profile plugin language
$lang = $this->getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

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

// Joomla 5.3+ and 6 print the hidden fields (task, token) through the form object; older 5.x templates print the token themselves.
$controls = method_exists($form, 'renderControlFields') ? $form->renderControlFields() : '';

if (!str_contains($controls, Session::getFormToken())) {
    $controls .= HTMLHelper::_('form.token');
}

// Friendly label and hint for the core fields: field name => [label key, hint key or null]
$copy = [
    'name'      => ['TPL_ACCOUNT_NAME_LABEL', null],
    'email1'    => ['TPL_ACCOUNT_EMAIL_LABEL', 'TPL_ACCOUNT_EMAIL_HINT'],
    'password1' => ['TPL_ACCOUNT_PASSWORD_NEW_LABEL', null],
    'password2' => ['TPL_ACCOUNT_PASSWORD_CONFIRM_LABEL', null],
];

foreach ($copy as $fieldName => [$labelKey, $hintKey]) {
    $form->setFieldAttribute($fieldName, 'label', $labelKey);

    if ($hintKey) {
        $form->setFieldAttribute($fieldName, 'description', $hintKey);
    }
}

$fieldOpts = ['class' => 'mb-3'];

// "About you" = name, email, username (read-only) plus any other field a plugin put in the core fieldset.
$passwordFields = ['password1', 'password2'];
$aboutFirst     = ['name', 'email1', 'username'];
$coreNames      = [];

foreach ($form->getFieldset('core') as $coreField) {
    $coreNames[] = $coreField->fieldname;
}

$aboutFields = array_merge(
    $aboutFirst,
    array_diff($coreNames, $aboutFirst, $passwordFields)   // includes the hidden "id" field, which renders as a bare input
);

// Every other fieldset (preferences, plugin fields) becomes its own card after the first row.
$otherFieldsets = $form->getFieldsets();
unset($otherFieldsets['core']);

// Preferences (editor, time zone, language, dark mode) are for staff only: anyone who may log in to the
// administrator, which by default means Manager, Administrator and Super User. Change the permission name
// below to use a different rule (for example 'core.manage' on 'com_users'). Everyone else gets the site
// defaults, and their saved values are left untouched.
if (!$this->getCurrentUser()->authorise('core.login.admin')) {
    unset($otherFieldsets['params']);
}
?>
<div class="com-users-profile__edit profile-edit acct acct-edit my-4 my-md-5">

    <div class="mb-4">
        <h1 class="display-6 fw-semibold mb-2"><?php echo Text::_('TPL_ACCOUNT_EDIT_TITLE'); ?></h1>
        <p class="lead text-body-secondary mb-0"><?php echo Text::_('TPL_ACCOUNT_EDIT_LEAD'); ?></p>
    </div>

    <form id="member-profile" action="<?php echo Route::_('index.php'); ?>" method="post" class="com-users-profile__edit-form form-validate" enctype="multipart/form-data">

        <?php // First row: about you + password. ?>
        <div class="row g-4">
            <div class="col-md-6 acct-reveal">
                <section class="card h-100" aria-labelledby="acct-about-title">
                    <div class="card-body p-4">
                        <h2 id="acct-about-title" class="h5 fw-semibold mb-4"><?php echo Text::_('TPL_ACCOUNT_EDIT_ABOUT_TITLE'); ?></h2>
                        <?php foreach ($aboutFields as $fieldName) : ?>
                            <?php echo $form->renderField($fieldName, null, null, $fieldOpts); ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
            <div class="col-md-6 acct-reveal acct-reveal-2">
                <section class="card h-100" aria-labelledby="acct-password-title">
                    <div class="card-body p-4">
                        <h2 id="acct-password-title" class="h5 fw-semibold mb-2"><?php echo Text::_('TPL_ACCOUNT_EDIT_PASSWORD_TITLE'); ?></h2>
                        <p class="text-body-secondary small mb-4"><?php echo Text::_('TPL_ACCOUNT_EDIT_PASSWORD_LEAD'); ?></p>
                        <?php foreach ($passwordFields as $fieldName) : ?>
                            <?php echo $form->renderField($fieldName, null, null, $fieldOpts); ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>

        <?php // Preferences and any plugin fieldsets. ?>
        <?php foreach ($otherFieldsets as $group => $fieldset) : ?>
            <?php $fields = $form->getFieldset($group); ?>
            <?php if (count($fields)) : ?>
                <?php // The settings fieldset gets a friendlier title; other fieldsets keep their own label. ?>
                <?php $title = $group === 'params' ? Text::_('TPL_ACCOUNT_PREFS_TITLE') : (isset($fieldset->label) ? Text::_($fieldset->label) : ''); ?>
                <section class="card mt-4 acct-reveal acct-reveal-3" <?php echo $title !== '' ? 'aria-labelledby="acct-group-' . $this->escape($group) . '"' : ''; ?>>
                    <div class="card-body p-4">
                        <?php if ($title !== '') : ?>
                            <h2 id="acct-group-<?php echo $this->escape($group); ?>" class="h5 fw-semibold mb-4"><?php echo $title; ?></h2>
                        <?php endif; ?>
                        <?php if ($group === 'params') : ?>
                            <p class="text-body-secondary small mb-4"><?php echo Text::_('TPL_ACCOUNT_PREFS_NOTE'); ?></p>
                        <?php endif; ?>
                        <?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
                            <p class="text-body-secondary small"><?php echo $this->escape(Text::_($fieldset->description)); ?></p>
                        <?php endif; ?>
                        <div class="row g-3 acct-prefs">
                            <?php foreach ($fields as $field) : ?>
                                <?php if ($field->hidden) : ?>
                                    <?php echo $field->input; ?>
                                <?php else : ?>
                                    <div class="col-md-6"><?php echo $field->renderField(); ?></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php // Extra security (multi-factor authentication): Joomla's own panel, wrapped in the same card. ?>
        <?php if ($this->mfaConfigurationUI) : ?>
            <section class="com-users-profile__multifactor card mt-4" aria-labelledby="acct-security-title">
                <div class="card-body p-4">
                    <h2 id="acct-security-title" class="h5 fw-semibold mb-4"><?php echo Text::_('TPL_ACCOUNT_EDIT_SECURITY_TITLE'); ?></h2>
                    <?php echo $this->mfaConfigurationUI; ?>
                </div>
            </section>
        <?php endif; ?>

        <div class="com-users-profile__edit-submit d-flex flex-wrap align-items-center gap-3 mt-5">
            <button type="submit" class="btn btn-primary btn-lg validate" name="task" value="profile.save">
                <span class="icon-check" aria-hidden="true"></span>
                <?php echo Text::_('TPL_ACCOUNT_EDIT_SAVE'); ?>
            </button>
            <button type="submit" class="btn btn-link link-secondary" name="task" value="profile.cancel" formnovalidate>
                <?php echo Text::_('TPL_ACCOUNT_EDIT_CANCEL'); ?>
            </button>
            <input type="hidden" name="option" value="com_users">
        </div>

        <?php echo $controls; ?>
    </form>
</div>
