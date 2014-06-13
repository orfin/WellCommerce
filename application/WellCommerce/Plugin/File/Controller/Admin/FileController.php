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
namespace WellCommerce\Plugin\File\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\File\Repository\FileRepositoryInterface;

/**
 * Class FileController
 *
 * @package WellCommerce\Plugin\File\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('producer.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $request  = $this->getRequest();
        $uploader = $this->getUploader();
        $files    = $uploader->getFiles($request->files);

        foreach ($files as $file) {
            $data = $this->repository->save($file);
            $name = sprintf('%s.%s', $data->id, $data->extension);
            $uploader->upload($file, $name);
        }

        // delete file cache
        $this->getCache()->delete('files');

        $response = [
            'sId'        => $data->id,
            'sThumb'     => $this->getImageGallery()->getImageUrl($data->id, 100, 100),
            'sFilename'  => $data->name,
            'sExtension' => $data->extension,
            'sFileType'  => $data->type
        ];

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('producer.form'), $model, [
            'name' => 'edit_producer'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat(), $id);

            if ($form->isAction('continue')) {
                return $this->redirect($this->generateUrl('admin.producer.edit', ['id' => $model->id]));
            }

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'producer' => $model,
            'form'     => $form
        ];
    }

    /**
     * Sets producer repository object
     *
     * @param FileRepositoryInterface $repository
     */
    public function setRepository(FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
