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
namespace WellCommerce\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Controller
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends Controller
{
    /**
     * Returns content as json response
     *
     * @param mixed $content
     *
     * @return JsonResponse
     */
    protected function jsonResponse($content)
    {
        return new JsonResponse($content);
    }

    /**
     * Translates message using Translator service
     *
     * @param string $id
     *
     * @return string
     */
    protected function trans($id)
    {
        return $this->getManager()->getTranslator()->trans($id);
    }

    /**
     * Returns image path
     *
     * @param string $path
     * @param string $filter
     *
     * @return string
     */
    protected function getImage($path, $filter)
    {
        return $this->getManager()->getImageHelper()->getImage($path, $filter);
    }

    /**
     * Returns default entity manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        return $this->getManager()->getDoctrineHelper()->getEntityManager();
    }

    /**
     * Redirects user to another action in scope of current controller
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToAction($actionName = 'index', array $params = [])
    {
        return $this->getManager()->getRedirectHelper()->redirectToAction($actionName, $params);
    }

    /**
     * Returns manager object
     *
     * @return \WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface
     */
    abstract protected function getManager();
}
