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
namespace WellCommerce\Bundle\CmsBundle\Twig\Extension;

use WellCommerce\Bundle\CmsBundle\Provider\PageProviderInterface;

/**
 * Class PageExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageExtension extends \Twig_Extension
{

    /**
     * @var PageProviderInterface
     */
    protected $provider;

    /**
     * Constructor
     *
     * @param PageProviderInterface $provider
     */
    public function __construct(PageProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getGlobals()
    {
        return [
            'cmsPages' => $this->getCmsPages()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cms_page';
    }

    /**
     * @return array
     */
    public function getCmsPages()
    {
        return $this->provider->getCollectionBuilder()->getTree([
            'cache_enabled' => true,
            'cache_ttl'     => 3600
        ]);
    }
}
