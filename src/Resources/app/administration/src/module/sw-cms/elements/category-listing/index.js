import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    plugin: 'MoorlCmsCategoryListing',
    icon: 'regular-grid',
    name: 'category-listing',
    label: 'sw-cms.elements.category-listing.name',
    component: 'sw-cms-el-category-listing',
    previewComponent: 'sw-cms-el-preview-category-listing',
    configComponent: 'sw-cms-el-config-category-listing',
    defaultConfig: {
        foreignKey: {
            source: 'static',
            value: 'category.parentId'
        },
        listingLayout: {
            source: 'static',
            value: 'slider'
        },
        listingHeaderTitle: {
            source: 'static',
            value: 'Unterkategorien von {{ category.name }}'
        },
    }
});
