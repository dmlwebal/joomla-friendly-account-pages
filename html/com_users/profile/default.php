<?php

/**
 * Friendly account pages (Bootstrap) - profile (read-only view).
 *
 * Template override for com_users > profile > default.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Layout: a greeting card (initial, "Hello, Sam", member since, Edit button), then "Your details" and
 * "Your preferences" side by side, then any extra profile fields. Joomla's data, access check and edit
 * link are unchanged. Bootstrap 5 classes only.
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Profile\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
// The wording and the stylesheet live in the kit's own folder: templates/<template>/html/account-pages/.
// Site edits made in System > Language Overrides still win over the kit's wording.
$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

$wa = $this->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$name      = trim((string) $this->data->name);
$firstName = $name !== '' ? strtok($name, ' ') : (string) $this->data->username;
$initial   = mb_strtoupper(mb_substr($firstName, 0, 1));
$isOwner   = $this->getCurrentUser()->id == $this->data->id;

// The preferences card is optional (the settings fieldset can be empty); give the details card the full row if so.
$paramsHtml = trim($this->loadTemplate('params'));
$coreCol    = $paramsHtml === '' ? 'col-12' : 'col-md-6';
?>
<div class="com-users-profile profile acct acct-profile my-4 my-md-5">

    <?php // Greeting card. ?>
    <div class="card acct-reveal mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <span class="acct-avatar bg-primary text-white flex-shrink-0" aria-hidden="true"><?php echo $this->escape($initial); ?></span>
                <div class="flex-grow-1">
                    <h1 class="h2 fw-semibold mb-0"><?php echo Text::sprintf('TPL_ACCOUNT_PROFILE_GREETING', $this->escape($firstName)); ?></h1>
                    <p class="text-body-secondary small mb-0">
                        <?php echo Text::sprintf('TPL_ACCOUNT_PROFILE_MEMBER_SINCE', HTMLHelper::_('date', $this->data->registerDate, Text::_('DATE_FORMAT_LC3'))); ?>
                    </p>
                </div>
                <?php if ($isOwner) : ?>
                    <a class="com-users-profile__edit btn btn-outline-primary" href="<?php echo Route::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
                        <span class="icon-pencil" aria-hidden="true"></span>
                        <?php echo Text::_('TPL_ACCOUNT_PROFILE_EDIT_BUTTON'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php // Details and preferences side by side (they stack on small screens). ?>
    <div class="row g-4">
        <div class="<?php echo $coreCol; ?> acct-reveal acct-reveal-2"><?php echo $this->loadTemplate('core'); ?></div>
        <?php if ($paramsHtml !== '') : ?>
            <div class="col-md-6 acct-reveal acct-reveal-3"><?php echo $paramsHtml; ?></div>
        <?php endif; ?>
    </div>

    <?php // Extra fields added by plugins or custom fields. ?>
    <?php echo $this->loadTemplate('custom'); ?>
</div>
