<?php declare(strict_types=1);

namespace MoorlCmsCategoryListing\Content;

use Shopware\Core\Content\Category\CategoryCollection;
use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Framework\Struct\Struct;

class MoorlCategoryListingStruct extends Struct
{
    protected $children;

    public function getChildren(): ?CategoryCollection
    {
        return $this->children;
    }

    public function setChildren(CategoryCollection $children): void
    {
        $this->children = $children;
    }
}
