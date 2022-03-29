<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class MoorlCmsCategoryListing extends Plugin
{
    public function install(InstallContext $context): void
    {
        parent::install($context);
    }

    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);

        if ($context->keepUserData()) {
            return;
        }
    }
}
