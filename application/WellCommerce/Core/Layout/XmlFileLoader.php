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

namespace WellCommerce\Core\Layout;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Util\XmlUtils;
use WellCommerce\Core\Layout\Box\LayoutBox;
use WellCommerce\Core\Layout\Box\LayoutBoxCollection;
use WellCommerce\Core\Layout\Column\LayoutColumn;
use WellCommerce\Core\Layout\Column\LayoutColumnCollection;

/**
 * Class XmlFileLoader
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XmlFileLoader extends FileLoader
{
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);
        $xml  = $this->loadFile($path);

        $layoutColumnCollection = new LayoutColumnCollection();

        foreach ($xml->documentElement->childNodes as $node) {
            if (!$node instanceof \DOMElement) {
                continue;
            }
            switch ($node->localName) {
                case 'column':
                    if ('' !== $resource = $node->getAttribute('resource')) {
                        $this->importColumn($layoutColumnCollection, $node, $path, $file, $resource);
                    } else {
                        $this->parseColumn($layoutColumnCollection, $node, $path);
                    }
                    break;
            }
        }

        return $layoutColumnCollection;
    }

    private function parseBoxes(LayoutBoxCollection $collection, \DOMElement $node, $path)
    {
        foreach ($node->getElementsByTagName('box') as $n) {
            $layoutBox = new LayoutBox($n->getAttribute('id'), $n->getAttribute('class'));
            $collection->add($layoutBox);
        }

        return $collection;
    }

    protected function parseColumn(LayoutColumnCollection $collection, \DOMElement $node, $path)
    {
        $boxCollection = new LayoutBoxCollection();
        $boxes         = $this->parseBoxes($boxCollection, $node, $path);
        $column        = new LayoutColumn($node->getAttribute('width'), $node->getAttribute('use'), $boxes->all());
        $collection->add($column);
    }

    protected function importColumn(LayoutColumnCollection $collection, \DOMElement $node, $path, $file, $resource)
    {
        $this->setCurrentDir(dirname($path));
        $subCollection = $this->import($resource);
        foreach ($subCollection->columns as $column) {
            $collection->add($column);
        }
    }

    private function loadFile($file)
    {
        return XmlUtils::loadFile($file);
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource)
        && 'xml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}