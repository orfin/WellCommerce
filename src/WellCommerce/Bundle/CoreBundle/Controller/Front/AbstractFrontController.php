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
namespace WellCommerce\Bundle\CoreBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;

/**
 * Class AbstractFrontController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController implements FrontControllerInterface
{
    /**
     * @var FrontManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param FrontManagerInterface $manager
     */
    public function __construct(FrontManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns resource by ID parameter
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return mixed
     */
    protected function findOr404(Request $request, array $criteria = [])
    {
        // check whether request contains ID attribute
        if (!$request->attributes->has('id')) {
            throw new \LogicException('Request does not have "id" attribute set.');
        }

        $criteria['id'] = $request->attributes->get('id');

        if (null === $resource = $this->manager->getRepository()->findOneBy($criteria)) {
            throw new NotFoundHttpException(sprintf('Resource not found'));
        }

        return $resource;
    }

    /**
     * Returns manager object
     *
     * @return FrontManagerInterface
     */
    protected function getManager()
    {
        return $this->manager;
    }
}
