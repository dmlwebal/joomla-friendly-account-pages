<?php

/**
 * Friendly account pages (Bootstrap) - profile view: "Your details" card (name, username, email, dates).
 * Template override for com_users > profile > default_core.
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\Users\Site\View\Profile\HtmlView $this */

// The email address is only shown to the account owner.
$isOwner = $this->getCurrentUser()->id == $this->data->id;
?>
<section id="users-profile-core" class="com-users-profile__core card h-100" aria-labelledby="acct-details-title">
    <div class="card-body p-4">
        <h2 id="acct-details-title" class="h5 fw-semibold mb-4"><?php echo Text::_('TPL_ACCOUNT_PROFILE_DETAILS_TITLE'); ?></h2>
        <dl class="acct-dl">
            <div>
                <dt><?php echo Text::_('TPL_ACCOUNT_PROFILE_LABEL_NAME'); ?></dt>
                <dd><?php echo $this->escape($this->data->name); ?></dd>
            </div>
            <div>
                <dt><?php echo Text::_('TPL_ACCOUNT_PROFILE_LABEL_USERNAME'); ?></dt>
                <dd><?php echo $this->escape($this->data->username); ?></dd>
            </div>
            <?php if ($isOwner && !empty($this->data->email)) : ?>
                <div>
                    <dt><?php echo Text::_('TPL_ACCOUNT_PROFILE_LABEL_EMAIL'); ?></dt>
                    <dd><?php echo $this->escape($this->data->email); ?></dd>
                </div>
            <?php endif; ?>
            <div>
                <dt><?php echo Text::_('TPL_ACCOUNT_PROFILE_LABEL_LAST_VISIT'); ?></dt>
                <dd>
                    <?php if ($this->data->lastvisitDate !== null) : ?>
                        <?php echo HTMLHelper::_('date', $this->data->lastvisitDate, Text::_('DATE_FORMAT_LC3')); ?>
                    <?php else : ?>
                        <?php echo Text::_('TPL_ACCOUNT_PROFILE_FIRST_VISIT'); ?>
                    <?php endif; ?>
                </dd>
            </div>
        </dl>
    </div>
</section>
