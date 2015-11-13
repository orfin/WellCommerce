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

namespace WellCommerce\Bundle\IntlBundle\Manager\Admin;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\CoreBundle\Purger\PurgerInterface;
use WellCommerce\Bundle\IntlBundle\Entity\Dictionary;
use WellCommerce\Bundle\IntlBundle\Entity\Locale;
use WellCommerce\Bundle\IntlBundle\Entity\LocaleInterface;

/**
 * Class DictionaryManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryManager extends AbstractAdminManager
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @var array|\WellCommerce\Bundle\IntlBundle\Entity\Locale[]
     */
    protected $locales;

    /**
     * @var array
     */
    protected $filesystemTranslations = [];

    /**
     * @var array
     */
    protected $databaseTranslations = [];

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @var PurgerInterface
     */
    protected $purger;

    /**
     * @param PurgerInterface $purger
     */
    public function setDictionaryPurger(PurgerInterface $purger)
    {
        $this->purger = $purger;
    }

    /**
     * Synchronizes database and filesystem translations
     *
     * @param Request         $request
     * @param KernelInterface $kernel
     */
    public function syncDictionary(Request $request, KernelInterface $kernel)
    {
        $this->kernel           = $kernel;
        $this->currentLocale    = $request->getLocale();
        $this->locales          = $this->getLocales();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

        $this->purger->purge();
        $this->loadFilesystemTranslations();

        $this->loadDatabaseTranslations();
        $this->mergeAndSaveTranslations();

    }

    /**
     * Loads filesystem translations found in Resource folder
     */
    protected function loadFilesystemTranslations()
    {
        foreach ($this->locales as $locale) {
            $messages     = $this->get('translator')->getMessages($locale->getCode());
            $translations = $this->propertyAccessor->getValue($messages, '[wellcommerce]');
            $this->importMessages($translations, $locale);
        }

        die();
    }

    /**
     * Imports the translations
     *
     * @param array           $messages
     * @param LocaleInterface $locale
     */
    protected function importMessages(array $messages = [], LocaleInterface $locale)
    {
        $em = $this->getDoctrineHelper()->getEntityManager();

        foreach ($messages as $identifier => $translation) {
            $dictionary = new Dictionary();
            $dictionary->setIdentifier($identifier);
            $dictionary->translate($locale->getCode())->setValue($translation);
            $dictionary->mergeNewTranslations();
            $em->persist($dictionary);
        }

        $em->flush();

        die();
    }

    /**
     * Returns parsed translations from filesystem
     *
     * @param Locale $locale
     */
    protected function getFilesystemTranslationsForLocale(Locale $locale)
    {
        $filename   = sprintf('wellcommerce.%s.yml', $locale->getCode());
        $filesystem = $this->getFilesystem();
        $path       = $this->getFilesystemTranslationsPath() . DIRECTORY_SEPARATOR . $filename;
        if ($filesystem->exists($path)) {
            return $this->parseYaml($path);
        }

        return [];
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return new Filesystem();
    }

    protected function getFilesystemTranslationsPath()
    {
        $kernelDir = $this->kernel->getRootDir();

        return $kernelDir . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'translations';
    }

    /**
     * Parses yaml file containing translations
     *
     * @param string $content
     *
     * @return array
     */
    protected function parseYaml($content)
    {
        $yaml = new Yaml();

        return $yaml->parse($content);
    }

    /**
     * Load translations from database
     */
    protected function loadDatabaseTranslations()
    {
        $em           = $this->getDoctrineHelper()->getEntityManager();
        $repository   = $em->getRepository('WellCommerceIntlBundle:Dictionary');
        $translations = $repository->findAll();
        foreach ($translations as $translation) {
            $this->addDatabaseTranslation($translation);
        }
    }

    /**
     *
     * @param Dictionary $dictionary
     */
    protected function addDatabaseTranslation(Dictionary $dictionary)
    {
        foreach ($this->locales as $locale) {
            $translation  = $dictionary->translate($locale->getCode())->getValue();
            $propertyPath = '[' . $locale->getCode() . ']' . Helper::convertDotNotation($dictionary->getIdentifier());
            $this->propertyAccessor->setValue($this->databaseTranslations, $propertyPath, $translation);
        }
    }

    /**
     * Merges and saves translations to filesystem and database
     */
    protected function mergeAndSaveTranslations()
    {
        $filesystem         = $this->getFilesystem();
        $mergedTranslations = array_replace_recursive($this->filesystemTranslations, $this->databaseTranslations);
        $this->getDoctrineHelper()->truncateTable('WellCommerceIntlBundle:Dictionary');

        foreach ($mergedTranslations as $locale => $data) {
            $filename = sprintf('wellcommerce.%s.yml', $locale);
            $path     = $this->getFilesystemTranslationsPath() . DIRECTORY_SEPARATOR . $filename;
            $content  = Yaml::dump($data, 6);
            $filesystem->dumpFile($path, $content);
        }

        $this->syncDatabaseTranslations($mergedTranslations);
    }

    /**
     * Synchronizes translations to database
     *
     * @param array $mergedTranslations
     */
    protected function syncDatabaseTranslations(array $mergedTranslations)
    {
        foreach ($mergedTranslations as $locale => $data) {
            $flattened = Helper::flattenArrayToDotNotation($data);
            $this->saveDatabaseTranslations($locale, $flattened);
        }
    }

    /**
     * Saves translations for particular locale
     *
     * @param string $locale
     * @param array  $data
     */
    protected function saveDatabaseTranslations($locale, array $data)
    {
        $em = $this->getDoctrineHelper()->getEntityManager();

        foreach ($data as $identifier => $value) {
            $dictionary = new Dictionary();
            $dictionary->setIdentifier($identifier);
            $dictionary->translate($locale)->setValue($value);
            $dictionary->mergeNewTranslations();
            $em->persist($dictionary);
        }

        $em->flush();
    }

}


