<?php

/**
 * Friendly account pages (Bootstrap) - forgotten password, step 2: enter the code from the email.
 *
 * Template override for com_users > reset > confirm.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Joomla's own fields, validation script, task and hidden fields are kept.
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

/** @var \Joomla\Component\Users\Site\View\Reset\HtmlView $this */

$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$form = $this->form;
$form->setFieldAttribute('username', 'label', 'TPL_ACCOUNT_LOGIN_USERNAME_LABEL');
$form->setFieldAttribute('token', 'label', 'TPL_ACCOUNT_RESET_CODE_LABEL');
$form->setFieldAttribute('token', 'description', 'TPL_ACCOUNT_RESET_CODE_HINT');

$controls = $form->renderControlFields();

if (!str_contains($controls, Session::getFormToken())) {
    $controls .= HTMLHelper::_('form.token');
}
?>
<div class="com-users-reset-confirm reset-confirm acct acct-reset my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 acct-reveal">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><span class="icon-envelope"></span></span>
                    <h1 class="h2 fw-semibold text-center mb-2"><?php echo Text::_('TPL_ACCOUNT_RESET_CONFIRM_TITLE'); ?></h1>
                    <p class="text-body-secondary text-center mb-4"><?php echo Text::_('TPL_ACCOUNT_RESET_CONFIRM_LEAD'); ?></p>

                    <form action="<?php echo Route::_('index.php?task=reset.confirm'); ?>" method="post" class="com-users-reset-confirm__form form-validate">
                        <?php foreach ($form->getFieldsets() as $fieldset) : ?>
                            <?php foreach ($form->getFieldset($fieldset->name) as $field) : ?>
                                <?php echo $field->renderField(['class' => 'mb-3']); ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                        <div class="com-users-reset-confirm__submit mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 validate"><?php echo Text::_('TPL_ACCOUNT_RESET_CONFIRM_BUTTON'); ?></button>
                        </div>

                        <?php echo $controls; ?>
                    </form>
                </div>
            </div>

            <p class="acct-switch text-center mt-4 mb-0">
                <a href="<?php echo Route::_('index.php?option=com_users&view=login'); ?>"><?php echo Text::_('TPL_ACCOUNT_BACK_TO_SIGN_IN'); ?></a>
            </p>
        </div>
    </div>
</div>
