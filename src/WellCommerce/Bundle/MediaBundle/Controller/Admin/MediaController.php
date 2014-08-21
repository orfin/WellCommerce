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

namespace WellCommerce\Bundle\MediaBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * Class MediaController
 *
 * @package WellCommerce\Bundle\MediaBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class MediaController extends AbstractAdminController
{
    /**
     * Uploads and saves the file
     *
     * @param Request $request
     *
     * @return array|JsonResponse
     */
    public function addAction(Request $request)
    {
        $file = $request->files->get('file');

        // check whether file is instance of UploadedFile
        if (!$file instanceof UploadedFile || !$file->isValid()) {
            $response = [
                'sError'   => $this->trans('uploader.error'),
                'sMessage' => $this->trans('uploader.error.missing_file'),
            ];

            return new JsonResponse($response);
        }

        $fileConstraints = new File([
            'maxSize' => 10000
        ]);

        // check whether file size is valid
        $errors = $this->get('validator')->validateValue($file, $fileConstraints);

        if (count($errors) > 0) {
            $response = [
                'sError'   => $this->trans('uploader.error'),
                'sMessage' => $this->trans('uploader.error.invalid_file'),
            ];

            return new JsonResponse($response);
        }

        // check whether file was uploaded
        if (!is_file($file->__toString())) {
            $response = [
                'sError'   => $this->trans('uploader.error'),
                'sMessage' => $this->trans('uploader.error.not_uploaded'),
            ];

            return new JsonResponse($response);
        }

        $file->move($directory, $filename = sprintf('%s.%s', uniqid(), $file->guessExtension()));

        $file = $this->getUploader()->uploadFile($request->files->get('file'));

        $file = new Media();

        $response = [
            'sId'        => $file->getId(),
            'sThumb'     => $this->getImageGallery()->getImageUrl($file->getId(), 100, 100),
            'sFilename'  => $file->getName(),
            'sExtension' => $file->getExtension(),
            'sFileType'  => $file->getType()
        ];

        return new JsonResponse($response);
    }

}
