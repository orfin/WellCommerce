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

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ValidatorHelper implements ValidatorHelperInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    
    /**
     * ValidatorHelper constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    public function validate($value, array $constraints = null, array $groups = []): ConstraintViolationListInterface
    {
        $groups = array_merge(self::DEFAULT_VALIDATOR_GROUPS, $groups);
        
        return $this->validator->validate($value, $constraints, $groups);
    }
    
    public function isValid($value, array $constraints = null, array $groups = []): bool
    {
        $groups = array_merge(self::DEFAULT_VALIDATOR_GROUPS, $groups);
        $errors = $this->validator->validate($value, $constraints, $groups);
        
        return 0 === $errors->count();
    }
}
