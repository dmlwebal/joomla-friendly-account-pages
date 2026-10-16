<?php

/**
 * Friendly account pages (Bootstrap) - "thank you for registering" page.
 *
 * Template override for com_users > registration > complete.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Joomla's own file prints nothing but the flash messages. This adds a heading and a plain next step,
 * chosen by the site's "New User Account Activation" setting (Users > Options):
 *   1 = the person must click a link in an email, 2 = the link, then an administrator approves.
 * (With 0 = none Joomla goes straight to the login page and never shows this page.)
 * Joomla's own flash messages still appear above it.
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
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
$wa->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$activation = (int) ComponentHelper::getParams('com_users')->get('useractivation');
$leadKey    = $activation === 2 ? 'TPL_ACCOUNT_COMPLETE_LEAD_ADMIN' : 'TPL_ACCOUNT_COMPLETE_LEAD_EMAIL';
?>
<div class="com-users-registration-complete registration-complete acct acct-complete my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 acct-reveal">
            <div class="card text-center">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><span class="icon-check"></span></span>
                    <h1 class="h2 fw-semibold mb-3"><?php echo Text::_('TPL_ACCOUNT_COMPLETE_TITLE'); ?></h1>
                    <p class="lead"><?php echo Text::_($leadKey); ?></p>
                    <p class="text-body-secondary small"><?php echo Text::_('TPL_ACCOUNT_COMPLETE_JUNK'); ?></p>
                    <a class="btn btn-outline-primary mt-2" href="<?php echo Route::_('index.php'); ?>"><?php echo Text::_('TPL_ACCOUNT_COMPLETE_HOME'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
