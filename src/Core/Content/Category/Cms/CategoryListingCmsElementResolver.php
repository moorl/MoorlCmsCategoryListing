<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Core\Content\Category\Cms;

use MoorlFoundation\Core\Content\Cms\FoundationListingCmsElementResolver;
use Shopware\Core\Content\Category\CategoryCollection;
use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;

class CategoryListingCmsElementResolver extends FoundationListingCmsElementResolver
{
    public function getType(): string
    {
        return 'category-listing';
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $data = new CategoryListingStruct();
        $slot->setData($data);

        $request = $resolverContext->getRequest();
        $context = $resolverContext->getSalesChannelContext();
        $navigationId = $this->getNavigationId($resolverContext);

        $criteria = new Criteria();
        $this->enrichCmsElementResolverCriteriaV2(
            $slot,
            $criteria,
            $resolverContext
        );

        $listing = $this->listingRoute
            ->load($navigationId, $request, $context, $criteria)
            ->getResult();

        $config = $slot->getFieldConfig();
        $listingSortingConfig = $config->get('listingSorting');

        if (!$listingSortingConfig->getValue()) {
            /** @var CategoryCollection $categories */
            $categories = $listing->getEntities();
            if ($categories->count() > 1) {
                $categories->sortByPosition();

                $listing = new EntitySearchResult(
                    CategoryDefinition::ENTITY_NAME,
                    $listing->getTotal(),
                    $categories,
                    $listing->getAggregations(),
                    $listing->getCriteria(),
                    $context->getContext()
                );
            }
        }

        $data->setListing($listing);
    }
}
