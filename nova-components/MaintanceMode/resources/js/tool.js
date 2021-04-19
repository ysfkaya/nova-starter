Nova.booting((Vue, router) => {
    Vue.component(
        "maintenance-alert",
        require("./components/MaintenanceAlert")
    );

    router.addRoutes([
        {
            name: "nova-maintenance-mode",
            path: "/nova-maintenance-mode",
            component: require("./components/Tool")
        }
    ]);
});
