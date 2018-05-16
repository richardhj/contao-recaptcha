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

namespace Richardhj\ContaoReCaptchaBundle\ContaoManager;


use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Config\ConfigInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Richardhj\ContaoReCaptchaBundle\RichardhjContaoReCaptchaBundle;

class Plugin implements BundlePluginInterface
{

    /**
     * Gets a list of autoload configurations for this bundle.
     *
     * @param ParserInterface $parser
     *
     * @return ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RichardhjContaoReCaptchaBundle::class)
                ->setLoadAfter(
                    [
                        ContaoCoreBundle::class,
                    ]
                ),
        ];
    }
}