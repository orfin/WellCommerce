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

namespace WellCommerce\CoreBundle\Helper\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WellCommerce\AppBundle\Entity\UserInterface;
use WellCommerce\AppBundle\Repository\UserRepositoryInterface;

/**
 * Class SecurityHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SecurityHelper implements SecurityHelperInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Constructor
     *
     * @param TokenStorageInterface   $tokenStorage
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(TokenStorageInterface $tokenStorage, UserRepositoryInterface $userRepository)
    {
        $this->tokenStorage   = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            return $token->getUser();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermission($name, UserInterface $user)
    {
        $queryBuilder = $this->userRepository->createQueryBuilder('u');
        $queryBuilder->select('ugp.id');
        $queryBuilder->leftJoin('u.groups', 'ug');
        $queryBuilder->leftJoin('ug.permissions', 'ugp');
        $queryBuilder->where('u.id = :id');
        $queryBuilder->andWhere('ugp.name = :name');
        $queryBuilder->andWhere('ugp.enabled = :enabled');
        $queryBuilder->setParameter('id', $user->getId());
        $queryBuilder->setParameter('name', $name);
        $queryBuilder->setParameter('enabled', 1);

        return $queryBuilder->getQuery()->getResult();
    }
}
