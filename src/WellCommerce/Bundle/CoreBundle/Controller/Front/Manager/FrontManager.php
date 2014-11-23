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

namespace WellCommerce\Bundle\CoreBundle\Controller\Front\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface;

/**
 * Class FrontManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Front\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FrontManager implements FrontManagerInterface
{
    /**
     * @var FlashHelperInterface
     */
    private $flashHelper;

    /**
     * @var RedirectHelperInterface
     */
    private $redirectHelper;

    /**
     * @var ImageHelperInterface
     */
    private $imageHelper;

    /**
     * Constructor
     *
     * @param FlashHelperInterface    $flashHelper
     * @param RedirectHelperInterface $redirectHelper
     * @param ImageHelperInterface    $imageHelper
     */
    public function __construct(
        FlashHelperInterface $flashHelper,
        RedirectHelperInterface $redirectHelper,
        ImageHelperInterface $imageHelper
    ) {
        $this->flashHelper    = $flashHelper;
        $this->redirectHelper = $redirectHelper;
        $this->imageHelper    = $imageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectHelper()
    {
        return $this->redirectHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlashHelper()
    {
        return $this->flashHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
    }
}