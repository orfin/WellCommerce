<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ReviewBundle\Doctrine\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WellCommerce\Bundle\ReviewBundle\Checker\BadWordsChecker;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;

/**
 * Class BadWordsValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BadWordsValidator extends ConstraintValidator
{
    /**
     * Validate the entity
     *
     * @param mixed      $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!$entity instanceof ReviewInterface) {
            throw new \InvalidArgumentException('Expected instance of ReviewInterface');
        }

        $checker = new BadWordsChecker();

        if (false === $checker->isBadWord($entity->getReview())) {
            return;
        }

        if ($this->context instanceof ExecutionContextInterface) {
            $this->context->buildViolation($constraint->message)
                ->atPath('review')
                ->addViolation();
        }
    }
}
