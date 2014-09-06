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

namespace WellCommerce\Bundle\AdminMenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class WellCommerceAdminMenuBundle
 *
 * @package WellCommerce\Bundle\AdminMenuBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceAdminMenuBundle extends Bundle
{
    protected function getAssetic_AssetManagerService()
    {
        $a = $this->get('templating.loader');

        $this->services['assetic.asset_manager'] = $instance
            = new \Assetic\Factory\LazyAssetManager($this->get('assetic.asset_factory'), array('twig' => new \Assetic\Factory\Loader\CachedFormulaLoader(new \Assetic\Extension\Twig\TwigFormulaLoader($this->get('twig'), $this->get('monolog.logger.assetic', ContainerInterface::NULL_ON_INVALID_REFERENCE)), new \Assetic\Cache\ConfigCache('D:/Git/WellCommerce/app/cache/dev/assetic/config'), true)));

        $instance->addResource(new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
            0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceCoreBundle/views', '/\\.[^.]+\\.twig$/'),
            1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\CoreBundle/Resources/views', '/\\.[^.]+\\.twig$/'),
            2 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceCoreBundle/themes/web', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\CoreBundle/Resources/themes/web', '/\\.[^.]+\\.twig$/')
                )),
            3 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceCoreBundle/themes/tablet', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\CoreBundle/Resources/themes/tablet', '/\\.[^.]+\\.twig$/')
                )),
            4 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceCoreBundle/themes/phone', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceCoreBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\CoreBundle/Resources/themes/phone', '/\\.[^.]+\\.twig$/')
                ))
        )), 'twig');
        $instance->addResource(new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
            0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceUserBundle/views', '/\\.[^.]+\\.twig$/'),
            1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\UserBundle/Resources/views', '/\\.[^.]+\\.twig$/'),
            2 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceUserBundle/themes/web', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\UserBundle/Resources/themes/web', '/\\.[^.]+\\.twig$/')
                )),
            3 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceUserBundle/themes/tablet', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\UserBundle/Resources/themes/tablet', '/\\.[^.]+\\.twig$/')
                )),
            4 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceUserBundle/themes/phone', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceUserBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\UserBundle/Resources/themes/phone', '/\\.[^.]+\\.twig$/')
                ))
        )), 'twig');
        $instance->addResource(new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
            0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceWebBundle/views', '/\\.[^.]+\\.twig$/'),
            1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\WebBundle/Resources/views', '/\\.[^.]+\\.twig$/'),
            2 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceWebBundle/themes/web', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\WebBundle/Resources/themes/web', '/\\.[^.]+\\.twig$/')
                )),
            3 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceWebBundle/themes/tablet', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\WebBundle/Resources/themes/tablet', '/\\.[^.]+\\.twig$/')
                )),
            4 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
                    0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:/Git/WellCommerce/app/Resources/WellCommerceWebBundle/themes/phone', '/\\.[^.]+\\.twig$/'),
                    1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, 'WellCommerceWebBundle', 'D:\\Git\\WellCommerce\\src\\WellCommerce\\Bundle\\WebBundle/Resources/themes/phone', '/\\.[^.]+\\.twig$/')
                ))
        )), 'twig');
        $instance->addResource(new \Symfony\Bundle\AsseticBundle\Factory\Resource\CoalescingDirectoryResource(array(
            0 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, '', 'D:/Git/WellCommerce/app/Resources/themes/web', '/\\.[^.]+\\.twig$/'),
            1 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, '', 'D:/Git/WellCommerce/app/Resources/themes/tablet', '/\\.[^.]+\\.twig$/'),
            2 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, '', 'D:/Git/WellCommerce/app/Resources/themes/phone', '/\\.[^.]+\\.twig$/'),
            3 => new \Symfony\Bundle\AsseticBundle\Factory\Resource\DirectoryResource($a, '', 'D:/Git/WellCommerce/app/Resources/views', '/\\.[^.]+\\.twig$/')
        )), 'twig');

        return $instance;
    }
}
