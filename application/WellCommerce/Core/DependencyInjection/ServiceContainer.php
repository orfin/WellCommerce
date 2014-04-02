<?php
namespace WellCommerce\Core\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ServiceContainer
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ServiceContainer extends Container
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();

        $this->set('service_container', $this);

        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'admin_menu.repository' => 'getAdminMenu_RepositoryService',
            'admin_menu.subscriber' => 'getAdminMenu_SubscriberService',
            'availability.admin.controller' => 'getAvailability_Admin_ControllerService',
            'availability.datagrid' => 'getAvailability_DatagridService',
            'availability.form' => 'getAvailability_FormService',
            'availability.repository' => 'getAvailability_RepositoryService',
            'cache_manager' => 'getCacheManagerService',
            'cache_manager.datagrid' => 'getCacheManager_DatagridService',
            'cache_manager.repository' => 'getCacheManager_RepositoryService',
            'category.form' => 'getCategory_FormService',
            'category.repository' => 'getCategory_RepositoryService',
            'category.tree' => 'getCategory_TreeService',
            'category_box.layout.configurator' => 'getCategoryBox_Layout_ConfiguratorService',
            'client_group.datagrid' => 'getClientGroup_DatagridService',
            'client_group.form' => 'getClientGroup_FormService',
            'client_group.repository' => 'getClientGroup_RepositoryService',
            'company.datagrid' => 'getCompany_DatagridService',
            'company.form' => 'getCompany_FormService',
            'company.repository' => 'getCompany_RepositoryService',
            'config_locator' => 'getConfigLocatorService',
            'contact.datagrid' => 'getContact_DatagridService',
            'contact.form' => 'getContact_FormService',
            'contact.repository' => 'getContact_RepositoryService',
            'contact_box.layout.configurator' => 'getContactBox_Layout_ConfiguratorService',
            'contact_page.layout' => 'getContactPage_LayoutService',
            'controller_resolver' => 'getControllerResolverService',
            'country.repository' => 'getCountry_RepositoryService',
            'currency.datagrid' => 'getCurrency_DatagridService',
            'currency.form' => 'getCurrency_FormService',
            'currency.repository' => 'getCurrency_RepositoryService',
            'dashboard.repository' => 'getDashboard_RepositoryService',
            'database_manager' => 'getDatabaseManagerService',
            'datagrid_renderer' => 'getDatagridRendererService',
            'deliverer.datagrid' => 'getDeliverer_DatagridService',
            'deliverer.form' => 'getDeliverer_FormService',
            'deliverer.repository' => 'getDeliverer_RepositoryService',
            'encryption' => 'getEncryptionService',
            'event_dispatcher' => 'getEventDispatcherService',
            'file.datagrid' => 'getFile_DatagridService',
            'file.repository' => 'getFile_RepositoryService',
            'filesystem' => 'getFilesystemService',
            'finder' => 'getFinderService',
            'form_helper' => 'getFormHelperService',
            'helper' => 'getHelperService',
            'home_page.layout' => 'getHomePage_LayoutService',
            'image_gallery' => 'getImageGalleryService',
            'kernel' => 'getKernelService',
            'language.datagrid' => 'getLanguage_DatagridService',
            'language.form' => 'getLanguage_FormService',
            'language.repository' => 'getLanguage_RepositoryService',
            'language.subscriber' => 'getLanguage_SubscriberService',
            'layout_box.datagrid' => 'getLayoutBox_DatagridService',
            'layout_box.form' => 'getLayoutBox_FormService',
            'layout_box.repository' => 'getLayoutBox_RepositoryService',
            'layout_manager' => 'getLayoutManagerService',
            'layout_page.form' => 'getLayoutPage_FormService',
            'layout_page.repository' => 'getLayoutPage_RepositoryService',
            'layout_page.tree' => 'getLayoutPage_TreeService',
            'layout_renderer' => 'getLayoutRendererService',
            'layout_theme.datagrid' => 'getLayoutTheme_DatagridService',
            'layout_theme.form' => 'getLayoutTheme_FormService',
            'layout_theme.repository' => 'getLayoutTheme_RepositoryService',
            'locale.listener' => 'getLocale_ListenerService',
            'payment_method.datagrid' => 'getPaymentMethod_DatagridService',
            'payment_method.form' => 'getPaymentMethod_FormService',
            'payment_method.processor.paypal' => 'getPaymentMethod_Processor_PaypalService',
            'payment_method.repository' => 'getPaymentMethod_RepositoryService',
            'paypal.datagrid' => 'getPaypal_DatagridService',
            'paypal.form' => 'getPaypal_FormService',
            'paypal.repository' => 'getPaypal_RepositoryService',
            'plugin_manager.datagrid' => 'getPluginManager_DatagridService',
            'plugin_manager.form' => 'getPluginManager_FormService',
            'plugin_manager.repository' => 'getPluginManager_RepositoryService',
            'producer.datagrid' => 'getProducer_DatagridService',
            'producer.form' => 'getProducer_FormService',
            'producer.repository' => 'getProducer_RepositoryService',
            'producer_box.layout.configurator' => 'getProducerBox_Layout_ConfiguratorService',
            'producer_list_box.layout.configurator' => 'getProducerListBox_Layout_ConfiguratorService',
            'producer_page.layout' => 'getProducerPage_LayoutService',
            'product.datagrid' => 'getProduct_DatagridService',
            'product.form' => 'getProduct_FormService',
            'product.repository' => 'getProduct_RepositoryService',
            'product_box.layout.configurator' => 'getProductBox_Layout_ConfiguratorService',
            'product_page.layout' => 'getProductPage_LayoutService',
            'request' => 'getRequestService',
            'request_stack' => 'getRequestStackService',
            'router' => 'getRouterService',
            'router.loader' => 'getRouter_LoaderService',
            'router.subscriber' => 'getRouter_SubscriberService',
            'session' => 'getSessionService',
            'session.handler' => 'getSession_HandlerService',
            'session.storage' => 'getSession_StorageService',
            'shipping_method.calculator' => 'getShippingMethod_CalculatorService',
            'shipping_method.calculator.cart_total_table' => 'getShippingMethod_Calculator_CartTotalTableService',
            'shipping_method.calculator.fixed_price' => 'getShippingMethod_Calculator_FixedPriceService',
            'shipping_method.calculator.item_quantity' => 'getShippingMethod_Calculator_ItemQuantityService',
            'shipping_method.calculator.weight_table' => 'getShippingMethod_Calculator_WeightTableService',
            'shipping_method.datagrid' => 'getShippingMethod_DatagridService',
            'shipping_method.form' => 'getShippingMethod_FormService',
            'shipping_method.repository' => 'getShippingMethod_RepositoryService',
            'shop.datagrid' => 'getShop_DatagridService',
            'shop.form' => 'getShop_FormService',
            'shop.repository' => 'getShop_RepositoryService',
            'shop.subscriber' => 'getShop_SubscriberService',
            'tax.datagrid' => 'getTax_DatagridService',
            'tax.form' => 'getTax_FormService',
            'tax.repository' => 'getTax_RepositoryService',
            'template_guesser' => 'getTemplateGuesserService',
            'template_listener' => 'getTemplateListenerService',
            'translation' => 'getTranslationService',
            'twig' => 'getTwigService',
            'twig.extension.asset' => 'getTwig_Extension_AssetService',
            'twig.extension.contact' => 'getTwig_Extension_ContactService',
            'twig.extension.datagrid' => 'getTwig_Extension_DatagridService',
            'twig.extension.debug' => 'getTwig_Extension_DebugService',
            'twig.extension.form' => 'getTwig_Extension_FormService',
            'twig.extension.intl' => 'getTwig_Extension_IntlService',
            'twig.extension.routing' => 'getTwig_Extension_RoutingService',
            'twig.extension.translation' => 'getTwig_Extension_TranslationService',
            'twig.loader.admin' => 'getTwig_Loader_AdminService',
            'twig.loader.front' => 'getTwig_Loader_FrontService',
            'unit.datagrid' => 'getUnit_DatagridService',
            'unit.form' => 'getUnit_FormService',
            'unit.repository' => 'getUnit_RepositoryService',
            'uploader' => 'getUploaderService',
            'xajax' => 'getXajaxService',
            'xajax_manager' => 'getXajaxManagerService',
        );

        $this->aliases = array();
    }

    /**
     * Gets the 'admin_menu.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\AdminMenu\Repository\AdminMenuRepository A WellCommerce\Plugin\AdminMenu\Repository\AdminMenuRepository instance.
     */
    protected function getAdminMenu_RepositoryService()
    {
        $this->services['admin_menu.repository'] = $instance = new \WellCommerce\Plugin\AdminMenu\Repository\AdminMenuRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'admin_menu.subscriber' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\AdminMenu\Event\AdminMenuEventSubscriber A WellCommerce\Plugin\AdminMenu\Event\AdminMenuEventSubscriber instance.
     */
    protected function getAdminMenu_SubscriberService()
    {
        return $this->services['admin_menu.subscriber'] = new \WellCommerce\Plugin\AdminMenu\Event\AdminMenuEventSubscriber();
    }

    /**
     * Gets the 'availability.admin.controller' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Availability\Controller\Admin\AvailabilityController A WellCommerce\Plugin\Availability\Controller\Admin\AvailabilityController instance.
     */
    protected function getAvailability_Admin_ControllerService()
    {
        $this->services['availability.admin.controller'] = $instance = new \WellCommerce\Plugin\Availability\Controller\Admin\AvailabilityController();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'availability.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Availability\DataGrid\AvailabilityDataGrid A WellCommerce\Plugin\Availability\DataGrid\AvailabilityDataGrid instance.
     */
    protected function getAvailability_DatagridService()
    {
        $this->services['availability.datagrid'] = $instance = new \WellCommerce\Plugin\Availability\DataGrid\AvailabilityDataGrid();

        $instance->setRepository($this->get('availability.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'availability.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Availability\Form\AvailabilityForm A WellCommerce\Plugin\Availability\Form\AvailabilityForm instance.
     */
    protected function getAvailability_FormService()
    {
        $this->services['availability.form'] = $instance = new \WellCommerce\Plugin\Availability\Form\AvailabilityForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'availability.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Availability\Repository\AvailabilityRepository A WellCommerce\Plugin\Availability\Repository\AvailabilityRepository instance.
     */
    protected function getAvailability_RepositoryService()
    {
        $this->services['availability.repository'] = $instance = new \WellCommerce\Plugin\Availability\Repository\AvailabilityRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'cache_manager' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Doctrine\Common\Cache\FilesystemCache A Doctrine\Common\Cache\FilesystemCache instance.
     */
    protected function getCacheManagerService()
    {
        return $this->services['cache_manager'] = new \Doctrine\Common\Cache\FilesystemCache('D:\\Git\\WellCommerce\\var/serialization');
    }

    /**
     * Gets the 'cache_manager.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\CacheManager\DataGrid\CacheManagerDataGrid A WellCommerce\Plugin\CacheManager\DataGrid\CacheManagerDataGrid instance.
     */
    protected function getCacheManager_DatagridService()
    {
        $this->services['cache_manager.datagrid'] = $instance = new \WellCommerce\Plugin\CacheManager\DataGrid\CacheManagerDataGrid();

        $instance->setRepository($this->get('cache_manager.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'cache_manager.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\CacheManager\Repository\CacheManagerRepository A WellCommerce\Plugin\CacheManager\Repository\CacheManagerRepository instance.
     */
    protected function getCacheManager_RepositoryService()
    {
        $this->services['cache_manager.repository'] = $instance = new \WellCommerce\Plugin\CacheManager\Repository\CacheManagerRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'category.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Category\Form\CategoryForm A WellCommerce\Plugin\Category\Form\CategoryForm instance.
     */
    protected function getCategory_FormService()
    {
        $this->services['category.form'] = $instance = new \WellCommerce\Plugin\Category\Form\CategoryForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'category.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Category\Repository\CategoryRepository A WellCommerce\Plugin\Category\Repository\CategoryRepository instance.
     */
    protected function getCategory_RepositoryService()
    {
        $this->services['category.repository'] = $instance = new \WellCommerce\Plugin\Category\Repository\CategoryRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'category.tree' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Category\Form\CategoryTree A WellCommerce\Plugin\Category\Form\CategoryTree instance.
     */
    protected function getCategory_TreeService()
    {
        $this->services['category.tree'] = $instance = new \WellCommerce\Plugin\Category\Form\CategoryTree();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'category_box.layout.configurator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Category\Layout\CategoryBoxConfigurator A WellCommerce\Plugin\Category\Layout\CategoryBoxConfigurator instance.
     */
    protected function getCategoryBox_Layout_ConfiguratorService()
    {
        $this->services['category_box.layout.configurator'] = $instance = new \WellCommerce\Plugin\Category\Layout\CategoryBoxConfigurator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'client_group.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ClientGroup\DataGrid\ClientGroupDataGrid A WellCommerce\Plugin\ClientGroup\DataGrid\ClientGroupDataGrid instance.
     */
    protected function getClientGroup_DatagridService()
    {
        $this->services['client_group.datagrid'] = $instance = new \WellCommerce\Plugin\ClientGroup\DataGrid\ClientGroupDataGrid();

        $instance->setRepository($this->get('client_group.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'client_group.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ClientGroup\Form\ClientGroupForm A WellCommerce\Plugin\ClientGroup\Form\ClientGroupForm instance.
     */
    protected function getClientGroup_FormService()
    {
        $this->services['client_group.form'] = $instance = new \WellCommerce\Plugin\ClientGroup\Form\ClientGroupForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'client_group.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ClientGroup\Repository\ClientGroupRepository A WellCommerce\Plugin\ClientGroup\Repository\ClientGroupRepository instance.
     */
    protected function getClientGroup_RepositoryService()
    {
        $this->services['client_group.repository'] = $instance = new \WellCommerce\Plugin\ClientGroup\Repository\ClientGroupRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'company.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Company\DataGrid\CompanyDataGrid A WellCommerce\Plugin\Company\DataGrid\CompanyDataGrid instance.
     */
    protected function getCompany_DatagridService()
    {
        $this->services['company.datagrid'] = $instance = new \WellCommerce\Plugin\Company\DataGrid\CompanyDataGrid();

        $instance->setRepository($this->get('company.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'company.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Company\Form\CompanyForm A WellCommerce\Plugin\Company\Form\CompanyForm instance.
     */
    protected function getCompany_FormService()
    {
        $this->services['company.form'] = $instance = new \WellCommerce\Plugin\Company\Form\CompanyForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'company.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Company\Repository\CompanyRepository A WellCommerce\Plugin\Company\Repository\CompanyRepository instance.
     */
    protected function getCompany_RepositoryService()
    {
        $this->services['company.repository'] = $instance = new \WellCommerce\Plugin\Company\Repository\CompanyRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'config_locator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Config\FileLocator A Symfony\Component\Config\FileLocator instance.
     */
    protected function getConfigLocatorService()
    {
        return $this->services['config_locator'] = new \Symfony\Component\Config\FileLocator('D:\\Git\\WellCommerce\\config');
    }

    /**
     * Gets the 'contact.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\DataGrid\ContactDataGrid A WellCommerce\Plugin\Contact\DataGrid\ContactDataGrid instance.
     */
    protected function getContact_DatagridService()
    {
        $this->services['contact.datagrid'] = $instance = new \WellCommerce\Plugin\Contact\DataGrid\ContactDataGrid();

        $instance->setRepository($this->get('contact.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'contact.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\Form\ContactForm A WellCommerce\Plugin\Contact\Form\ContactForm instance.
     */
    protected function getContact_FormService()
    {
        $this->services['contact.form'] = $instance = new \WellCommerce\Plugin\Contact\Form\ContactForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'contact.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\Repository\ContactRepository A WellCommerce\Plugin\Contact\Repository\ContactRepository instance.
     */
    protected function getContact_RepositoryService()
    {
        $this->services['contact.repository'] = $instance = new \WellCommerce\Plugin\Contact\Repository\ContactRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'contact_box.layout.configurator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\Layout\ContactBoxConfigurator A WellCommerce\Plugin\Contact\Layout\ContactBoxConfigurator instance.
     */
    protected function getContactBox_Layout_ConfiguratorService()
    {
        $this->services['contact_box.layout.configurator'] = $instance = new \WellCommerce\Plugin\Contact\Layout\ContactBoxConfigurator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'contact_page.layout' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\Layout\ContactLayoutPage A WellCommerce\Plugin\Contact\Layout\ContactLayoutPage instance.
     */
    protected function getContactPage_LayoutService()
    {
        $this->services['contact_page.layout'] = $instance = new \WellCommerce\Plugin\Contact\Layout\ContactLayoutPage();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'controller_resolver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Component\Controller\ControllerResolver A WellCommerce\Core\Component\Controller\ControllerResolver instance.
     */
    protected function getControllerResolverService()
    {
        return $this->services['controller_resolver'] = new \WellCommerce\Core\Component\Controller\ControllerResolver($this);
    }

    /**
     * Gets the 'country.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Country\Repository\CountryRepository A WellCommerce\Plugin\Country\Repository\CountryRepository instance.
     */
    protected function getCountry_RepositoryService()
    {
        $this->services['country.repository'] = $instance = new \WellCommerce\Plugin\Country\Repository\CountryRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'currency.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Currency\DataGrid\CurrencyDataGrid A WellCommerce\Plugin\Currency\DataGrid\CurrencyDataGrid instance.
     */
    protected function getCurrency_DatagridService()
    {
        $this->services['currency.datagrid'] = $instance = new \WellCommerce\Plugin\Currency\DataGrid\CurrencyDataGrid();

        $instance->setRepository($this->get('currency.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'currency.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Currency\Form\CurrencyForm A WellCommerce\Plugin\Currency\Form\CurrencyForm instance.
     */
    protected function getCurrency_FormService()
    {
        $this->services['currency.form'] = $instance = new \WellCommerce\Plugin\Currency\Form\CurrencyForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'currency.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Currency\Repository\CurrencyRepository A WellCommerce\Plugin\Currency\Repository\CurrencyRepository instance.
     */
    protected function getCurrency_RepositoryService()
    {
        $this->services['currency.repository'] = $instance = new \WellCommerce\Plugin\Currency\Repository\CurrencyRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'dashboard.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Dashboard\Repository\DashboardRepository A WellCommerce\Plugin\Dashboard\Repository\DashboardRepository instance.
     */
    protected function getDashboard_RepositoryService()
    {
        $this->services['dashboard.repository'] = $instance = new \WellCommerce\Plugin\Dashboard\Repository\DashboardRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'database_manager' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Illuminate\Database\Capsule\Manager A Illuminate\Database\Capsule\Manager instance.
     */
    protected function getDatabaseManagerService()
    {
        $this->services['database_manager'] = $instance = new \Illuminate\Database\Capsule\Manager();

        $instance->addConnection(array('driver' => 'mysql', 'host' => 'localhost', 'database' => 'gekosale3', 'username' => 'root', 'password' => '', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci', 'prefix' => ''));
        $instance->setAsGlobal();
        $instance->bootEloquent();

        return $instance;
    }

    /**
     * Gets the 'datagrid_renderer' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\DataGrid\Renderer A WellCommerce\Core\DataGrid\Renderer instance.
     */
    protected function getDatagridRendererService()
    {
        $this->services['datagrid_renderer'] = $instance = new \WellCommerce\Core\DataGrid\Renderer();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'deliverer.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Deliverer\DataGrid\DelivererDataGrid A WellCommerce\Plugin\Deliverer\DataGrid\DelivererDataGrid instance.
     */
    protected function getDeliverer_DatagridService()
    {
        $this->services['deliverer.datagrid'] = $instance = new \WellCommerce\Plugin\Deliverer\DataGrid\DelivererDataGrid();

        $instance->setRepository($this->get('deliverer.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'deliverer.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Deliverer\Form\DelivererForm A WellCommerce\Plugin\Deliverer\Form\DelivererForm instance.
     */
    protected function getDeliverer_FormService()
    {
        $this->services['deliverer.form'] = $instance = new \WellCommerce\Plugin\Deliverer\Form\DelivererForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'deliverer.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Deliverer\Repository\DelivererRepository A WellCommerce\Plugin\Deliverer\Repository\DelivererRepository instance.
     */
    protected function getDeliverer_RepositoryService()
    {
        $this->services['deliverer.repository'] = $instance = new \WellCommerce\Plugin\Deliverer\Repository\DelivererRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'encryption' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Illuminate\Encryption\Encrypter A Illuminate\Encryption\Encrypter instance.
     */
    protected function getEncryptionService()
    {
        return $this->services['encryption'] = new \Illuminate\Encryption\Encrypter('abcdefghijklmnoprstuwxyz12345678');
    }

    /**
     * Gets the 'event_dispatcher' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher A Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher instance.
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher($this);

        $instance->addSubscriberService('router.subscriber', 'Symfony\\Component\\HttpKernel\\EventListener\\RouterListener');
        $instance->addSubscriberService('locale.listener', 'Symfony\\Component\\HttpKernel\\EventListener\\LocaleListener');
        $instance->addSubscriberService('template_listener', 'WellCommerce\\Core\\EventListener\\TemplateListener');
        $instance->addSubscriberService('router.subscriber', 'Symfony\\Component\\HttpKernel\\EventListener\\RouterListener');
        $instance->addSubscriberService('locale.listener', 'Symfony\\Component\\HttpKernel\\EventListener\\LocaleListener');
        $instance->addSubscriberService('template_listener', 'WellCommerce\\Core\\EventListener\\TemplateListener');
        $instance->addSubscriberService('admin_menu.subscriber', 'WellCommerce\\Plugin\\AdminMenu\\Event\\AdminMenuEventSubscriber');
        $instance->addSubscriberService('language.subscriber', 'WellCommerce\\Plugin\\Language\\Event\\LanguageEventSubscriber');
        $instance->addSubscriberService('shop.subscriber', 'WellCommerce\\Plugin\\Shop\\Event\\ShopEventSubscriber');

        return $instance;
    }

    /**
     * Gets the 'file.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\File\DataGrid\FileDataGrid A WellCommerce\Plugin\File\DataGrid\FileDataGrid instance.
     */
    protected function getFile_DatagridService()
    {
        $this->services['file.datagrid'] = $instance = new \WellCommerce\Plugin\File\DataGrid\FileDataGrid();

        $instance->setContainer($this);
        $instance->setRepository($this->get('file.repository'));

        return $instance;
    }

    /**
     * Gets the 'file.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\File\Repository\FileRepository A WellCommerce\Plugin\File\Repository\FileRepository instance.
     */
    protected function getFile_RepositoryService()
    {
        $this->services['file.repository'] = $instance = new \WellCommerce\Plugin\File\Repository\FileRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'filesystem' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Filesystem\Filesystem A Symfony\Component\Filesystem\Filesystem instance.
     */
    protected function getFilesystemService()
    {
        return $this->services['filesystem'] = new \Symfony\Component\Filesystem\Filesystem();
    }

    /**
     * Gets the 'finder' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Finder\Finder A Symfony\Component\Finder\Finder instance.
     */
    protected function getFinderService()
    {
        return $this->services['finder'] = new \Symfony\Component\Finder\Finder();
    }

    /**
     * Gets the 'form_helper' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Form A WellCommerce\Core\Form instance.
     */
    protected function getFormHelperService()
    {
        $this->services['form_helper'] = $instance = new \WellCommerce\Core\Form();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'helper' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Helper A WellCommerce\Core\Helper instance.
     */
    protected function getHelperService()
    {
        $this->services['helper'] = $instance = new \WellCommerce\Core\Helper();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'home_page.layout' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\HomePage\Layout\HomePageLayoutPage A WellCommerce\Plugin\HomePage\Layout\HomePageLayoutPage instance.
     */
    protected function getHomePage_LayoutService()
    {
        $this->services['home_page.layout'] = $instance = new \WellCommerce\Plugin\HomePage\Layout\HomePageLayoutPage();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'image_gallery' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\ImageGallery A WellCommerce\Core\ImageGallery instance.
     */
    protected function getImageGalleryService()
    {
        $this->services['image_gallery'] = $instance = new \WellCommerce\Core\ImageGallery();

        $instance->setContainer($this);
        $instance->setPaths(array('original' => 'upload/gallery/original', 'cache' => 'upload/gallery/cache'));
        $instance->setFiles();

        return $instance;
    }

    /**
     * Gets the 'kernel' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel A Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel instance.
     */
    protected function getKernelService()
    {
        return $this->services['kernel'] = new \Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel($this->get('event_dispatcher'), $this, $this->get('controller_resolver'), $this->get('request_stack'));
    }

    /**
     * Gets the 'language.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Language\DataGrid\LanguageDataGrid A WellCommerce\Plugin\Language\DataGrid\LanguageDataGrid instance.
     */
    protected function getLanguage_DatagridService()
    {
        $this->services['language.datagrid'] = $instance = new \WellCommerce\Plugin\Language\DataGrid\LanguageDataGrid();

        $instance->setRepository($this->get('language.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'language.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Language\Form\LanguageForm A WellCommerce\Plugin\Language\Form\LanguageForm instance.
     */
    protected function getLanguage_FormService()
    {
        $this->services['language.form'] = $instance = new \WellCommerce\Plugin\Language\Form\LanguageForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'language.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Language\Repository\LanguageRepository A WellCommerce\Plugin\Language\Repository\LanguageRepository instance.
     */
    protected function getLanguage_RepositoryService()
    {
        $this->services['language.repository'] = $instance = new \WellCommerce\Plugin\Language\Repository\LanguageRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'language.subscriber' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Language\Event\LanguageEventSubscriber A WellCommerce\Plugin\Language\Event\LanguageEventSubscriber instance.
     */
    protected function getLanguage_SubscriberService()
    {
        return $this->services['language.subscriber'] = new \WellCommerce\Plugin\Language\Event\LanguageEventSubscriber();
    }

    /**
     * Gets the 'layout_box.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\DataGrid\LayoutBoxDataGrid A WellCommerce\Plugin\Layout\DataGrid\LayoutBoxDataGrid instance.
     */
    protected function getLayoutBox_DatagridService()
    {
        $this->services['layout_box.datagrid'] = $instance = new \WellCommerce\Plugin\Layout\DataGrid\LayoutBoxDataGrid();

        $instance->setRepository($this->get('layout_box.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_box.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Form\LayoutBoxForm A WellCommerce\Plugin\Layout\Form\LayoutBoxForm instance.
     */
    protected function getLayoutBox_FormService()
    {
        $this->services['layout_box.form'] = $instance = new \WellCommerce\Plugin\Layout\Form\LayoutBoxForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_box.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Repository\LayoutBoxRepository A WellCommerce\Plugin\Layout\Repository\LayoutBoxRepository instance.
     */
    protected function getLayoutBox_RepositoryService()
    {
        $this->services['layout_box.repository'] = $instance = new \WellCommerce\Plugin\Layout\Repository\LayoutBoxRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_manager' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\LayoutManager A WellCommerce\Core\LayoutManager instance.
     */
    protected function getLayoutManagerService()
    {
        $this->services['layout_manager'] = $instance = new \WellCommerce\Core\LayoutManager();

        $instance->setContainer($this);
        $instance->addLayoutBoxConfigurator($this->get('category_box.layout.configurator'));
        $instance->addLayoutBoxConfigurator($this->get('contact_box.layout.configurator'));
        $instance->addLayoutBoxConfigurator($this->get('producer_box.layout.configurator'));
        $instance->addLayoutBoxConfigurator($this->get('producer_list_box.layout.configurator'));
        $instance->addLayoutBoxConfigurator($this->get('product_box.layout.configurator'));
        $instance->addLayoutPage('Contact', $this->get('contact_page.layout'));
        $instance->addLayoutPage('HomePage', $this->get('home_page.layout'));
        $instance->addLayoutPage('Producer', $this->get('producer_page.layout'));
        $instance->addLayoutPage('Product', $this->get('product_page.layout'));

        return $instance;
    }

    /**
     * Gets the 'layout_page.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Form\LayoutPageForm A WellCommerce\Plugin\Layout\Form\LayoutPageForm instance.
     */
    protected function getLayoutPage_FormService()
    {
        $this->services['layout_page.form'] = $instance = new \WellCommerce\Plugin\Layout\Form\LayoutPageForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_page.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Repository\LayoutPageRepository A WellCommerce\Plugin\Layout\Repository\LayoutPageRepository instance.
     */
    protected function getLayoutPage_RepositoryService()
    {
        $this->services['layout_page.repository'] = $instance = new \WellCommerce\Plugin\Layout\Repository\LayoutPageRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_page.tree' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Form\LayoutPageTree A WellCommerce\Plugin\Layout\Form\LayoutPageTree instance.
     */
    protected function getLayoutPage_TreeService()
    {
        $this->services['layout_page.tree'] = $instance = new \WellCommerce\Plugin\Layout\Form\LayoutPageTree();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_renderer' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Layout\LayoutRenderer A WellCommerce\Core\Layout\LayoutRenderer instance.
     */
    protected function getLayoutRendererService()
    {
        $this->services['layout_renderer'] = $instance = new \WellCommerce\Core\Layout\LayoutRenderer();

        $instance->setContainer($this);
        $instance->setLayoutBoxRepository($this->get('layout_box.repository'));

        return $instance;
    }

    /**
     * Gets the 'layout_theme.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\DataGrid\LayoutThemeDataGrid A WellCommerce\Plugin\Layout\DataGrid\LayoutThemeDataGrid instance.
     */
    protected function getLayoutTheme_DatagridService()
    {
        $this->services['layout_theme.datagrid'] = $instance = new \WellCommerce\Plugin\Layout\DataGrid\LayoutThemeDataGrid();

        $instance->setRepository($this->get('layout_theme.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_theme.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Form\LayoutThemeForm A WellCommerce\Plugin\Layout\Form\LayoutThemeForm instance.
     */
    protected function getLayoutTheme_FormService()
    {
        $this->services['layout_theme.form'] = $instance = new \WellCommerce\Plugin\Layout\Form\LayoutThemeForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'layout_theme.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Layout\Repository\LayoutThemeRepository A WellCommerce\Plugin\Layout\Repository\LayoutThemeRepository instance.
     */
    protected function getLayoutTheme_RepositoryService()
    {
        $this->services['layout_theme.repository'] = $instance = new \WellCommerce\Plugin\Layout\Repository\LayoutThemeRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'locale.listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\EventListener\LocaleListener A Symfony\Component\HttpKernel\EventListener\LocaleListener instance.
     */
    protected function getLocale_ListenerService()
    {
        return $this->services['locale.listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleListener();
    }

    /**
     * Gets the 'payment_method.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PaymentMethod\DataGrid\PaymentMethodDataGrid A WellCommerce\Plugin\PaymentMethod\DataGrid\PaymentMethodDataGrid instance.
     */
    protected function getPaymentMethod_DatagridService()
    {
        $this->services['payment_method.datagrid'] = $instance = new \WellCommerce\Plugin\PaymentMethod\DataGrid\PaymentMethodDataGrid();

        $instance->setRepository($this->get('payment_method.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'payment_method.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PaymentMethod\Form\PaymentMethodForm A WellCommerce\Plugin\PaymentMethod\Form\PaymentMethodForm instance.
     */
    protected function getPaymentMethod_FormService()
    {
        $this->services['payment_method.form'] = $instance = new \WellCommerce\Plugin\PaymentMethod\Form\PaymentMethodForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'payment_method.processor.paypal' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PaymentMethod\Processor\PayPalProcessor A WellCommerce\Plugin\PaymentMethod\Processor\PayPalProcessor instance.
     */
    protected function getPaymentMethod_Processor_PaypalService()
    {
        return $this->services['payment_method.processor.paypal'] = new \WellCommerce\Plugin\PaymentMethod\Processor\PayPalProcessor();
    }

    /**
     * Gets the 'payment_method.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PaymentMethod\Repository\PaymentMethodRepository A WellCommerce\Plugin\PaymentMethod\Repository\PaymentMethodRepository instance.
     */
    protected function getPaymentMethod_RepositoryService()
    {
        $this->services['payment_method.repository'] = $instance = new \WellCommerce\Plugin\PaymentMethod\Repository\PaymentMethodRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'paypal.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PayPal\DataGrid\PayPalDataGrid A WellCommerce\Plugin\PayPal\DataGrid\PayPalDataGrid instance.
     */
    protected function getPaypal_DatagridService()
    {
        $this->services['paypal.datagrid'] = $instance = new \WellCommerce\Plugin\PayPal\DataGrid\PayPalDataGrid();

        $instance->setRepository($this->get('paypal.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'paypal.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PayPal\Form\PayPalForm A WellCommerce\Plugin\PayPal\Form\PayPalForm instance.
     */
    protected function getPaypal_FormService()
    {
        $this->services['paypal.form'] = $instance = new \WellCommerce\Plugin\PayPal\Form\PayPalForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'paypal.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PayPal\Repository\PayPalRepository A WellCommerce\Plugin\PayPal\Repository\PayPalRepository instance.
     */
    protected function getPaypal_RepositoryService()
    {
        $this->services['paypal.repository'] = $instance = new \WellCommerce\Plugin\PayPal\Repository\PayPalRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'plugin_manager.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PluginManager\DataGrid\PluginManagerDataGrid A WellCommerce\Plugin\PluginManager\DataGrid\PluginManagerDataGrid instance.
     */
    protected function getPluginManager_DatagridService()
    {
        $this->services['plugin_manager.datagrid'] = $instance = new \WellCommerce\Plugin\PluginManager\DataGrid\PluginManagerDataGrid();

        $instance->setRepository($this->get('plugin_manager.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'plugin_manager.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PluginManager\Form\PluginManagerForm A WellCommerce\Plugin\PluginManager\Form\PluginManagerForm instance.
     */
    protected function getPluginManager_FormService()
    {
        $this->services['plugin_manager.form'] = $instance = new \WellCommerce\Plugin\PluginManager\Form\PluginManagerForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'plugin_manager.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\PluginManager\Repository\PluginManagerRepository A WellCommerce\Plugin\PluginManager\Repository\PluginManagerRepository instance.
     */
    protected function getPluginManager_RepositoryService()
    {
        $this->services['plugin_manager.repository'] = $instance = new \WellCommerce\Plugin\PluginManager\Repository\PluginManagerRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\DataGrid\ProducerDataGrid A WellCommerce\Plugin\Producer\DataGrid\ProducerDataGrid instance.
     */
    protected function getProducer_DatagridService()
    {
        $this->services['producer.datagrid'] = $instance = new \WellCommerce\Plugin\Producer\DataGrid\ProducerDataGrid();

        $instance->setRepository($this->get('producer.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\Form\ProducerForm A WellCommerce\Plugin\Producer\Form\ProducerForm instance.
     */
    protected function getProducer_FormService()
    {
        $this->services['producer.form'] = $instance = new \WellCommerce\Plugin\Producer\Form\ProducerForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\Repository\ProducerRepository A WellCommerce\Plugin\Producer\Repository\ProducerRepository instance.
     */
    protected function getProducer_RepositoryService()
    {
        $this->services['producer.repository'] = $instance = new \WellCommerce\Plugin\Producer\Repository\ProducerRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer_box.layout.configurator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\Layout\ProducerBoxConfigurator A WellCommerce\Plugin\Producer\Layout\ProducerBoxConfigurator instance.
     */
    protected function getProducerBox_Layout_ConfiguratorService()
    {
        $this->services['producer_box.layout.configurator'] = $instance = new \WellCommerce\Plugin\Producer\Layout\ProducerBoxConfigurator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer_list_box.layout.configurator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\Layout\ProducerListBoxConfigurator A WellCommerce\Plugin\Producer\Layout\ProducerListBoxConfigurator instance.
     */
    protected function getProducerListBox_Layout_ConfiguratorService()
    {
        $this->services['producer_list_box.layout.configurator'] = $instance = new \WellCommerce\Plugin\Producer\Layout\ProducerListBoxConfigurator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'producer_page.layout' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Producer\Layout\ProducerLayoutPage A WellCommerce\Plugin\Producer\Layout\ProducerLayoutPage instance.
     */
    protected function getProducerPage_LayoutService()
    {
        $this->services['producer_page.layout'] = $instance = new \WellCommerce\Plugin\Producer\Layout\ProducerLayoutPage();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'product.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Product\DataGrid\ProductDataGrid A WellCommerce\Plugin\Product\DataGrid\ProductDataGrid instance.
     */
    protected function getProduct_DatagridService()
    {
        $this->services['product.datagrid'] = $instance = new \WellCommerce\Plugin\Product\DataGrid\ProductDataGrid();

        $instance->setRepository($this->get('product.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'product.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Product\Form\ProductForm A WellCommerce\Plugin\Product\Form\ProductForm instance.
     */
    protected function getProduct_FormService()
    {
        $this->services['product.form'] = $instance = new \WellCommerce\Plugin\Product\Form\ProductForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'product.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Product\Repository\ProductRepository A WellCommerce\Plugin\Product\Repository\ProductRepository instance.
     */
    protected function getProduct_RepositoryService()
    {
        $this->services['product.repository'] = $instance = new \WellCommerce\Plugin\Product\Repository\ProductRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'product_box.layout.configurator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Product\Layout\ProductBoxConfigurator A WellCommerce\Plugin\Product\Layout\ProductBoxConfigurator instance.
     */
    protected function getProductBox_Layout_ConfiguratorService()
    {
        $this->services['product_box.layout.configurator'] = $instance = new \WellCommerce\Plugin\Product\Layout\ProductBoxConfigurator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'product_page.layout' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Product\Layout\ProductLayoutPage A WellCommerce\Plugin\Product\Layout\ProductLayoutPage instance.
     */
    protected function getProductPage_LayoutService()
    {
        $this->services['product_page.layout'] = $instance = new \WellCommerce\Plugin\Product\Layout\ProductLayoutPage();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'request' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @throws RuntimeException always since this service is expected to be injected dynamically
     */
    protected function getRequestService()
    {
        throw new RuntimeException('You have requested a synthetic service ("request"). The DIC does not know how to construct this service.');
    }

    /**
     * Gets the 'request_stack' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpFoundation\RequestStack A Symfony\Component\HttpFoundation\RequestStack instance.
     */
    protected function getRequestStackService()
    {
        return $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack();
    }

    /**
     * Gets the 'router' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Routing\Router A Symfony\Component\Routing\Router instance.
     */
    protected function getRouterService()
    {
        return $this->services['router'] = new \Symfony\Component\Routing\Router($this->get('router.loader'), '', array('cache_dir' => 'D:\\Git\\WellCommerce\\var', 'generator_cache_class' => 'WellCommerceUrlGenerator', 'matcher_cache_class' => 'WellCommerceUrlMatcher'));
    }

    /**
     * Gets the 'router.loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Routing\Loader\PhpFileLoader A Symfony\Component\Routing\Loader\PhpFileLoader instance.
     */
    protected function getRouter_LoaderService()
    {
        return $this->services['router.loader'] = new \Symfony\Component\Routing\Loader\PhpFileLoader($this->get('config_locator'));
    }

    /**
     * Gets the 'router.subscriber' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\EventListener\RouterListener A Symfony\Component\HttpKernel\EventListener\RouterListener instance.
     */
    protected function getRouter_SubscriberService()
    {
        return $this->services['router.subscriber'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener($this->get("router")->getMatcher(), NULL, NULL, $this->get('request_stack'));
    }

    /**
     * Gets the 'session' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpFoundation\Session\Session A Symfony\Component\HttpFoundation\Session\Session instance.
     */
    protected function getSessionService()
    {
        $this->services['session'] = $instance = new \Symfony\Component\HttpFoundation\Session\Session($this->get('session.storage'));

        $instance->start();

        return $instance;
    }

    /**
     * Gets the 'session.handler' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler A Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler instance.
     */
    protected function getSession_HandlerService()
    {
        return $this->services['session.handler'] = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler($this->get("database_manager")->getConnection()->getPdo(), array('db_table' => 'session'));
    }

    /**
     * Gets the 'session.storage' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage A Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage instance.
     */
    protected function getSession_StorageService()
    {
        return $this->services['session.storage'] = new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage(array(), $this->get('session.handler'));
    }

    /**
     * Gets the 'shipping_method.calculator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Calculator\Calculator A WellCommerce\Plugin\ShippingMethod\Calculator\Calculator instance.
     */
    protected function getShippingMethod_CalculatorService()
    {
        $this->services['shipping_method.calculator'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Calculator\Calculator();

        $instance->setContainer($this);
        $instance->addCalculator('cart_total_table', $this->get('shipping_method.calculator.cart_total_table'));
        $instance->addCalculator('fixed_price', $this->get('shipping_method.calculator.fixed_price'));
        $instance->addCalculator('item_quantity', $this->get('shipping_method.calculator.item_quantity'));
        $instance->addCalculator('weight_table', $this->get('shipping_method.calculator.weight_table'));

        return $instance;
    }

    /**
     * Gets the 'shipping_method.calculator.cart_total_table' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Calculator\CartTotalTableCalculator A WellCommerce\Plugin\ShippingMethod\Calculator\CartTotalTableCalculator instance.
     */
    protected function getShippingMethod_Calculator_CartTotalTableService()
    {
        $this->services['shipping_method.calculator.cart_total_table'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Calculator\CartTotalTableCalculator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.calculator.fixed_price' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Calculator\FixedPriceCalculator A WellCommerce\Plugin\ShippingMethod\Calculator\FixedPriceCalculator instance.
     */
    protected function getShippingMethod_Calculator_FixedPriceService()
    {
        $this->services['shipping_method.calculator.fixed_price'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Calculator\FixedPriceCalculator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.calculator.item_quantity' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Calculator\ItemQuantityCalculator A WellCommerce\Plugin\ShippingMethod\Calculator\ItemQuantityCalculator instance.
     */
    protected function getShippingMethod_Calculator_ItemQuantityService()
    {
        $this->services['shipping_method.calculator.item_quantity'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Calculator\ItemQuantityCalculator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.calculator.weight_table' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Calculator\WeightTableCalculator A WellCommerce\Plugin\ShippingMethod\Calculator\WeightTableCalculator instance.
     */
    protected function getShippingMethod_Calculator_WeightTableService()
    {
        $this->services['shipping_method.calculator.weight_table'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Calculator\WeightTableCalculator();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\DataGrid\ShippingMethodDataGrid A WellCommerce\Plugin\ShippingMethod\DataGrid\ShippingMethodDataGrid instance.
     */
    protected function getShippingMethod_DatagridService()
    {
        $this->services['shipping_method.datagrid'] = $instance = new \WellCommerce\Plugin\ShippingMethod\DataGrid\ShippingMethodDataGrid();

        $instance->setRepository($this->get('shipping_method.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Form\ShippingMethodForm A WellCommerce\Plugin\ShippingMethod\Form\ShippingMethodForm instance.
     */
    protected function getShippingMethod_FormService()
    {
        $this->services['shipping_method.form'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Form\ShippingMethodForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shipping_method.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\ShippingMethod\Repository\ShippingMethodRepository A WellCommerce\Plugin\ShippingMethod\Repository\ShippingMethodRepository instance.
     */
    protected function getShippingMethod_RepositoryService()
    {
        $this->services['shipping_method.repository'] = $instance = new \WellCommerce\Plugin\ShippingMethod\Repository\ShippingMethodRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shop.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Shop\DataGrid\ShopDataGrid A WellCommerce\Plugin\Shop\DataGrid\ShopDataGrid instance.
     */
    protected function getShop_DatagridService()
    {
        $this->services['shop.datagrid'] = $instance = new \WellCommerce\Plugin\Shop\DataGrid\ShopDataGrid();

        $instance->setRepository($this->get('shop.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shop.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Shop\Form\ShopForm A WellCommerce\Plugin\Shop\Form\ShopForm instance.
     */
    protected function getShop_FormService()
    {
        $this->services['shop.form'] = $instance = new \WellCommerce\Plugin\Shop\Form\ShopForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shop.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Shop\Repository\ShopRepository A WellCommerce\Plugin\Shop\Repository\ShopRepository instance.
     */
    protected function getShop_RepositoryService()
    {
        $this->services['shop.repository'] = $instance = new \WellCommerce\Plugin\Shop\Repository\ShopRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'shop.subscriber' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Shop\Event\ShopEventSubscriber A WellCommerce\Plugin\Shop\Event\ShopEventSubscriber instance.
     */
    protected function getShop_SubscriberService()
    {
        return $this->services['shop.subscriber'] = new \WellCommerce\Plugin\Shop\Event\ShopEventSubscriber();
    }

    /**
     * Gets the 'tax.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Tax\DataGrid\TaxDataGrid A WellCommerce\Plugin\Tax\DataGrid\TaxDataGrid instance.
     */
    protected function getTax_DatagridService()
    {
        $this->services['tax.datagrid'] = $instance = new \WellCommerce\Plugin\Tax\DataGrid\TaxDataGrid();

        $instance->setRepository($this->get('tax.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'tax.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Tax\Form\TaxForm A WellCommerce\Plugin\Tax\Form\TaxForm instance.
     */
    protected function getTax_FormService()
    {
        $this->services['tax.form'] = $instance = new \WellCommerce\Plugin\Tax\Form\TaxForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'tax.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Tax\Repository\TaxRepository A WellCommerce\Plugin\Tax\Repository\TaxRepository instance.
     */
    protected function getTax_RepositoryService()
    {
        $this->services['tax.repository'] = $instance = new \WellCommerce\Plugin\Tax\Repository\TaxRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'template_guesser' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Template\TemplateGuesser A WellCommerce\Core\Template\TemplateGuesser instance.
     */
    protected function getTemplateGuesserService()
    {
        return $this->services['template_guesser'] = new \WellCommerce\Core\Template\TemplateGuesser($this);
    }

    /**
     * Gets the 'template_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\EventListener\TemplateListener A WellCommerce\Core\EventListener\TemplateListener instance.
     */
    protected function getTemplateListenerService()
    {
        return $this->services['template_listener'] = new \WellCommerce\Core\EventListener\TemplateListener($this);
    }

    /**
     * Gets the 'translation' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Translation\Translation A WellCommerce\Core\Translation\Translation instance.
     */
    protected function getTranslationService()
    {
        return $this->services['translation'] = new \WellCommerce\Core\Translation\Translation($this, 'en_EN');
    }

    /**
     * Gets the 'twig' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Twig_Environment A Twig_Environment instance.
     */
    protected function getTwigService()
    {
        $a = $this->get('twig.extension.translation');
        $b = $this->get('twig.extension.routing');
        $c = $this->get('twig.extension.intl');
        $d = $this->get('twig.extension.debug');
        $e = $this->get('twig.extension.form');
        $f = $this->get('twig.extension.asset');
        $g = $this->get('twig.extension.datagrid');
        $h = $this->get('twig.extension.contact');

        $this->services['twig'] = $instance = new \Twig_Environment($this->get('twig.loader.front'), array('cache' => 'D:\\Git\\WellCommerce\\var/cache', 'auto_reload' => true, 'autoescape' => true, 'debug' => true));

        $instance->addExtension($a);
        $instance->addExtension($b);
        $instance->addExtension($c);
        $instance->addExtension($d);
        $instance->addExtension($e);
        $instance->addExtension($f);
        $instance->addExtension($g);
        $instance->addExtension($a);
        $instance->addExtension($b);
        $instance->addExtension($c);
        $instance->addExtension($d);
        $instance->addExtension($e);
        $instance->addExtension($f);
        $instance->addExtension($g);
        $instance->addExtension($a);
        $instance->addExtension($b);
        $instance->addExtension($c);
        $instance->addExtension($d);
        $instance->addExtension($e);
        $instance->addExtension($f);
        $instance->addExtension($g);
        $instance->addExtension($h);
        $instance->addExtension($a);
        $instance->addExtension($b);
        $instance->addExtension($c);
        $instance->addExtension($d);
        $instance->addExtension($e);
        $instance->addExtension($f);
        $instance->addExtension($g);
        $instance->addExtension($h);

        return $instance;
    }

    /**
     * Gets the 'twig.extension.asset' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Template\Twig\Extension\AssetExtension A WellCommerce\Core\Template\Twig\Extension\AssetExtension instance.
     */
    protected function getTwig_Extension_AssetService()
    {
        return $this->services['twig.extension.asset'] = new \WellCommerce\Core\Template\Twig\Extension\AssetExtension($this);
    }

    /**
     * Gets the 'twig.extension.contact' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Contact\Twig\Contact A WellCommerce\Plugin\Contact\Twig\Contact instance.
     */
    protected function getTwig_Extension_ContactService()
    {
        return $this->services['twig.extension.contact'] = new \WellCommerce\Plugin\Contact\Twig\Contact($this);
    }

    /**
     * Gets the 'twig.extension.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Template\Twig\Extension\DataGridExtension A WellCommerce\Core\Template\Twig\Extension\DataGridExtension instance.
     */
    protected function getTwig_Extension_DatagridService()
    {
        return $this->services['twig.extension.datagrid'] = new \WellCommerce\Core\Template\Twig\Extension\DataGridExtension($this);
    }

    /**
     * Gets the 'twig.extension.debug' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Twig_Extension_Debug A Twig_Extension_Debug instance.
     */
    protected function getTwig_Extension_DebugService()
    {
        return $this->services['twig.extension.debug'] = new \Twig_Extension_Debug();
    }

    /**
     * Gets the 'twig.extension.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Template\Twig\Extension\FormExtension A WellCommerce\Core\Template\Twig\Extension\FormExtension instance.
     */
    protected function getTwig_Extension_FormService()
    {
        return $this->services['twig.extension.form'] = new \WellCommerce\Core\Template\Twig\Extension\FormExtension($this);
    }

    /**
     * Gets the 'twig.extension.intl' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Twig_Extensions_Extension_Intl A Twig_Extensions_Extension_Intl instance.
     */
    protected function getTwig_Extension_IntlService()
    {
        return $this->services['twig.extension.intl'] = new \Twig_Extensions_Extension_Intl();
    }

    /**
     * Gets the 'twig.extension.routing' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Template\Twig\Extension\RoutingExtension A WellCommerce\Core\Template\Twig\Extension\RoutingExtension instance.
     */
    protected function getTwig_Extension_RoutingService()
    {
        return $this->services['twig.extension.routing'] = new \WellCommerce\Core\Template\Twig\Extension\RoutingExtension($this->get('router'), $this->get('request'));
    }

    /**
     * Gets the 'twig.extension.translation' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Bridge\Twig\Extension\TranslationExtension A Symfony\Bridge\Twig\Extension\TranslationExtension instance.
     */
    protected function getTwig_Extension_TranslationService()
    {
        return $this->services['twig.extension.translation'] = new \Symfony\Bridge\Twig\Extension\TranslationExtension($this->get('translation'));
    }

    /**
     * Gets the 'twig.loader.admin' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Twig_Loader_Filesystem A Twig_Loader_Filesystem instance.
     */
    protected function getTwig_Loader_AdminService()
    {
        return $this->services['twig.loader.admin'] = new \Twig_Loader_Filesystem(array(0 => 'D:\\Git\\WellCommerce\\design/templates'));
    }

    /**
     * Gets the 'twig.loader.front' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Twig_Loader_Filesystem A Twig_Loader_Filesystem instance.
     */
    protected function getTwig_Loader_FrontService()
    {
        return $this->services['twig.loader.front'] = new \Twig_Loader_Filesystem(array(0 => 'D:\\Git\\WellCommerce\\themes/WellCommerce/templates'));
    }

    /**
     * Gets the 'unit.datagrid' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Unit\DataGrid\UnitDataGrid A WellCommerce\Plugin\Unit\DataGrid\UnitDataGrid instance.
     */
    protected function getUnit_DatagridService()
    {
        $this->services['unit.datagrid'] = $instance = new \WellCommerce\Plugin\Unit\DataGrid\UnitDataGrid();

        $instance->setRepository($this->get('unit.repository'));
        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'unit.form' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Unit\Form\UnitForm A WellCommerce\Plugin\Unit\Form\UnitForm instance.
     */
    protected function getUnit_FormService()
    {
        $this->services['unit.form'] = $instance = new \WellCommerce\Plugin\Unit\Form\UnitForm();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'unit.repository' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Plugin\Unit\Repository\UnitRepository A WellCommerce\Plugin\Unit\Repository\UnitRepository instance.
     */
    protected function getUnit_RepositoryService()
    {
        $this->services['unit.repository'] = $instance = new \WellCommerce\Plugin\Unit\Repository\UnitRepository();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'uploader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Uploader A WellCommerce\Core\Uploader instance.
     */
    protected function getUploaderService()
    {
        $this->services['uploader'] = $instance = new \WellCommerce\Core\Uploader();

        $instance->setContainer($this);
        $instance->setPaths(array('original' => 'upload/gallery/original', 'cache' => 'upload/gallery/cache'));

        return $instance;
    }

    /**
     * Gets the 'xajax' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return xajax A xajax instance.
     */
    protected function getXajaxService()
    {
        return $this->services['xajax'] = new \xajax();
    }

    /**
     * Gets the 'xajax_manager' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return WellCommerce\Core\Helper\XajaxManager A WellCommerce\Core\Helper\XajaxManager instance.
     */
    protected function getXajaxManagerService()
    {
        return $this->services['xajax_manager'] = new \WellCommerce\Core\Helper\XajaxManager($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritDoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }
    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'application.root_path' => 'D:\\Git\\WellCommerce\\',
            'application.debug_mode' => true,
            'locale' => 'en_EN',
            'timezone' => 'Europe/London',
            'application.design_path' => 'D:\\Git\\WellCommerce\\design',
            'security.encryption_key' => 'abcdefghijklmnoprstuwxyz12345678',
            'application.themes_path' => 'D:\\Git\\WellCommerce\\themes',
            'application.gallery_paths' => array(
                'original' => 'upload/gallery/original',
                'cache' => 'upload/gallery/cache',
            ),
            'admin.themes' => array(
                0 => 'D:\\Git\\WellCommerce\\design/templates',
            ),
            'front.themes' => array(
                0 => 'D:\\Git\\WellCommerce\\themes/WellCommerce/templates',
            ),
            'router.options' => array(
                'cache_dir' => 'D:\\Git\\WellCommerce\\var',
                'generator_cache_class' => 'WellCommerceUrlGenerator',
                'matcher_cache_class' => 'WellCommerceUrlMatcher',
            ),
            'locales' => array(
                'pl_PL' => 'Polski',
                'en_EN' => 'English',
            ),
            'session.config' => array(
                'db_table' => 'session',
            ),
            'db.config' => array(
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'gekosale3',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ),
            'cache_manager.class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
            'config_locator.class' => 'Symfony\\Component\\Config\\FileLocator',
            'controller_resolver.class' => 'WellCommerce\\Core\\Component\\Controller\\ControllerResolver',
            'event_dispatcher.class' => 'Symfony\\Component\\EventDispatcher\\ContainerAwareEventDispatcher',
            'encryption.class' => 'Illuminate\\Encryption\\Encrypter',
            'finder.class' => 'Symfony\\Component\\Finder\\Finder',
            'filesystem.class' => 'Symfony\\Component\\Filesystem\\Filesystem',
            'form_helper.class' => 'WellCommerce\\Core\\Form',
            'helper.class' => 'WellCommerce\\Core\\Helper',
            'kernel.class' => 'Symfony\\Component\\HttpKernel\\DependencyInjection\\ContainerAwareHttpKernel',
            'layout_manager.class' => 'WellCommerce\\Core\\LayoutManager',
            'layout_renderer.class' => 'WellCommerce\\Core\\Layout\\LayoutRenderer',
            'image_gallery.class' => 'WellCommerce\\Core\\ImageGallery',
            'translation.class' => 'WellCommerce\\Core\\Translation\\Translation',
            'xajax_manager.class' => 'WellCommerce\\Core\\Helper\\XajaxManager',
            'uploader.class' => 'WellCommerce\\Core\\Uploader',
            'xajax.class' => 'xajax',
            'request_stack.class' => 'Symfony\\Component\\HttpFoundation\\RequestStack',
            'database_manager.class' => 'Illuminate\\Database\\Capsule\\Manager',
            'datagrid_renderer.class' => 'WellCommerce\\Core\\DataGrid\\Renderer',
            'router.class' => 'Symfony\\Component\\Routing\\Router',
            'router.loader.class' => 'Symfony\\Component\\Routing\\Loader\\PhpFileLoader',
            'router.subscriber.class' => 'Symfony\\Component\\HttpKernel\\EventListener\\RouterListener',
            'session.class' => 'Symfony\\Component\\HttpFoundation\\Session\\Session',
            'session.handler.class' => 'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\PdoSessionHandler',
            'session.storage.class' => 'Symfony\\Component\\HttpFoundation\\Session\\Storage\\NativeSessionStorage',
            'template_guesser.class' => 'WellCommerce\\Core\\Template\\TemplateGuesser',
            'template_listener.class' => 'WellCommerce\\Core\\EventListener\\TemplateListener',
            'availability.admin.controller.class' => 'WellCommerce\\Plugin\\Availability\\Controller\\Admin\\AvailabilityController',
            'deliverer.datagrid.class' => 'WellCommerce\\Plugin\\Deliverer\\DataGrid\\DelivererDataGrid',
        );
    }
}
