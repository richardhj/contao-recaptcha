<?php

/**
 * This file is part of richardhj/contao-recaptcha.
 *
 * Copyright (c) 2018-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-recaptcha
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2018-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-recaptcha/blob/master/LICENSE LGPL-3.0
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes'] .= ';{recaptcha_legend},reCaptchaSiteKey,reCaptchaSecret';

$GLOBALS['TL_DCA']['tl_settings']['fields']['reCaptchaSiteKey'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['reCaptchaSiteKey'],
    'inputType' => 'text',
    'eval'      => [
        'tl_class' => 'w50',
    ],
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['reCaptchaSecret']  = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['reCaptchaSecret'],
    'inputType' => 'text',
    'eval'      => [
        'tl_class' => 'w50',
    ],
];
