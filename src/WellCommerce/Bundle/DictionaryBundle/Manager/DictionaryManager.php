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

namespace WellCommerce\Bundle\DictionaryBundle\Manager;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\DictionaryBundle\Entity\DictionaryInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class DictionaryManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryManager extends AbstractManager
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var array|\WellCommerce\Bundle\LocaleBundle\Entity\Locale[]
     */
    protected $locales;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Synchronizes database and filesystem translations
     */
    public function syncDictionary()
    {
        $this->kernel           = $this->get('kernel');
        $this->locales          = $this->getLocales();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->filesystem       = new Filesystem();

        foreach ($this->locales as $locale) {
            $this->updateTranslationsForLocale($locale);
        }

        $this->getDoctrineHelper()->getEntityManager()->flush();
    }

    protected function updateTranslationsForLocale(LocaleInterface $locale)
    {
        $fsTranslations     = $this->getTranslatorHelper()->getMessages($locale->getCode());
        $dbTranslations     = $this->getDatabaseTranslations($locale);
        $mergedTranslations = array_replace_recursive($fsTranslations, $dbTranslations);
        $filename           = sprintf('wellcommerce.%s.yml', $locale->getCode());
        $path               = $this->getFilesystemTranslationsPath() . DIRECTORY_SEPARATOR . $filename;
        $content            = Yaml::dump($mergedTranslations, 6);
        $this->filesystem->dumpFile($path, $content);

        $this->synchronizeDatabaseTranslations($mergedTranslations, $locale);
    }

    protected function synchronizeDatabaseTranslations(array $messages, LocaleInterface $locale)
    {
        $this->getDoctrineHelper()->truncateTable('WellCommerce\Bundle\DictionaryBundle\Entity\Dictionary');

        $em = $this->getDoctrineHelper()->getEntityManager();

        foreach ($messages as $identifier => $translation) {
            $dictionary = $this->factory->create();
            $dictionary->setIdentifier($identifier);
            $dictionary->translate($locale->getCode())->setValue($translation);
            $dictionary->mergeNewTranslations();
            $em->persist($dictionary);
        }
    }

    /**
     * Returns an array containing all previously imported translations
     *
     * @param LocaleInterface $locale
     *
     * @return array
     */
    protected function getDatabaseTranslations(LocaleInterface $locale)
    {
        $messages   = [];
        $collection = $this->repository->matching(new Criteria());

        $collection->map(function (DictionaryInterface $dictionary) use ($locale, &$messages) {
            $messages[$dictionary->getIdentifier()] = $dictionary->translate($locale->getCode())->getValue();
        });

        return $messages;
    }


    protected function getFilesystemTranslationsPath()
    {
        $kernelDir = $this->kernel->getRootDir();

        return $kernelDir . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'translations';
    }
}


