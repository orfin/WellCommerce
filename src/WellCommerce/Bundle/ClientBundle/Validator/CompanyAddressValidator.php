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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;

/**
 * Class CompanyAddressValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyAddressValidator extends ConstraintValidator
{
    /**
     * Validate the route entity
     *
     * @param ClientBillingAddressInterface $entity
     * @param Constraint                    $constraint
     */
    public function validate ($entity, Constraint $constraint)
    {
        if (!$entity instanceof ClientBillingAddressInterface) {
            throw new \InvalidArgumentException('Expected instance of ClientBillingAddressInterface');
        }
        
        if (false === $entity->isCompanyAddress()) {
            return;
        }
        
        if ($this->context instanceof ExecutionContextInterface) {
            
            if (false === $this->isValidCompanyName($entity)) {
                $this->context->buildViolation('client.company_name_not_valid')->atPath('companyName')->addViolation();
            }
            
            if (false === $this->isValidVatId($entity)) {
                $this->context->buildViolation('client.vatid_not_valid')->atPath('vatId')->addViolation();
            }
        }
    }
    
    private function isValidCompanyName (ClientBillingAddressInterface $address) : bool
    {
        return strlen($address->getCompanyName()) > 0;
    }
    
    private function isValidVatId (ClientBillingAddressInterface $address) : bool
    {
        return strlen($address->getVatId()) > 0;
    }
}
