import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    plugin: 'MoorlCmsCategoryListing',
    icon: 'default-view-grid',
    name: 'category-listing',
    label: 'sw-cms.elements.category-listing.name',
    component: 'sw-cms-el-category-listing',
    previewComponent: 'sw-cms-el-preview-category-listing',
    configComponent: 'sw-cms-el-config-category-listing',
    defaultConfig: {}
});
