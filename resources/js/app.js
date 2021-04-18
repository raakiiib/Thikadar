import Vue from "vue";
import VueMeta from "vue-meta";
import PortalVue from "portal-vue";
import { InertiaApp } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress/src";
import moment from "moment";
import Donut from "vue-css-donut-chart";
import "vue-css-donut-chart/dist/vcdonut.css";

Vue.use(Donut);
Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route } });
Vue.use(InertiaApp);
Vue.use(PortalVue);

Vue.use(VueMeta);

InertiaProgress.init();

let app = document.getElementById("app");

Vue.filter("formatDate", function(value) {
    if (value) {
        return moment(String(value)).format("DD-MM-Y");
    }
});

new Vue({
    metaInfo: {
        titleTemplate: title =>
            title ? `${title} - Elite Construction` : "Elite Construction"
    },
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name =>
                    import(`@/Pages/${name}`).then(module => module.default)
            }
        })
}).$mount(app);
