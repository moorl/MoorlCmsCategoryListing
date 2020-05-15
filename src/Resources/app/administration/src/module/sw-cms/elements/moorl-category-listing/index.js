const Application = Shopware.Application;
import './component';
import './config';
import './preview';

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria();

Application.getContainer('service').cmsService.registerCmsElement({
    name: 'moorl-category-listing',
    label: 'Category listing',
    component: 'sw-cms-el-moorl-category-listing',
    configComponent: 'sw-cms-el-config-moorl-category-listing',
    previewComponent: 'sw-cms-el-preview-moorl-category-listing',
    defaultConfig: {
        backgroundFixed: {
            source: 'static',
            value: false,
        },
        category: {
            source: 'mapped',
            value: 'category.children',
            required: true,
            entity: {
                name: 'category',
                criteria: criteria
            }
        },
        contentLength: {
            source: 'static',
            value: 100
        },
        height: {
            source: 'static',
            value: '300px'
        },
        btnActive: {
            source: 'static',
            value: true,
        },
        btnClass: {
            source: 'static',
            value: 'btn-primary'
        },
        btnText: {
            source: 'static',
            value: 'Shop now'
        },
        elementBackground: {
            source: 'static',
            value: 'none',
        },
        boxVerticalAlign: {
            source: 'static',
            value: 'center'
        },
        boxHorizontalAlign: {
            source: 'static',
            value: 'center'
        },
        boxTextAlign: {
            source: 'static',
            value: 'left'
        },
        boxWidth: {
            source: 'static',
            value: 'auto'
        },
        boxHeight: {
            source: 'static',
            value: 'auto'
        },
        boxMargin: {
            source: 'static',
            value: '20px'
        },
        boxPadding: {
            source: 'static',
            value: '15px'
        },
        boxColor: {
            source: 'static',
            value: '#000000'
        },
        boxBackground: {
            source: 'static',
            value: 'rgba(255,255,255,0.7)'
        },
        gridGap: {
            source: 'static',
            value: '30px'
        },
        minWidth: {
            source: 'static',
            value: '250px'
        },
    },
    defaultData: {}
});
