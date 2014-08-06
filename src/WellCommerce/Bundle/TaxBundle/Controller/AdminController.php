<?php

namespace WellCommerce\Bundle\TaxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Bundle\TaxBundle\Form\TaxType;

/**
 * Tax controller.
 *
 * @Route("/admin/tax")
 */
class AdminController extends Controller
{

    /**
     * Lists all Tax entities.
     *
     * @Route("/", name="admin_tax")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WellCommerceTaxBundle:Tax')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Tax entity.
     *
     * @Route("/", name="admin_tax_create")
     * @Method("POST")
     * @Template("WellCommerceTaxBundle:Tax:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tax();
        print_r($entity);
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $entity->setValue(11111);
            print_r($entity);die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_tax_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tax entity.
     *
     * @param Tax $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tax $entity)
    {
        $form = $this->createForm(new TaxType(), $entity, array(
            'action' => $this->generateUrl('admin_tax_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tax entity.
     *
     * @Route("/new", name="admin_tax_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tax();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tax entity.
     *
     * @Route("/{id}", name="admin_tax_show")
     * @Method("GET")
     * @Template()
     * @ParamConverter("tax", class="WellCommerceTaxBundle:Tax")
     */
    public function showAction(Tax $tax)
    {
        print_r($tax);die();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WellCommerceTaxBundle:Tax')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tax entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tax entity.
     *
     * @Route("/{id}/edit", name="admin_tax_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WellCommerceTaxBundle:Tax')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tax entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Tax entity.
     *
     * @param Tax $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tax $entity)
    {
        $form = $this->createForm(new TaxType(), $entity, array(
            'action' => $this->generateUrl('admin_tax_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Tax entity.
     *
     * @Route("/{id}", name="admin_tax_update")
     * @Method("PUT")
     * @Template("WellCommerceTaxBundle:Tax:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WellCommerceTaxBundle:Tax')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tax entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_tax_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tax entity.
     *
     * @Route("/{id}", name="admin_tax_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WellCommerceTaxBundle:Tax')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tax entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_tax'));
    }

    /**
     * Creates a form to delete a Tax entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tax_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
