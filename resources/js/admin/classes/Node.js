import $ from "jquery";
import { AdminRoutes } from "./../../routes/admin";

export var NodeClass = function() {};

NodeClass.prototype = {
    /**
     * @param {number} node_id
     * @param {number} new_parent_id
     * @param {number|NAN} previos_node_id
     * @param {Object.<Function>} ajax_callback
     */
    move(node_id, new_parent_id, previos_node_id, ajax_callback = {}) {
        $.ajax({
            url: AdminRoutes.node.move,
            method: "POST",
            data: {
                node_id,
                new_parent_id,
                previos_node_id
            },
            success: ajax_callback.success || {},
            error: ajax_callback.error || {},
            complete: ajax_callback.complete || {}
        });
    },
    /**
     * @param {number} node_id
     * @param {string} new_name
     * @param {Object.<Function>} ajax_callback
     */
    rename(node_id, new_name, ajax_callback = {}) {
        $.ajax({
            url: AdminRoutes.node.rename,
            method: "POST",
            data: { node_id, new_name },
            success: ajax_callback.success || {},
            error: ajax_callback.error || {},
            complete: ajax_callback.complete || {}
        });
    },
    /**
     * @param {number} parent_id
     * @param {string} name
     * @param {Object.<Function>} ajax_callback
     */
    create(parent_id, name, ajax_callback = {}) {
        $.ajax({
            url: AdminRoutes.node.store,
            method: "POST",
            data: { parent_id, name },
            success: ajax_callback.success || {},
            error: ajax_callback.error || {},
            complete: ajax_callback.complete || {}
        });
    },
    /**
     * @param {number} node_id
     * @param {Object.Function} ajax_callback
     */
    delete(node_id, ajax_callback = {}) {
        /**
         * @type {string}
         */
        let url = AdminRoutes.node.delete;
        url = url.replace(":id", node_id);
        $.ajax({
            url: url,
            method: "POST",
            success: ajax_callback.success || {},
            error: ajax_callback.error || {},
            complete: ajax_callback.complete || {}
        });
    }
};
