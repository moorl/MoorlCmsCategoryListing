<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Core\Content\Category\SalesChannel;

use MoorlFoundation\Core\System\EntityListingExtension;
use MoorlFoundation\Core\System\EntityListingInterface;
use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class CategoryListing extends EntityListingExtension implements EntityListingInterface
{
    public function getEntityName(): string
    {
        return CategoryDefinition::ENTITY_NAME;
    }

    public function getTitle(): string
    {
        return 'category-listing';
    }

    public function getSnippet(): ?string
    {
        return 'moorl-cms-category-listing.categories';
    }

    public function getElementConfig(): array
    {
        if ($this->isSearch() && $this->systemConfigService->get('MoorlCmsCategoryListing.config.searchConfigActive')) {
            return $this->systemConfigService->get('MoorlCmsCategoryListing.config.searchConfig') ?: parent::getElementConfig();
        } elseif ($this->isSuggest() && $this->systemConfigService->get('MoorlCmsCategoryListing.config.suggestConfigActive')) {
            return $this->systemConfigService->get('MoorlCmsCategoryListing.config.suggestConfig') ?: parent::getElementConfig();
        }

        return parent::getElementConfig();
    }

    public function isActive(): bool
    {
        if ($this->isSearch()) {
            return (bool) $this->systemConfigService->get('MoorlCmsCategoryListing.config.searchActive');
        } elseif ($this->isSuggest()) {
            return (bool) $this->systemConfigService->get('MoorlCmsCategoryListing.config.suggestActive');
        }

        return true;
    }

    public function getLimit(): int
    {
        if ($this->isSearch()) {
            return $this->systemConfigService->get('MoorlCmsCategoryListing.config.searchLimit') ?: 12;
        } elseif ($this->isSuggest()) {
            return $this->systemConfigService->get('MoorlCmsCategoryListing.config.suggestLimit') ?: 6;
        }

        return 1;
    }

    public function processCriteria(Criteria $criteria): void
    {
        $criteria->addAssociation('media');
        $criteria->addFilter(new EqualsFilter('active', true));
    }
}
