<?php

/**
 * Friendly account pages (Bootstrap) - sign-in form.
 *
 * Template override for com_users > login > default_login.
 * Part of Friendly Account Pages: copy the kit's whole `html` folder into templates/<your template>/.
 *
 * Joomla's own field rendering, validation script, remember-me option, extra sign-in buttons (passkeys and
 * other login plugins), redirect field and form token are all kept, so signing in works exactly as before.
 * The menu item's description and image options still show above the form.
 * Joomla 5.4 and 6.x differ slightly in how the hidden fields are printed; both are handled below.
 *
 * Wording: html/account-pages/language/en-GB/en-GB.account_pages.ini (keys start TPL_ACCOUNT_).
 * One <h1> only: the menu item's "Show page heading" option is deliberately ignored.
 *
 * @license  GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $this */

// The wording and the stylesheet live in the kit's own folder: templates/<template>/html/account-pages/.
// Site edits made in System > Language Overrides still win over the kit's wording.
$acctTemplate = Factory::getApplication()->getTemplate();
$this->getLanguage()->load('account_pages', JPATH_THEMES . '/' . $acctTemplate . '/html/account-pages');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->registerAndUseStyle('acct.pages', 'templates/' . $acctTemplate . '/html/account-pages/account-pages.css');

$form = $this->form;

$form->setFieldAttribute('username', 'label', 'TPL_ACCOUNT_LOGIN_USERNAME_LABEL');
$form->setFieldAttribute('password', 'label', 'TPL_ACCOUNT_LOGIN_PASSWORD_LABEL');

$usersConfig = ComponentHelper::getParams('com_users');
$fieldOpts   = ['class' => 'mb-3 com-users-login__input'];

$hasDescription = ($this->params->get('logindescription_show') == 1 && trim($this->params->get('login_description', '')))
    || $this->params->get('login_image') != '';

// "Create an account" link: same rules as Joomla's own page (registration on, optional custom menu item).
$regLink = '';

if ($usersConfig->get('allowUserRegistration')) {
    $regLink       = 'index.php?option=com_users&view=registration';
    $regLinkMenuId = $this->params->get('customRegLinkMenu');

    if ($regLinkMenuId && Factory::getApplication()->getMenu()->getItem($regLinkMenuId)) {
        $regLink = 'index.php?Itemid=' . $regLinkMenuId;
    }
}

// Hidden fields. Joomla 5.3+ and 6 print the redirect and token through the form object; older Joomla 5 templates
// print them in the template. Add whichever is missing so every version works.
$controls = method_exists($form, 'renderControlFields') ? $form->renderControlFields() : '';

if (!str_contains($controls, 'name="return"')) {
    $return    = $form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem', '')));
    $controls .= '<input type="hidden" name="return" value="' . base64_encode($return) . '">';
}

if (!str_contains($controls, Session::getFormToken())) {
    $controls .= HTMLHelper::_('form.token');
}
?>
<div class="com-users-login login acct acct-login my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 acct-reveal">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    <span class="acct-avatar bg-primary text-white mx-auto mb-4" aria-hidden="true"><span class="icon-lock"></span></span>
                    <h1 class="h2 fw-semibold text-center mb-2"><?php echo Text::_('TPL_ACCOUNT_LOGIN_TITLE'); ?></h1>
                    <p class="text-body-secondary text-center mb-4"><?php echo Text::_('TPL_ACCOUNT_LOGIN_LEAD'); ?></p>

                    <?php if ($hasDescription) : ?>
                        <div class="com-users-login__description login-description mb-4">
                            <?php if ($this->params->get('logindescription_show') == 1) : ?>
                                <?php echo $this->params->get('login_description'); ?>
                            <?php endif; ?>
                            <?php if ($this->params->get('login_image') != '') : ?>
                                <?php echo HTMLHelper::_('image', $this->params->get('login_image'), empty($this->params->get('login_image_alt')) && empty($this->params->get('login_image_alt_empty')) ? false : $this->params->get('login_image_alt'), ['class' => 'com-users-login__image login-image img-fluid']); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo Route::_('index.php?task=user.login'); ?>" method="post" id="com-users-login__form" class="com-users-login__form form-validate">
                        <?php foreach ($form->getFieldset('credentials') as $field) : ?>
                            <?php echo $field->renderField($fieldOpts); ?>
                        <?php endforeach; ?>

                        <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
                            <div class="com-users-login__remember form-check mb-4">
                                <input class="form-check-input" id="remember" type="checkbox" name="remember" value="yes">
                                <label class="form-check-label" for="remember"><?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?></label>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($this->extraButtons as $button) :
                            $dataAttributeKeys = array_filter(array_keys($button), function ($key) {
                                return substr($key, 0, 5) == 'data-';
                            });
                            ?>
                            <div class="com-users-login__submit mb-3">
                                <button type="button"
                                        class="btn btn-outline-secondary w-100 <?php echo $button['class'] ?? '' ?>"
                                        <?php foreach ($dataAttributeKeys as $key) : ?>
                                            <?php echo $key ?>="<?php echo $button[$key] ?>"
                                        <?php endforeach; ?>
                                        <?php if (!empty($button['onclick'])) : ?>
                                        onclick="<?php echo $button['onclick'] ?>"
                                        <?php endif; ?>
                                        title="<?php echo Text::_($button['label']) ?>"
                                        id="<?php echo $button['id'] ?>"
                                >
                                    <?php if (!empty($button['icon'])) : ?>
                                        <span class="<?php echo $button['icon'] ?>"></span>
                                    <?php elseif (!empty($button['image'])) : ?>
                                        <?php echo HTMLHelper::_('image', $button['image'], Text::_($button['tooltip'] ?? ''), [
                                            'class' => 'icon',
                                        ], true) ?>
                                    <?php elseif (!empty($button['svg'])) : ?>
                                        <?php echo $button['svg']; ?>
                                    <?php endif; ?>
                                    <?php echo Text::_($button['label']) ?>
                                </button>
                            </div>
                        <?php endforeach; ?>

                        <div class="com-users-login__submit">
                            <button type="submit" class="btn btn-primary btn-lg w-100"><?php echo Text::_('TPL_ACCOUNT_LOGIN_BUTTON'); ?></button>
                        </div>

                        <?php echo $controls; ?>
                    </form>

                    <p class="com-users-login__options d-flex flex-wrap justify-content-center column-gap-4 row-gap-1 small mt-4 mb-0">
                        <a class="com-users-login__reset text-nowrap" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>"><?php echo Text::_('TPL_ACCOUNT_LOGIN_FORGOT_PASSWORD'); ?></a>
                        <a class="com-users-login__remind text-nowrap" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>"><?php echo Text::_('TPL_ACCOUNT_LOGIN_FORGOT_USERNAME'); ?></a>
                    </p>
                </div>
            </div>

            <?php if ($regLink !== '') : ?>
                <p class="com-users-login__register acct-switch text-center mt-4 mb-0">
                    <?php echo Text::_('TPL_ACCOUNT_LOGIN_NEW_HERE'); ?>
                    <a href="<?php echo Route::_($regLink); ?>"><?php echo Text::_('TPL_ACCOUNT_LOGIN_CREATE_ACCOUNT'); ?></a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
