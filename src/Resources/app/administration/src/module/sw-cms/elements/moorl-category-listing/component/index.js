const { Component, Application, Mixin } = Shopware;
import template from './index.html.twig';
import './index.scss';

Component.register('sw-cms-el-moorl-category-listing', {
    template,

    mixins: [
        Mixin.getByName('cms-element')
    ],

    computed: {
        moorlFoundation() {
            return MoorlFoundation;
        },

        categories() {
            if (!this.element.data || !this.element.data.categories) {
                let categories = [];
                for (let i = 0; i < 9; i++) {
                    categories.push(this.category())
                }
                return categories;
            }
            return this.element.data.categories;
        },

        elementCss() {
            return {
                'grid-template-columns': 'repeat(auto-fill, minmax(' + this.element.config.minWidth.value + ', 1fr))',
                'grid-gap': this.element.config.gridGap.value
            };
        },

        overlayCss() {
            return {
                'align-items': this.element.config.boxVerticalAlign.value,
                'justify-content': this.element.config.boxHorizontalAlign.value,
                'min-height': this.element.config.height.value,
                'height': this.element.config.height.value,
                'background': this.element.config.elementBackground.value
            }
        },

        boxCss() {
            return {
                'margin': this.element.config.boxMargin.value,
                'padding': this.element.config.boxPadding.value,
                'background': this.element.config.boxBackground.value,
                'color': this.element.config.boxColor.value,
                'width': this.element.config.boxWidth.value,
                'height': this.element.config.boxHeight.value,
                'text-align': this.element.config.boxTextAlign.value
            }
        }
    },

    watch: {
        cmsPageState: {
            deep: true,
            handler() {
                this.$forceUpdate();
            }
        }
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('moorl-category-listing');
            this.initElementData('moorl-category-listing');
        },

        category(category) {
            if (!this.element.data || !this.element.data.categories || typeof category == 'undefined') {
                return {
                    name: 'Lorem ipsum dolor',
                    description: `Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                    sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                    sed diam voluptua.`.trim(),
                    media: {
                        url: 'bundles/administration/static/img/cms/preview_glasses_large.jpg',
                        alt: 'Lorem Ipsum dolor'
                    }
                };
            }
            return category;
        },

        categoryCss(category) {
            return {
                'background-image': 'url(' + category.media.url + ')',
                'min-height': this.element.config.height.value
            }
        }
    }
});
