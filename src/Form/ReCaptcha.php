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

namespace Richardhj\ContaoReCaptchaBundle\Form;


use Contao\Config;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use Contao\Widget;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\TranslatorInterface;

class ReCaptcha extends Widget
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $reCaptchaSecret;

    /**
     * @var string
     */
    protected $reCaptchaSiteKey;

    /**
     * ReCaptcha constructor.
     *
     * @param null $attributes
     *
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    public function __construct($attributes = null)
    {
        parent::__construct($attributes);

        $this->strTemplate      = 'form_recaptcha';
        $this->reCaptchaSiteKey = Config::get('reCaptchaSiteKey');
        $this->reCaptchaSecret  = Config::get('reCaptchaSecret');
        $this->logger           = System::getContainer()->get('monolog.logger.contao');
        $this->requestStack     = System::getContainer()->get('request_stack');
        $this->translator       = System::getContainer()->get('translator');
    }

    /**
     * @param mixed $input
     *
     * @return string
     *
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     */
    public function validator($input): string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            $this->addError($this->translator->trans('ERR.recaptcha', [], 'contao_default'));

            return '';
        }

        $responseCode = $request->request->get('g-recaptcha-response');
        $reCaptcha    = new GoogleReCaptcha($this->reCaptchaSecret);
        $response     = $reCaptcha->verify($responseCode);

        if (false === $response->isSuccess()) {
            $errors = $response->getErrorCodes();

            $this->logger->log(
                LogLevel::ERROR,
                'Error processing Google reCAPTCHA: '.var_export($errors, true),
                array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
            );

            $this->addError($this->translator->trans('ERR.recaptcha', [], 'contao_default'));
        }

        return '';
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate(): string
    {
        return
            '<div class="g-recaptcha" id="recaptcha-'.$this->id.'" data-sitekey="'.$this->reCaptchaSiteKey.'"></div>';
    }
}