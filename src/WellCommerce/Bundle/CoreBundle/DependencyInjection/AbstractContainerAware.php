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

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;

/**
 * Class AbstractContainerAware
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractContainerAware extends ContainerAware
{
    /**
     * Returns true if the service id is defined.
     *
     * @param string $id The service id
     *
     * @return bool true if the service id is defined, false otherwise
     */
    protected function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     *
     * @return object Service
     */
    protected function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * Translates a string using the translation service
     *
     * @param string $id Message to translate
     *
     * @return string The message
     */
    protected function trans($id, $params = [], $domain = TranslatorHelperInterface::DEFAULT_TRANSLATION_DOMAIN)
    {
        return $this->getTranslatorHelper()->trans($id, $params, $domain);
    }

    /**
     * Shortcut to get param from current route
     *
     * @param string $index
     *
     * @return mixed
     */
    protected function getParam($index)
    {
        return $this->container->get('request')->attributes->get($index);
    }

    /**
     * Returns themes directory path
     * If theme folder name is passed, full directory path pointing to it will be returned
     *
     * @param string $themeFolder
     *
     * @return string
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    protected function getThemeDir($themeFolder = '')
    {
        $kernelDir = $this->getKernel()->getRootDir();
        $webDir    = $kernelDir . '/../web';

        if (strlen($themeFolder)) {
            $dir = $webDir . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $themeFolder;
        } else {
            $dir = $webDir . DIRECTORY_SEPARATOR . 'themes';
        }

        if (!is_dir($dir)) {
            throw new FileException(sprintf('Directory "%s" not found.', $dir));
        }

        return $dir;
    }

    /**
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    public function getKernel()
    {
        return $this->get('kernel');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface
     */
    public function getTranslatorHelper()
    {
        return $this->get('translator_helper');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface
     */
    public function getFlashHelper()
    {
        return $this->get('flash_helper');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface
     */
    public function getDoctrineHelper()
    {
        return $this->get('doctrine_helper');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface
     */
    public function getRequestHelper()
    {
        return $this->get('request_helper');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface
     */
    public function getRouterHelper()
    {
        return $this->get('router_helper');
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface
     */
    public function getImageHelper()
    {
        return $this->get('image_helper');
    }

    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public function getValidator()
    {
        return $this->get('validator');
    }

    /**
     * @return \WellCommerce\Bundle\IntlBundle\Entity\Locale[]
     */
    public function getLocales()
    {
        return $this->get('locale.repository')->findAll();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        return $this->getDoctrineHelper()->getEntityManager();
    }
}
