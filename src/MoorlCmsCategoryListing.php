<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing;

use Shopware\Core\Framework\Plugin;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MoorlCmsCategoryListing extends Plugin
{
    private const CMS_PAGE_ID = '7f3d55081d4f494b8a96dccfe34683ae';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/Content/DependencyInjection'));
        $loader->load('media.xml');
    }
}
