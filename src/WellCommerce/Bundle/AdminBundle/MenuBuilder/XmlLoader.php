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

namespace WellCommerce\Bundle\AdminBundle\MenuBuilder;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Util\XmlUtils;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class XmlLoader
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XmlLoader
{
    /**
     * @var AdminMenuBuilderInterface
     */
    protected $builder;

    /**
     * @var FileLocatorInterface
     */
    protected $locator;

    /**
     * Constructor
     *
     * @param AdminMenuBuilderInterface $builder
     * @param FileLocatorInterface      $locator
     */
    public function __construct(AdminMenuBuilderInterface $builder, FileLocatorInterface $locator)
    {
        $this->builder = $builder;
        $this->locator = $locator;
    }

    /**
     * Loads XML file and appends items to menu
     *
     * @param string $file
     */
    public function load($file)
    {
        $path = $this->locateFile($file);
        $xml  = $this->parseFile($path);
        $this->parseItems($xml);
    }

    /**
     * Locates file and returns its path
     *
     * @param string $file
     *
     * @return string
     */
    private function locateFile($file)
    {
        return $this->locator->locate($file, null, true);
    }

    /**
     * Parses a XML file
     *
     * @param string $file
     *
     * @return \DOMDocument
     */
    private function parseFile($file)
    {
        return XmlUtils::loadFile($file);
    }

    /**
     * Parses DOM element and adds it as an admin menu item
     *
     * @param \DOMDocument $xml
     */
    private function parseItems(\DOMDocument $xml)
    {
        foreach ($xml->documentElement->getElementsByTagName('item') as $item) {
            $dom = simplexml_import_dom($item);
            $this->addMenuItem($dom);
        }
    }

    /**
     * Creates new admin menu item
     *
     * @param \SimpleXMLElement $item
     */
    private function addMenuItem(\SimpleXMLElement $item)
    {
        $this->builder->add(new AdminMenuItem([
            'id'         => (string)$item->id,
            'name'       => (string)$item->name,
            'class'      => isset($item->class) ? (string)$item->class : '',
            'link'       => (string)$item->route,
            'path'       => Helper::convertDotNotation((string)$item->path),
            'sort_order' => (int)$item->sort_order,
        ]));
    }
}
