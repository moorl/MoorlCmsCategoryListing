<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Content;

use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\FieldConfig;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;

class MoorlCategoryListingTypeDataResolver extends AbstractCmsElementResolver
{
    private const ENTITY_FALLBACK = 'moorl-category-listing-entity-fallback';

    public function getType(): string
    {
        return 'moorl-category-listing';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $config = $slot->getFieldConfig()->get('category');
        $collection = new CriteriaCollection();

        if ($config->isMapped() && $config->getValue() && $resolverContext instanceof EntityResolverContext) {
            if ($criteria = $this->collectByEntity($resolverContext, $config)) {
                $collection->add(self::ENTITY_FALLBACK . '_' . $slot->getUniqueIdentifier(), CategoryDefinition::class, $criteria);
            }
        }

        return $collection->all() ? $collection : null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        //dump($result);exit;

        $data = new MoorlCategoryListingStruct();
        $slot->setData($data);

        $config = $slot->getFieldConfig()->get('category');
        if (!$config) {
            return;
        }

        if ($config->isMapped() && $resolverContext instanceof EntityResolverContext) {
            $children= $this->resolveEntityValue($resolverContext->getEntity(), $config->getValue());

            if (!$children) {
                $this->enrichFromSearch($data, $result, self::ENTITY_FALLBACK . '_' . $slot->getUniqueIdentifier());
            } else {
                $data->setChildren($children);
            }
        }
    }

    private function collectByEntity(EntityResolverContext $resolverContext, FieldConfig $config): ?Criteria
    {
        $entityProducts = $this->resolveEntityValue($resolverContext->getEntity(), $config->getValue());
        if ($entityProducts) {
            return null;
        }

        $criteria = $this->resolveCriteriaForLazyLoadedRelations($resolverContext, $config);
        $criteria->addAssociation('media');
        $criteria->addFilter(new EqualsFilter('active', 1));
        //$criteria->addSorting(new FieldSorting(''))

        return $criteria;
    }

    private function enrichFromSearch(MoorlCategoryListingStruct $data, ElementDataCollection $result, string $searchKey): void
    {
        $searchResult = $result->get($searchKey);
        if (!$searchResult) {
            return;
        }

        /** @var ProductCollection|null $products */
        $children = $searchResult->getEntities();
        if (!$children) {
            return;
        }

        $data->setChildren($children);
    }
}
