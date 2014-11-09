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

namespace WellCommerce\Bundle\IntlBundle\Controller\Admin;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class DictionaryController
 *
 * @package WellCommerce\Bundle\IntlBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class DictionaryController extends AbstractAdminController
{
    private $fsTranslations = [];
    private $dbTranslations = [];

    /**
     * Synchronizes translations bi-directional. First fetches translations from filesystem than from database.
     * Merges translations into one array and synchronizes database and filesystem.
     */
    public function synchronizeAction()
    {
        $this->getFilesystemTranslations();
        $this->getDbTranslations();

        $result       = $this->get('dictionary.repository')->getDictionaryTranslations();
        $translations = [];
        $accessor     = $this->getPropertyAccessor();

        foreach ($result as $translation) {
            $propertyPath = '[' . $translation['locale'] . ']' . Helper::convertDotNotation($translation['identifier']);
            $accessor->setValue($translations, $propertyPath, $translation['translation']);
        }

        $kernelDir = $this->get('kernel')->getRootDir();
        $path      = $kernelDir . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'translations';
        $fs        = new Filesystem();

        foreach ($translations as $locale => $nodes) {
            $filename = sprintf('wellcommerce.%s.yml', $locale);
            $content  = '#This file was auto-generated. Please do not change it directly.' . PHP_EOL;
            $content .= Yaml::dump($nodes, 6);
            $fs->dumpFile($path . DIRECTORY_SEPARATOR . $filename, $content);
        }

        $this->manager->getFlashHelper()->addSuccess('admin.translation.synchronize.success');

        return $this->manager->getRedirectHelper()->redirectToAction('index');
    }

    private function getFilesystemTranslations()
    {
        $locales   = $this->get('locale.repository')->getAvailableLocales();
        $fs        = new Filesystem();
        $kernelDir = $this->get('kernel')->getRootDir();
        $path      = $kernelDir . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'translations';

        foreach ($locales as $locale) {
            $filename = sprintf('wellcommerce.%s.yml', $locale['code']);
            if ($fs->exists($path . DIRECTORY_SEPARATOR . $filename)) {
                $contents                              = file_get_contents($path . DIRECTORY_SEPARATOR . $filename);
                $result                                = Yaml::parse($contents);
                $this->fsTranslations[$locale['code']] = $result;
            }
        }
    }

    private function getDbTranslations()
    {
        $result   = $this->get('dictionary.repository')->getDictionaryTranslations();
        $accessor = $this->getPropertyAccessor();

        foreach ($result as $translation) {
            $propertyPath = '[' . $translation['locale'] . ']' . Helper::convertDotNotation($translation['identifier']);
            $accessor->setValue($this->dbTranslations, $propertyPath, $translation['translation']);
        }
    }
}
