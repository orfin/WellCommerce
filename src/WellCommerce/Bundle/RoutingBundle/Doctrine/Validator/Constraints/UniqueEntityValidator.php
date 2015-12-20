<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\RoutingBundle\Doctrine\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;
use WellCommerce\Bundle\RoutingBundle\Repository\RouteRepositoryInterface;

/**
 * Class UniqueEntityValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UniqueEntityValidator extends ConstraintValidator
{
    /**
     * @var RouteRepositoryInterface
     */
    protected $routeRepository;

    /**
     * UniqueEntityValidator constructor.
     *
     * @param RouteRepositoryInterface $routeRepository
     */
    public function __construct(RouteRepositoryInterface $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    /**
     * Validate the route entity
     *
     * @param mixed      $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!$entity instanceof RoutableSubjectInterface) {
            throw new \InvalidArgumentException('Expected instance of WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface');
        }

        $route  = $entity->getRoute();
        $slug   = $entity->getSlug();
        $locale = $entity->getLocale();
        $result = $this->routeRepository->findOneBy(['path' => $slug, 'locale' => $locale]);

        // route is unique always if no result was found
        if (null === $result) {
            return;
        }

        // skip validation if there is exact match
        if ($route instanceof RouteInterface && $result->getIdentifier()->getId() === $route->getIdentifier()->getId()) {
            return;
        }

        if ($this->context instanceof ExecutionContextInterface) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ type }}', $this->formatValue($result->getType()))
                ->atPath('slug')
                ->setInvalidValue($slug)
                ->addViolation();
        }
    }
}
