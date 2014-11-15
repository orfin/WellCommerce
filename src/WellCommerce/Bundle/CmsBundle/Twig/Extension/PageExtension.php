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

use WellCommerce\Bundle\CmsBundle\Repository\PageRepositoryInterface;
use WellCommerce\Bundle\LayoutBundle\Renderer\LayoutBoxRendererInterface;

/**
 * Class PageExtension
 *
 * @package WellCommerce\Bundle\CmsBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageExtension extends \Twig_Extension
{
    /**
     * @var PageRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param PageRepositoryInterface $repository
     */
    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getGlobals()
    {
        return [
            'cmsPageTree' => $this->repository->getPagesTree()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cms_page';
    }
}
