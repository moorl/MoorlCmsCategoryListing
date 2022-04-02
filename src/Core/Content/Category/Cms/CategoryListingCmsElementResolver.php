<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Core\Content\Category\Cms;

use MoorlFoundation\Core\Content\Cms\FoundationListingCmsElementResolver;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

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
        $criteria->addAssociation('cover');
        $this->enrichCmsElementResolverCriteriaV2(
            $slot,
            $criteria,
            $resolverContext
        );

        $listing = $this->listingRoute
            ->load($navigationId, $request, $context, $criteria)
            ->getResult();

        $data->setListing($listing);
    }
}
