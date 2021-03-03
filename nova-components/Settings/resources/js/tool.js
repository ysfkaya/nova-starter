import { Tab, Tabs } from "vue-tabs-component";

Nova.booting((Vue, router) => {
    Vue.component("tabs", Tabs);

    Vue.component("tab", Tab);

    Vue.component("form-setting-file-field", require("./field/SettingImage"));

    router.addRoutes([
        {
            name: "settings",
            path: "/settings",
            component: require("./components/Tool")
        }
    ]);
});
