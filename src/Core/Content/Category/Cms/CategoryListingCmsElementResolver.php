<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Core\Content\Category\Cms;

use MoorlFoundation\Core\Service\SortingService;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\SalesChannel\Listing\AbstractProductListingRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

class CategoryListingCmsElementResolver extends AbstractCmsElementResolver
{
    private AbstractProductListingRoute $listingRoute;
    private SortingService $sortingService;

    public function __construct(
        AbstractProductListingRoute $listingRoute,
        SortingService $sortingService
    )
    {
        $this->listingRoute = $listingRoute;
        $this->sortingService = $sortingService;
    }

    public function getType(): string
    {
        return 'category-listing';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        return null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $data = new CategoryListingStruct();
        $slot->setData($data);

        $request = $resolverContext->getRequest();
        $context = $resolverContext->getSalesChannelContext();
        $navigationId = $this->getNavigationId($request, $context);

        $criteria = new Criteria();
        $criteria->addAssociation('cover');
        $this->sortingService->enrichCmsElementResolverCriteriaV2(
            $slot,
            $criteria,
            $resolverContext
        );

        $listing = $this->listingRoute
            ->load($navigationId, $request, $context, $criteria)
            ->getResult();

        $data->setListing($listing);
    }

    private function getNavigationId(Request $request, SalesChannelContext $salesChannelContext): string
    {
        if ($navigationId = $request->get('navigationId')) {
            return $navigationId;
        }

        $params = $request->attributes->get('_route_params');

        if ($params && isset($params['navigationId'])) {
            return $params['navigationId'];
        }

        return $salesChannelContext->getSalesChannel()->getNavigationCategoryId();
    }
}
