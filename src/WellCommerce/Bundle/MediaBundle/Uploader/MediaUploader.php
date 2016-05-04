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

namespace WellCommerce\Bundle\MediaBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Bundle\CoreBundle\Helper\Validator\ValidatorHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;
use WellCommerce\Bundle\MediaBundle\Exception\InvalidMediaException;

/**
 * Class MediaUploader
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class MediaUploader implements MediaUploaderInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;
    
    /**
     * @var string
     */
    private $uploadRootDir;

    /**
     * @var ValidatorHelperInterface
     */
    private $validatorHelper;

    /**
     * MediaUploader constructor.
     *
     * @param ManagerInterface         $manager
     * @param string                   $uploadRootDir
     * @param ValidatorHelperInterface $validatorHelper
     */
    public function __construct(ManagerInterface $manager, string $uploadRootDir, ValidatorHelperInterface $validatorHelper)
    {
        $this->manager         = $manager;
        $this->uploadRootDir   = $uploadRootDir;
        $this->validatorHelper = $validatorHelper;
    }
    
    public function upload(UploadedFile $file, $dir) : MediaInterface
    {
        if (!$file->isValid()) {
            throw new InvalidMediaException('Passed file object is not valid');
        }

        /** @var MediaInterface $media */
        $media = $this->manager->initResource();
        $media->setName($file->getClientOriginalName());
        $media->setExtension($file->guessClientExtension());
        $media->setMime($file->getClientMimeType());
        $media->setSize($file->getClientSize());

        $errors = $this->validatorHelper->validate($media);
        if (0 !== count($errors)) {
            throw new InvalidMediaException($errors);
        }
        
        $this->manager->createResource($media);
        $file->move($this->getUploadDir($dir), $media->getPath());
        
        return $media;
    }

    public function getUploadDir(string $dir) : string
    {
        $dir = rtrim($dir, '/\\');
        
        return sprintf('%s/%s', $this->uploadRootDir, $dir);
    }
}
