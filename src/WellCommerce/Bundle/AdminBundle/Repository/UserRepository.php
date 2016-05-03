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
namespace WellCommerce\Bundle\AdminBundle\Repository;

use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class UserRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function refreshUser(BaseUserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        
        return $this->loadUserByUsername($user->getUsername());
    }
    
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
    
    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->select('u, r');
        $queryBuilder->leftJoin('u.roles', 'r');
        $queryBuilder->where('u.username = :username OR u.email = :email');
        $queryBuilder->setParameter('username', $username);
        $queryBuilder->setParameter('email', $username);
        
        try {
            $user = $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $msg = sprintf('Unable to find an active admin identified by "%s".', $username);
            
            throw new UsernameNotFoundException($msg);
        }
        
        return $user;
    }

    public function getUserPermission(string $name, UserInterface $user)
    {
        $queryBuilder = $this->createQueryBuilder('u');
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
