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

namespace WellCommerce\Component\Form\DataMapper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class AbstractDataMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataMapper
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @var object
     */
    protected $data;

    /**
     * Constructor
     *
     * @param object $data
     */
    public function __construct($data)
    {
        $this->data             = $data;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Maps data to all form elements
     *
     * @param FormInterface $form
     */
    abstract public function mapDataToForm(FormInterface $form);
}
