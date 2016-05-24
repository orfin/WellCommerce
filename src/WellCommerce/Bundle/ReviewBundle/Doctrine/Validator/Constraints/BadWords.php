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

namespace WellCommerce\Bundle\ReviewBundle\Doctrine\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class BadWords
 *
 * @author  Rafal Martonik <rafal@wellcommerce.org>
 */
class BadWords extends Constraint
{
    public $message    = 'review.error.content.bad_words';
    public $service    = 'review.orm.validator.bad_words';
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
