const {Component} = Shopware;
const {Criteria} = Shopware.Data;

Component.extend('sw-cms-el-config-category-listing', 'sw-cms-el-config-moorl-foundation-listing', {
    data() {
        return {
            entity: 'category',
            elementName: 'category-listing',
            criteria: (new Criteria(1, 12)).addAssociation('media'),
            configWhitelist: {
                listingSource: ['static', 'select']
            }
        }
    }
});
