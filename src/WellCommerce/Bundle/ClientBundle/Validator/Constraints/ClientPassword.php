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

namespace WellCommerce\Bundle\ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ClientPassword
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientPassword extends Constraint
{
    public $message    = 'client.password_not_valid';
    public $service    = 'client.validator.valid_password';
    public $fields     = [];
    public $errorPath  = null;
    public $ignoreNull = true;

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return $this->service;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
