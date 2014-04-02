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

namespace WellCommerce\Core\Layout\Page;

use WellCommerce\Core\Component\AbstractComponent;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use WellCommerce\Core\Layout\XmlFileLoader;

/**
 * Class LayoutPage
 *
 * @package WellCommerce\Core\Layout\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class LayoutPage extends AbstractComponent
{
    /**
     * Returns all layout directories available in site themes
     *
     * @return array
     */
    public function getLayoutDirectories()
    {
        return [
            ROOTPATH . 'themes' . DS . 'WellCommerce' . DS . 'layouts'
        ];
    }

    /**
     * Loads column collection from XML file
     */
    public function load()
    {
        // load and parse xml file
        $locator          = new FileLocator($this->getLayoutDirectories());
        $loaders          = [new XmlFileLoader($locator)];
        $loaderResolver   = new LoaderResolver($loaders);
        $delegatingLoader = new DelegatingLoader($loaderResolver);

        // get columns collection
        return $delegatingLoader->load($locator->locate($this->getLayoutXml()));
    }

    /**
     * Render layout
     */
    public function render()
    {
        $columns  = $this->load();
        $renderer = $this->get('layout_renderer');

        return $renderer->render($columns);
    }
}