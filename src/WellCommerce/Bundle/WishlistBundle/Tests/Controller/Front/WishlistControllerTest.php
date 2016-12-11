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

namespace WellCommerce\Bundle\WishlistBundle\Tests\Controller\Front;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Front\AbstractFrontControllerTestCase;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\WishlistBundle\Entity\WishlistInterface;

/**
 * Class WishlistControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WishlistControllerTest extends AbstractFrontControllerTestCase
{
    public function testIndexActionForGuest()
    {
        $this->client->request('GET', $this->generateUrl('front.wishlist.index'));
        
        $this->assertIsLoginRedirect();
    }
    
    public function testIndexClientActionForClient()
    {
        $this->logIn();
        $url = $this->generateUrl('front.wishlist.index');
        
        $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testAddActionForGuest()
    {
        $product = $this->container->get('product.repository')->findOneBy(['enabled' => true]);
        if ($product instanceof ProductInterface) {
            $url = $this->generateUrl('front.wishlist.add', ['id' => $product->getId()]);
            $this->client->request('GET', $url);
            
            $this->assertIsLoginRedirect();
        }
    }
    
    public function testAddActionForClient()
    {
        $this->logIn();
        
        $product = $this->container->get('product.repository')->findOneBy(['enabled' => true]);
        if ($product instanceof ProductInterface) {
            $url         = $this->generateUrl('front.wishlist.add', ['id' => $product->getId()]);
            $redirectUrl = $this->generateUrl('front.wishlist.index', [], false);
            $this->client->request('GET', $url);
            
            $this->assertTrue($this->client->getResponse()->isRedirect($redirectUrl));
        }
    }
    
    public function testDeleteActionForGuest()
    {
        /** @var ProductInterface $product */
        $product = $this->container->get('product.repository')->findOneBy(['enabled' => true]);
        $url     = $this->generateUrl('front.wishlist.delete', ['id' => $product->getId()]);
        $this->client->request('GET', $url);
        
        $this->assertIsLoginRedirect();
    }
    
    public function testDeleteAction()
    {
        $client = $this->logIn();
        
        /** @var Collection $wishlist */
        $wishlist = $this->container->get('wishlist.repository')->getClientWishlistCollection($client);
        
        $wishlist->map(function (WishlistInterface $wishlist) {
            $url         = $this->generateUrl('front.wishlist.delete', ['id' => $wishlist->getProduct()->getId()]);
            $redirectUrl = $this->generateUrl('front.wishlist.index', [], false);
            $this->client->request('GET', $url);
            
            $this->assertTrue($this->client->getResponse()->isRedirect($redirectUrl));
        });
    }
}
