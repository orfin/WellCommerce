<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\AdminBundle\Helper\Admin\AdminHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Mailer\MailerHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Templating\TemplatingHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Validator\ValidatorHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\PaymentBundle\Helper\PaymentMethodHelperInterface;

/**
 * Class AbstractContainerAware
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractContainerAware
{
    use ContainerAwareTrait;

    public function has(string $id) : bool
    {
        return $this->container->has($id);
    }

    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function trans(string $id, array $params = [], string $domain = TranslatorHelperInterface::DEFAULT_TRANSLATION_DOMAIN) : string
    {
        return $this->getTranslatorHelper()->trans($id, $params, $domain);
    }

    public function getThemeDir(string $themeFolder = '') : string
    {
        $kernelDir = $this->getKernel()->getRootDir();
        $webDir    = $kernelDir . '/../web';
        $dir       = $webDir . DIRECTORY_SEPARATOR . 'themes' . (strlen($themeFolder) ? DIRECTORY_SEPARATOR . $themeFolder : '');

        if (!is_dir($dir)) {
            throw new FileException(sprintf('Directory "%s" not found.', $dir));
        }

        return $dir;
    }

    public function getKernel() : KernelInterface
    {
        return $this->get('kernel');
    }

    public function getTranslatorHelper() : TranslatorHelperInterface
    {
        return $this->get('translator.helper');
    }

    public function getFlashHelper() : FlashHelperInterface
    {
        return $this->get('flash.helper');
    }

    public function getDoctrineHelper() : DoctrineHelperInterface
    {
        return $this->get('doctrine.helper');
    }

    public function getRequestHelper() : RequestHelperInterface
    {
        return $this->get('request.helper');
    }

    public function getRouterHelper() : RouterHelperInterface
    {
        return $this->get('router.helper');
    }

    public function getImageHelper() : ImageHelperInterface
    {
        return $this->get('image.helper');
    }

    public function getLocales() : array
    {
        return $this->get('locale.repository')->findAll();
    }

    public function getCurrencyHelper() : CurrencyHelperInterface
    {
        return $this->get('currency.helper');
    }

    public function getSecurityHelper() : AdminHelperInterface
    {
        return $this->get('admin.helper');
    }

    public function getMailerHelper() : MailerHelperInterface
    {
        return $this->get('mailer.helper');
    }

    public function getTemplatingHelper() : TemplatingHelperInterface
    {
        return $this->get('templating.helper');
    }

    public function getValidatorHelper() : ValidatorHelperInterface
    {
        return $this->get('validator.helper');
    }

    public function getEntityManager() : ObjectManager
    {
        return $this->getDoctrineHelper()->getEntityManager();
    }

    /**
     * @return object|null
     */
    public function getUser()
    {
        return $this->getSecurityHelper()->getUser();
    }
}
