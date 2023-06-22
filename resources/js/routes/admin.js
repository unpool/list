export let AdminRoutes = {
    node: {
        edit: getBaseRoute() + "/admin/node/:id/edit",
        move: getBaseRoute() + "/admin/node/move",
        // rename: getBaseRoute() + "/admin/node/rename",
        store: getBaseRoute() + "/admin/node/store",
        delete: getBaseRoute() + "/admin/node/:id/delete"
        // options: getBaseRoute() + "/admin/node/:node/options"
    },
    slider: {
        create: getBaseRoute() + "/admin/slider/create/:node_id"
    }
};

function getBaseRoute() {
    return window.location.origin;
}
