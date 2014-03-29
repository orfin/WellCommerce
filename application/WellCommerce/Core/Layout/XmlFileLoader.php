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
        $layoutBoxCollection    = new LayoutBoxCollection();

        foreach ($xml->documentElement->childNodes as $node) {
            if (!$node instanceof \DOMElement) {
                continue;
            }
            switch ($node->localName) {
                case 'boxes':
                    if ('' !== $resource = $node->getAttribute('resource')) {
                        $this->importBoxes($layoutBoxCollection, $node, $path, $file, $resource);
                    } else {
                        $this->parseBoxes($layoutBoxCollection, $node, $path, $file);
                    }
                    break;
                case 'column':
                    if ('' !== $resource = $node->getAttribute('resource')) {
                        $this->importColumn($layoutColumnCollection, $node, $path, $file, $resource);
                    } else {
                        echo $file.':'.$node->localName.PHP_EOL;
                        $this->parseColumn($layoutColumnCollection, $node, $path);
                    }
                    break;
            }
        }

        return $layoutBoxCollection;
    }

    private function parseBoxes(LayoutBoxCollection $collection, \DOMElement $node, $path, $file)
    {
        foreach ($node->getElementsByTagName('box') as $n) {
            $layoutBox = new LayoutBox($n->getAttribute('id'), $n->getAttribute('class'));
            $collection->add($layoutBox);
        }
    }

    private function parseImport(\DOMElement $node, $path, $file)
    {
        if ('' === $resource = $node->getAttribute('resource')) {
            throw new \InvalidArgumentException(sprintf('The "import" element in file "%s" must have a "resource" attribute.', $path));
        }

        $this->setCurrentDir(dirname($path));
        $subCollection = $this->import($resource, null, false, $file);
    }

    protected function parseColumn(LayoutColumnCollection $collection, \DOMElement $node, $path)
    {
        echo $node->getAttribute('width');
        $column = new LayoutColumn($node->getAttribute('width'));
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

    private function importBoxes(LayoutBoxCollection $collection, \DOMElement $node, $path, $file, $resource)
    {
        $this->setCurrentDir(dirname($path));

        $subCollection = $this->import($resource);
        foreach ($subCollection->boxes as $box) {
            $collection->add($box);
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

    private static function convertDomElementToArray(\DomElement $element)
    {
        return XmlUtils::convertDomElementToArray($element);
    }
}