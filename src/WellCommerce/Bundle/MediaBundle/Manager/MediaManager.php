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

namespace WellCommerce\Bundle\MediaBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\MediaBundle\Exception\InvalidMediaException;

/**
 * Class MediaManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaManager extends AbstractManager
{
    /**
     * Uploads the file
     *
     * @param UploadedFile $file
     * @param              $dir
     *
     * @return \WellCommerce\Bundle\MediaBundle\Entity\MediaInterface
     * @throws \Exception
     */
    public function upload(UploadedFile $file, $dir)
    {
        $uploadPath = $this->getUploadRootDir($dir);

        if (!$file->isValid()) {
            throw new InvalidMediaException('Passed file object is not valid');
        }

        $media  = $this->createMediaFromUploadedFile($file);
        $errors = $this->getValidatorHelper()->validate($media);
        if (0 !== count($errors)) {
            throw new InvalidMediaException($errors);
        }

        $this->saveResource($media);
        $file->move($uploadPath, $media->getPath());

        return $media;
    }

    /**
     * @param UploadedFile $file
     *
     * @return \WellCommerce\Bundle\MediaBundle\Entity\MediaInterface
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
