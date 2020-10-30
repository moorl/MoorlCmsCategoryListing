<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing;

use MoorlCmsCategoryListing\MoorlPlugin as Plugin;
use MoorlFoundation\Core\PluginFoundation;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MoorlCmsCategoryListing extends Plugin
{
    private const CMS_PAGE = 'moorl_cms_category_listing';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/Content/DependencyInjection'));
        $loader->load('media.xml');
    }

    public function install(InstallContext $context): void
    {
        parent::install($context);

        /* @var $foundation PluginFoundation */
        $foundation = $this->container->get(PluginFoundation::class);
        $foundation->setContext($context->getContext());

        $data = [
            [
                'technical_name' => self::CMS_PAGE,
                'type' => 'page',
                'entity' => 'category',
                'locked' => 1,
                'locale' => [
                    'en-GB' => [
                        'name' => 'moori - category listing'
                    ],
                    'de-DE' => [
                        'name' => 'moori - Kategorie Listing'
                    ],
                ]
            ]
        ];

        $foundation->addCmsPages($data);
    }

    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);

        if ($context->keepUserData()) {
            return;
        }

        /* @var $foundation PluginFoundation */
        $foundation = $this->container->get(PluginFoundation::class);
        $foundation->setContext($context->getContext());

        $foundation->removeCmsPages([self::CMS_PAGE]);
        $foundation->removeCmsBlocks(['moorl-category-listing']);
    }
}
