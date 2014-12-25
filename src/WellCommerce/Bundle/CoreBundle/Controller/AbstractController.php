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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends Controller
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface
     */
    protected $manager;

    /**
     * Returns content as json response
     *
     * @param $content
     *
     * @return JsonResponse
     */
    protected function jsonResponse($content)
    {
        return new JsonResponse($content);
    }

    /**
     * Creates and returns the form element
     *
     * @param FormInterface $form    Form instance
     * @param null|object   $data    Initial form data
     * @param array         $options Form options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    protected function getFormBuilder(FormInterface $form, $data = null, array $options)
    {
        return $this->get('form.builder')->create($form, $data, $options)->getForm();
    }

    /**
     * Translates message using Translator service
     *
     * @param $id
     *
     * @return string
     */
    protected function trans($id)
    {
        return $this->manager->getTranslator()->trans($id);
    }

    /**
     * Returns image path
     *
     * @param $path
     * @param $filter
     *
     * @return mixed
     */
    protected function getImage($path, $filter)
    {
        return $this->manager->getImageHelper()->getImage($path, $filter);
    }

    /**
     * Returns default entity manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        return $this->manager->getDoctrineHelper()->getEntityManager();
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
        return $this->manager->getRedirectHelper()->redirectToAction($actionName, $params);
    }
}