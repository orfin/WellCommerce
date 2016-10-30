<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ClientBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class CompanyAddress
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyAddress extends Constraint
{
    public $service    = 'client.validator.company_address';
    public $fields     = [];
    public $errorPath  = null;
    public $ignoreNull = true;
    
    /**
     * {@inheritdoc}
     */
    public function validatedBy ()
    {
        return $this->service;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTargets ()
    {
        return self::CLASS_CONSTRAINT;
    }
}
