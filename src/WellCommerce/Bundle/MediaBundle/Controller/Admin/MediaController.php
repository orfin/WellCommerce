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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\MediaBundle\Exception\InvalidMediaException;
use WellCommerce\Bundle\MediaBundle\Uploader\MediaUploaderInterface;

/**
 * Class MediaController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\MediaBundle\Manager\Admin\MediaManager
     */
    protected $manager;

    public function addAction(Request $request) : Response
    {
        $file   = $request->files->get('file');
        $helper = $this->getImageHelper();

        try {
            $media     = $this->getUploader()->upload($file, 'images');
            $thumbnail = $helper->getImage($media->getPath(), 'medium');

            $response = [
                'sId'        => $media->getId(),
                'sThumb'     => $thumbnail,
                'sFilename'  => $media->getName(),
                'sExtension' => $media->getExtension(),
                'sFileType'  => $media->getMime(),
            ];
        } catch (InvalidMediaException $e) {
            $response = [
                'sError'   => $this->trans('uploader.error'),
                'sMessage' => $this->trans($e->getMessage()),
            ];
        }

        return $this->jsonResponse($response);
    }
    
    private function getUploader() : MediaUploaderInterface
    {
        return $this->get('media.uploader');
    }
}
