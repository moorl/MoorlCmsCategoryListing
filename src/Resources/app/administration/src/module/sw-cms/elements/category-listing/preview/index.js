const {Component} = Shopware;

Component.extend(
    'sw-cms-el-preview-category-listing',
    'sw-cms-el-preview-moorl-foundation-listing',
    {
        data() {
            return {
                label: 'sw-cms.elements.category-listing.name'
            }
        }
    }
);
