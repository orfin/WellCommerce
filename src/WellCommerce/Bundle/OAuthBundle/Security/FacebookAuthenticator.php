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

namespace WellCommerce\Bundle\OAuthBundle\Security;

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;

class FacebookAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var string
     */
    const GRAPH_API_VERSION = 'v2.5';
    
    /**
     * @var array
     */
    const SCOPES = ['email'];
    
    /**
     * @var ManagerInterface
     */
    protected $clientManager;
    
    /**
     * @var RouterHelperInterface
     */
    protected $routerHelper;
    
    /**
     * @var string
     */
    protected $appId;
    
    /**
     * @var string
     */
    protected $appSecret;
    
    /**
     * @var Facebook
     */
    protected $facebookProvider;
    
    /**
     * FacebookAuthenticator constructor.
     *
     * @param ManagerInterface      $clientManager
     * @param RouterHelperInterface $routerHelper
     * @param string                $appId
     * @param string                $appSecret
     */
    public function __construct(ManagerInterface $clientManager, RouterHelperInterface $routerHelper, $appId, $appSecret)
    {
        $this->clientManager = $clientManager;
        $this->routerHelper  = $routerHelper;
        $this->appId         = $appId;
        $this->appSecret     = $appSecret;
    }
    
    public function getCredentials(Request $request)
    {
        if ($request->get('_route') !== 'oauth.facebook.check') {
            return null;
        }
        
        if ($code = $request->query->get('code')) {
            return $code;
        }
    }
    
    public function getUser($authorizationCode, UserProviderInterface $userProvider)
    {
        $accessToken = $this->getProvider()->getAccessToken(
            'authorization_code',
            ['code' => $authorizationCode]
        );
        
        /** @var FacebookUser $userDetails */
        $userDetails = $this->getProvider()->getResourceOwner($accessToken);
        $email       = $userDetails->getEmail();
        $user        = $this->clientManager->getRepository()->findOneBy([
            'clientDetails.username' => $email
        ]);
        
        if (!$user instanceof ClientInterface) {
            $user = $this->autoRegisterClient($userDetails);
        }
        
        return $user;
    }
    
    /**
     * Automatic register process
     *
     * @param FacebookUser $facebookUser
     *
     * @return ClientInterface
     */
    protected function autoRegisterClient(FacebookUser $facebookUser)
    {
        $firstName = $facebookUser->getFirstName();
        $lastName  = $facebookUser->getLastName();
        $email     = $facebookUser->getEmail();
        
        /** @var $client ClientInterface */
        $client = $this->clientManager->initResource();
        $client->getClientDetails()->setUsername($email);
        $client->getClientDetails()->setPassword(Helper::generateRandomPassword());
        
        $client->getContactDetails()->setEmail($email);
        $client->getContactDetails()->setFirstName($firstName);
        $client->getContactDetails()->setLastName($lastName);
        $client->getContactDetails()->setPhone(' ');
        $client->getContactDetails()->setSecondaryPhone(' ');
        
        $this->clientManager->createResource($client);
        
        return $client;
    }
    
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }
    
    /**
     * Scheme used after authentification fails
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        
        return new RedirectResponse($this->routerHelper->generateUrl('front.client.login'));
    }
    
    /**
     * Scheme used after authentification succeeds
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return $this->routerHelper->redirectTo('front.client_order.index');
    }
    
    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return true;
    }
    
    /**
     * Starts the authentication scheme.
     *
     * @param Request                      $request
     * @param AuthenticationException|null $authException
     *
     * @return RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $authUrl = $this->getProvider()->getAuthorizationUrl([
            'scopes' => self::SCOPES
        ]);
        
        return new RedirectResponse($authUrl);
    }
    
    /**
     * @return Facebook
     */
    public function getProvider()
    {
        if (null === $this->facebookProvider) {
            $this->facebookProvider = new Facebook([
                'clientId'        => $this->appId,
                'clientSecret'    => $this->appSecret,
                'redirectUri'     => $this->routerHelper->generateUrl('oauth.facebook.check', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'graphApiVersion' => self::GRAPH_API_VERSION,
            ]);
        }
        
        return $this->facebookProvider;
    }
    
    /**
     * @param UserInterface $user
     * @param string        $providerKey
     *
     * @return UsernamePasswordToken
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        return new UsernamePasswordToken(
            $user,
            null,
            $providerKey,
            $user->getRoles()
        );
    }
}
