<?php

/**
 * Friendly account pages (Bootstrap) - profile view: "Your preferences" card (editor, time zone, language, dark mode).
 * Template override for com_users > profile > default_params.
 * Outputs nothing when the settings fieldset has no visible fields (default.php then widens the details card).
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\Users\Site\View\Profile\HtmlView $this */

// Preferences (editor, time zone, language, dark mode) are for staff only: anyone who may log in to the
// administrator, which by default means Manager, Administrator and Super User. Change the permission name
// below to use a different rule (for example 'core.manage' on 'com_users'). Everyone else gets the site
// defaults, and their saved values are left untouched.
if (!$this->getCurrentUser()->authorise('core.login.admin')) {
    return;
}

$fields = $this->form->getFieldset('params');
?>
<?php if (count($fields)) : ?>
    <section id="users-profile-custom" class="com-users-profile__params card h-100" aria-labelledby="acct-prefs-title">
        <div class="card-body p-4">
            <h2 id="acct-prefs-title" class="h5 fw-semibold mb-4"><?php echo Text::_('TPL_ACCOUNT_PROFILE_PREFS_TITLE'); ?></h2>
            <dl class="acct-dl">
                <?php foreach ($fields as $field) : ?>
                    <?php if (!$field->hidden) : ?>
                        <div>
                            <dt><?php echo $field->title; ?></dt>
                            <dd>
                                <?php if (HTMLHelper::isRegistered('users.' . $field->id)) : ?>
                                    <?php echo HTMLHelper::_('users.' . $field->id, $field->value); ?>
                                <?php elseif (HTMLHelper::isRegistered('users.' . $field->fieldname)) : ?>
                                    <?php echo HTMLHelper::_('users.' . $field->fieldname, $field->value); ?>
                                <?php elseif (HTMLHelper::isRegistered('users.' . $field->type)) : ?>
                                    <?php echo HTMLHelper::_('users.' . $field->type, $field->value); ?>
                                <?php else : ?>
                                    <?php echo HTMLHelper::_('users.value', $field->value); ?>
                                <?php endif; ?>
                            </dd>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>
<?php endif; ?>
