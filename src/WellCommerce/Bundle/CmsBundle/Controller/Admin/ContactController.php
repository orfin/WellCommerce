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

namespace WellCommerce\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CmsBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ContactController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ContactController extends AbstractAdminController
{
    public function addAction(Request $request)
    {
        $builder = $this->get('contact.form.builder');
        $builder->createForm([
            'name' => 'contact',
        ], new Contact());

        print_r($builder->getForm());

        die();
    }

    public function editAction(Request $request)
    {
        $resource = $this->findOr404($request);


        $builder = $this->get('contact.form.builder');

        $form = $builder->createForm([
            'name' => 'contact',
        ], $resource);

//        $renderer = $this->get('form.renderer.chain')->guessRenderer('js');
//        $form = $renderer->render($form);

        return [
            'form' => $form
        ];
    }
}
