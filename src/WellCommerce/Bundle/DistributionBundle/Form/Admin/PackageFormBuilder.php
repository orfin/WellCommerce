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
namespace WellCommerce\Bundle\DistributionBundle\Form\Admin;

use Packagist\Api\Result\Package\Version;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\DistributionBundle\Helper\Package\PackageHelperInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class PackageFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $packageForm)
    {
        $router    = $this->getRouterHelper();
        $helper    = $this->get('environment_helper');
        $package   = $this->getRequestHelper()->getAttributesBagParam('id');
        $operation = $this->getRequestHelper()->getAttributesBagParam('operation');
        $port      = $helper->getFreePort();
        $versions  = $this->getPackageVersions($package);

        $packageData = $packageForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'package_data',
            'label' => $this->trans('package.fieldset.information')
        ]));

        foreach ($versions as $version) {

            $license = implode('<br />', $version['license']);

            $packageData->addChild($this->getElement('static_text', [
                'text' => "
                    <table>
                        <tr><td><strong>Release date:</strong></td><td>{$version['date']}</td></tr>
                        <tr><td><strong>Description:</strong></td><td>{$version['description']}</td></tr>
                        <tr><td><strong>License:</strong></td><td>{$license}</td></tr>
                    </table>
                "
            ]));
        }

        $packageRequiredData = $packageForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'progress_data',
            'label' => $this->trans('package.fieldset.progress')
        ]));

        $packageRequiredData->addChild($this->getElement('console_output', [
            'name'        => 'console_output',
            'label'       => $this->trans('package.label.console_output'),
            'port'        => $port,
            'console_url' => $router->generateUrl(
                'admin.package.console', [
                    'id'        => $package,
                    'operation' => $operation,
                    'port'      => $port
                ]
            )
        ]));
    }

    /**
     * Returns version information for package
     *
     * @param $id
     *
     * @return array
     */
    protected function getPackageVersions($id)
    {
        $localPackage  = $this->get('package.repository')->findOneById($id);
        $remotePackage = $this->get('package.helper')->getPackage($localPackage->getFullName());
        $versions      = $remotePackage->getVersions();
        $result        = [];

        foreach ($versions as $version) {
            $this->getPackageInfo($version, $result);
        }

        return $result;
    }

    /**
     * Adds information about single version to result array
     *
     * @param Version $version
     * @param array   $result
     */
    protected function getPackageInfo(Version $version, &$result)
    {
        $date           = new \DateTime($version->getTime());
        $packageVersion = $version->getVersion();
        if ($packageVersion === PackageHelperInterface::DEFAULT_BRANCH_VERSION) {
            $result[$packageVersion] = [
                'version'     => $packageVersion,
                'date'        => $date->format('Y-m-d H:i:s'),
                'authors'     => $version->getAuthors(),
                'description' => $version->getDescription(),
                'homepage'    => $version->getHomepage(),
                'license'     => $version->getLicense(),
            ];
        }
    }
}

