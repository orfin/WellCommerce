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

namespace WellCommerce\Component\Form\Exception;

/**
 * Class MissingFormDataTransformerException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingFormDataTransformerException extends \LogicException
{
    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        parent::__construct(sprintf('Form DataTransformer "%s" is missing', $alias));
    }
}
