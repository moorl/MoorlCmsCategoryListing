const {Component} = Shopware;
const {Criteria} = Shopware.Data;

Component.extend('sw-cms-el-category-listing', 'sw-cms-el-moorl-foundation-listing', {
    data() {
        return {
            entity: 'category',
            elementName: 'category-listing',
            criteria: (new Criteria(1, 12)).addAssociation('media')
        }
    },

    methods: {
        itemTitle(item) {
            return item.name;
        },

        itemMedia(item) {
            return item.media;
        }
    }
});
