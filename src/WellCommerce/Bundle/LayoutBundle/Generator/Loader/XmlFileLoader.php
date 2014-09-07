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

namespace WellCommerce\Bundle\LayoutBundle\Generator\Loader;

/**
 * Class XmlFileLoader
 *
 * @package WellCommerce\Bundle\LayoutBundle\Generator\Loader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XmlFileLoader
{
    protected $fileName = null;
    protected $parsed = null;

    public function load($fileName)
    {
        if (!is_file($fileName)) {
            throw new Exception('File doesn\'t exists: ' . $fileName);
        }
        $this->fileName = $fileName;
    }

    public function parse()
    {
        if ($this->fileName == null) {
            throw new CoreException('File not loaded');
        }
        $this->parsed = @simplexml_load_file($this->fileName);
        if (false===$this->parsed) {
            throw new Exception('Opening and ending tag mismatch in: ' . $this->fileName);
        }
    }

    public function getParsered()
    {
        return $this->parsed;
    }

    public function parseExternal($fileUrl)
    {
        $this->parsed = @simplexml_load_file($fileUrl);

        return $this->parsed;
    }

    public function parseFast($fileName)
    {
        try {
            $this->load($fileName);
            $this->parse();
        } catch (Exception $e) {
            throw $e;
        }

        return $this->getParsered();
    }

    public function getValue($nodeArray, $arrayMode = true)
    {
        $subnodes = explode('/', $nodeArray);
        $curnode  = $this->getParsered()->children();
        $curnode  = $this->loop($this->getParsered()->children(), $subnodes);
        if ($arrayMode == true) {
            return (array)$curnode;
        }

        return $curnode;
    }

    protected function loop($curnode, $nodes)
    {
        foreach ($curnode as $child) {
            if ($child->getName() == current($nodes)) {
                if (!next($nodes)) {
                    return $child;
                }
                $this->loop($child, $nodes);
            }
        }
    }

    public function getValueToString($node)
    {
        return (string)$this->getValue($node, 0);
    }

    public function flush()
    {
        $this->fileName = null;
        $this->parsed = null;
    }
} 