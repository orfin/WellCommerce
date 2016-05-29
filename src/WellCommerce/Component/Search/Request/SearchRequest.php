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

namespace WellCommerce\Component\Search\Request;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Search\Model\TypeInterface;

/**
 * Class SearchRequest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchRequest implements SearchRequestInterface
{
    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @var Collection
     */
    private $fields;

    /**
     * @var string
     */
    private $phrase;

    /**
     * @var string
     */
    private $locale;

    /**
     * SearchQuery constructor.
     *
     * @param TypeInterface $type
     * @param Collection    $fields
     * @param string        $phrase
     * @param string        $locale
     */
    public function __construct(TypeInterface $type, Collection $fields, string $phrase, string $locale)
    {
        $this->type   = $type;
        $this->fields = $fields;
        $this->phrase = $phrase;
        $this->locale = $locale;
    }

    public function getType() : TypeInterface
    {
        return $this->type;
    }

    public function getFields() : Collection
    {
        return $this->fields;
    }

    public function getPhrase() : string
    {
        return $this->phrase;
    }

    public function getLocale() : string
    {
        return $this->locale;
    }
}
