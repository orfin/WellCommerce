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

namespace WellCommerce\Bundle\CoreBundle\Helper\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ValidatorHelper implements ValidatorHelperInterface
{
    const DEFAULT_VALIDATOR_GROUPS = ['Default'];

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, array $groups = [])
    {
        $groups = array_merge(self::DEFAULT_VALIDATOR_GROUPS, $groups);

        return $this->validator->validate($value, null, $groups);
    }
}
