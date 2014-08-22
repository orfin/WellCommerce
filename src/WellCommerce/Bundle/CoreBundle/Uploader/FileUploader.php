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

namespace WellCommerce\Bundle\CoreBundle\Uploader;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Bundle\MediaBundle\Repository\MediaRepositoryInterface;

/**
 * Class FileUploader
 *
 * @package WellCommerce\Bundle\CoreBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileUploader implements FileUploaderInterface
{
    const PRE_UPLOAD_EVENT  = 'file.pre_upload';
    const POST_UPLOAD_EVENT = 'file.post_upload';
    const PRE_DELETE_EVENT  = 'file.pre_delete';
    const POST_DELETE_EVENT = 'file.post_delete';

    /**
     * @var string
     */
    protected $kernelDir;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var MediaRepositoryInterface
     */
    protected $repository;

    protected $uploadPath;

    /**
     * Constructor
     *
     * @param Filesystem               $filesystem
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct($kernelDir, Filesystem $filesystem, EventDispatcherInterface $eventDispatcher, MediaRepositoryInterface $repository)
    {
        $this->kernelDir       = $kernelDir;
        $this->filesystem      = $filesystem;
        $this->eventDispatcher = $eventDispatcher;
        $this->repository      = $repository;
    }

    /**
     * Dispatches file event
     *
     * @param      $name
     * @param File $file
     */
    private function dispatchEvent($name, File $file)
    {
        $event = new GenericEvent($file);
        $this->eventDispatcher->dispatch($name, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function upload(UploadedFile $file, $dir)
    {
        $this->dispatchEvent(self::PRE_UPLOAD_EVENT, $file);

        if (!$file->isValid()) {
            throw new \Exception('Passed file object is not valid');
        }

        $media      = $this->repository->save($file);
        $uploadPath = $this->getUploadRootDir($dir);

        $this->dispatchEvent(self::POST_UPLOAD_EVENT, $file);

        return $media;
    }

    private function getUploadRootDir($dir)
    {
        //%kernel.root_dir%/../web/media/images
        return sprintf('%s/../web/media/%s', $this->kernelDir, $dir);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(File $file)
    {
        $this->dispatchEvent(self::PRE_DELETE_EVENT, $file);

        $this->dispatchEvent(self::POST_DELETE_EVENT, $file);
    }
} 