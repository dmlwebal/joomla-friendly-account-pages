<?php

/**
 * Friendly account pages (Bootstrap) - forgotten password, step 1: ask for the email address.
 *
 * Template override for com_users > reset > default.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Joomla's own fields, validation script, task and hidden fields are kept (Joomla 5.4 and 6.x differ
 * slightly in how the token is printed; both are handled below). The text above the field is the kit's
 * wording, not the field set's description, so it can be edited in System > Language Overrides.
 *
 * Wording: html/account-pages/language/en-GB/en-GB.account_pages.ini (keys start TPL_ACCOUNT_).
 * One <h1> only: the menu item's "Show page heading" option is deliberately ignored.
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
$form->setFieldAttribute('email', 'label', 'TPL_ACCOUNT_EMAIL_LABEL');

$controls = $form->renderControlFields();

if (!str_contains($controls, Session::getFormToken())) {
    $controls .= HTMLHelper::_('form.token');
}
?>
<div class="com-users-reset reset acct acct-reset my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 acct-reveal">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><span class="icon-key"></span></span>
                    <h1 class="h2 fw-semibold text-center mb-2"><?php echo Text::_('TPL_ACCOUNT_RESET_TITLE'); ?></h1>
                    <p class="text-body-secondary text-center mb-4"><?php echo Text::_('TPL_ACCOUNT_RESET_LEAD'); ?></p>

                    <form action="<?php echo Route::_('index.php?task=reset.request'); ?>" method="post" id="user-registration" class="com-users-reset__form form-validate">
                        <?php foreach ($form->getFieldsets() as $fieldset) : ?>
                            <?php foreach ($form->getFieldset($fieldset->name) as $field) : ?>
                                <?php echo $field->renderField(['class' => 'mb-3']); ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                        <div class="com-users-reset__submit mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 validate"><?php echo Text::_('TPL_ACCOUNT_RESET_BUTTON'); ?></button>
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
