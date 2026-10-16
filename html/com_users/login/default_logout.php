<?php

/**
 * Friendly account pages (Bootstrap) - sign-out confirmation.
 *
 * Template override for com_users > login > default_logout (shown when a signed-in person opens the
 * login page or a "Logout" menu item). Part of Friendly Account Pages: copy the kit's whole `html`
 * folder into templates/<your template>/.
 *
 * Joomla's own sign-out form, redirect fields and token are kept. The menu item's description and
 * image options still show above the button.
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

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $this */

$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$name      = trim((string) $this->user->name);
$firstName = $name !== '' ? strtok($name, ' ') : (string) $this->user->username;
$initial   = mb_strtoupper(mb_substr($firstName, 0, 1));

$hasDescription = ($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description', '')) != '')
    || $this->params->get('logout_image') != '';
?>
<div class="com-users-logout logout acct acct-logout my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 acct-reveal">
            <div class="card text-center">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><?php echo $this->escape($initial); ?></span>
                    <h1 class="h2 fw-semibold mb-2"><?php echo Text::_('TPL_ACCOUNT_LOGOUT_TITLE'); ?></h1>
                    <p class="text-body-secondary mb-4"><?php echo Text::sprintf('TPL_ACCOUNT_LOGOUT_LEAD', $this->escape($firstName)); ?></p>

                    <?php if ($hasDescription) : ?>
                        <div class="com-users-logout__description logout-description mb-4">
                            <?php if ($this->params->get('logoutdescription_show') == 1) : ?>
                                <?php echo $this->params->get('logout_description'); ?>
                            <?php endif; ?>
                            <?php if ($this->params->get('logout_image') != '') : ?>
                                <?php echo HTMLHelper::_('image', $this->params->get('logout_image'), empty($this->params->get('logout_image_alt')) && empty($this->params->get('logout_image_alt_empty')) ? false : $this->params->get('logout_image_alt'), ['class' => 'com-users-logout__image logout-image img-fluid']); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo Route::_('index.php?task=user.logout'); ?>" method="post" class="com-users-logout__form">
                        <div class="com-users-logout__submit">
                            <button type="submit" class="btn btn-primary btn-lg w-100"><?php echo Text::_('TPL_ACCOUNT_LOGOUT_BUTTON'); ?></button>
                        </div>
                        <?php if ($this->params->get('logout_redirect_url')) : ?>
                            <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return', null, ''))); ?>">
                        <?php else : ?>
                            <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_menuitem', $this->form->getValue('return', null, ''))); ?>">
                        <?php endif; ?>
                        <?php echo HTMLHelper::_('form.token'); ?>
                    </form>

                    <p class="small mt-4 mb-0"><a href="<?php echo Route::_('index.php?option=com_users&view=profile'); ?>"><?php echo Text::_('TPL_ACCOUNT_LOGOUT_STAY'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
