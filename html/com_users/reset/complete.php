<?php

/**
 * Friendly account pages (Bootstrap) - forgotten password, step 3: choose a new password.
 *
 * Template override for com_users > reset > complete.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Joomla's own fields (with its password-strength hint), validation script, task and token are kept.
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

/** @var \Joomla\Component\Users\Site\View\Reset\HtmlView $this */

$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$form = $this->form;
$form->setFieldAttribute('password1', 'label', 'TPL_ACCOUNT_PASSWORD_NEW_LABEL');
$form->setFieldAttribute('password2', 'label', 'TPL_ACCOUNT_PASSWORD_CONFIRM_LABEL');
?>
<div class="com-users-reset-complete reset-complete acct acct-reset my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 acct-reveal">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><span class="icon-lock"></span></span>
                    <h1 class="h2 fw-semibold text-center mb-2"><?php echo Text::_('TPL_ACCOUNT_RESET_COMPLETE_TITLE'); ?></h1>
                    <p class="text-body-secondary text-center mb-4"><?php echo Text::_('TPL_ACCOUNT_RESET_COMPLETE_LEAD'); ?></p>

                    <form action="<?php echo Route::_('index.php?task=reset.complete'); ?>" method="post" class="com-users-reset-complete__form form-validate">
                        <?php foreach ($form->getFieldsets() as $fieldset) : ?>
                            <?php foreach ($form->getFieldset($fieldset->name) as $field) : ?>
                                <?php echo $field->renderField(['class' => 'mb-3']); ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                        <div class="com-users-reset-complete__submit mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 validate"><?php echo Text::_('TPL_ACCOUNT_RESET_COMPLETE_BUTTON'); ?></button>
                        </div>

                        <?php echo HTMLHelper::_('form.token'); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
