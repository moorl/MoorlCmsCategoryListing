<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Core\Content\Category\Cms;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Struct;

class CategoryListingStruct extends Struct
{
    /**
     * @var EntitySearchResult|null
     */
    protected $listing;

    public function getListing(): ?EntitySearchResult
    {
        return $this->listing;
    }

    public function setListing(EntitySearchResult $listing): void
    {
        $this->listing = $listing;
    }

    public function getApiAlias(): string
    {
        return 'cms_category_listing';
    }
}
