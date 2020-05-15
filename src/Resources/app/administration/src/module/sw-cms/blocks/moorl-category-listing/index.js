import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'moorl-category-listing',
    label: 'moorl-cms.blocks.general.categoryListing.label',
    category: 'commerce',
    component: 'sw-cms-block-moorl-category-listing',
    previewComponent: 'sw-cms-preview-moorl-category-listing',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        one: {
            type: 'moorl-category-listing'
        }
    }
});
