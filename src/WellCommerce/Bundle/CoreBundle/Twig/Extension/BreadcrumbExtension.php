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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Breadcrumb\Provider\BreadcrumbProviderInterface;

/**
 * Class BreadcrumbExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var BreadcrumbProviderInterface
     */
    private $provider;

    /**
     * BreadcrumbExtension constructor.
     *
     * @param BreadcrumbProviderInterface $provider
     */
    public function __construct(BreadcrumbProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('breadcrumbs', [$this, 'getBreadcrumbs'], ['is_safe' => ['html', 'javascript']])
        ];
    }

    public function getName()
    {
        return 'breadcrumb';
    }

    public function getBreadcrumbs() : Collection
    {
        return $this->provider->getBreadcrumbs();
    }
}
