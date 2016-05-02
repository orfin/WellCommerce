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

namespace WellCommerce\Bundle\ApiBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use WellCommerce\Bundle\AdminBundle\Repository\UserRepositoryInterface;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    
    /**
     * ApiTokenAuthenticator constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function getCredentials(Request $request)
    {
        if ($request->query->has('apiKey')) {
            return $request->query->get('apiKey');
        }
        
        if ($request->headers->has('X-Api-Key')) {
            return $request->headers->get('X-Api-Key');
        }
        
        return false;
    }
    
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->userRepository->findOneBy(['apiKey' => $credentials]);
        
        if (!$user) {
            throw new AuthenticationCredentialsNotFoundException();
        }
        
        return $user;
    }
    
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(
            ['message' => $exception->getMessageKey()],
            403
        );
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }
    
    public function supportsRememberMe()
    {
        return false;
    }
    
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(
            ['message' => 'Authentication required'],
            401
        );
    }
}
