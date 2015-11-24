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

namespace WellCommerce\AppBundle\Manager\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class MediaManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaManager extends AbstractAdminManager
{
    /**
     * Uploads the file
     *
     * @param UploadedFile $file
     * @param              $dir
     *
     * @return \WellCommerce\AppBundle\Entity\MediaInterface
     * @throws \Exception
     */
    public function upload(UploadedFile $file, $dir)
    {
        $uploadPath = $this->getUploadRootDir($dir);

        if (!$file->isValid()) {
            throw new \Exception('Passed file object is not valid');
        }

        $media = $this->createMediaFromUploadedFile($file);
        $this->saveResource($media);

        $file->move($uploadPath, $media->getPath());

        return $media;
    }

    /**
     * @param UploadedFile $file
     *
     * @return \WellCommerce\AppBundle\Entity\MediaInterface
     */
    protected function createMediaFromUploadedFile(UploadedFile $file)
    {
        $media = $this->initResource();
        $media->setName($file->getClientOriginalName());
        $media->setExtension($file->guessClientExtension());
        $media->setMime($file->getClientMimeType());
        $media->setSize($file->getClientSize());

        return $media;
    }

    /**
     * Returns upload directory
     *
     * @param string $dir
     *
     * @return string
     */
    public function getUploadRootDir($dir)
    {
        $rootDir = $this->getKernel()->getRootDir();
        $dir     = rtrim($dir, '/\\');

        return sprintf('%s/../web/media/%s', $rootDir, $dir);
    }
}
