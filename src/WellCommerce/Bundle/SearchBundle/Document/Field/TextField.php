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

namespace WellCommerce\Bundle\SearchBundle\Document\Field;

/**
 * Class DocumentField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class TextField implements DocumentFieldInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $indexed;

    /**
     * @var bool
     */
    private $analyzed;

    /**
     * @var float
     */
    private $boost;

    /**
     * TextField constructor.
     *
     * @param string $name
     * @param string $value
     * @param bool   $indexed
     * @param float  $boost
     */
    public function __construct(string $name, string $value, bool $indexed = true, float $boost = 1.0, bool $analyzed = true)
    {
        $this->name     = $name;
        $this->value    = $value;
        $this->indexed  = $indexed;
        $this->analyzed = $analyzed;
        $this->boost    = $boost;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function isIndexed() : bool
    {
        return $this->indexed;
    }

    public function isAnalyzed() : bool
    {
        return $this->analyzed;
    }

    public function getBoost() : float
    {
        return $this->boost;
    }

    public function getType() : string
    {
        return 'text';
    }
}
