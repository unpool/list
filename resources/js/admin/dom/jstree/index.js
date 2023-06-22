import $ from "jquery";
import { NodeClass } from "./../../classes/Node";
import "./../../../../../public/plugins/jstree/jstree.min";
import { MaskLoading } from "../../dom/MaskLoading";
import { AdminRoutes } from "../../../routes/admin";

let DOM_ELEMENTS = {
    jstree_action_alert: $("#jstree_action_alert"),
    mask_loading: $("#mask_loading"),
    selected_node_holder: $("#selected_node_holder"),
    nodeEditButton: $("#editNodeButton"),
    deleteNodeForm: $("#deleteNodeForm")
};

var treeMain = $("#jstree")
    .jstree({
        core: {
            check_callback: true,
            multiple: false
        },
        checkbox: {
            three_state: false,
            cascade: "none"
        },
        plugins: ["checkbox", "dnd", "search", "state", "types", "wholerow"]
    })
    .bind("move_node.jstree", function(e, data) {
        var parent = data.instance.get_node(data.parent);
        var previous = data.instance.get_node(
            parent.children[data.position - 1]
        );
        if (!previous.id) {
            previous = null;
        } else {
            previous = previous.id;
        }
        let parent_id = null;
        if (data.parent !== "#") {
            parent_id = data.parent;
        }

        MaskLoading.show();
        var node = new NodeClass();
        node.move(data.node.id, parent_id, previous, {
            success: msg => {
                DOM_ELEMENTS.jstree_action_alert
                    .empty()
                    .html(
                        '<li class="list-group-item list-group-item-success">' +
                            msg.messages[0] +
                            "</li>"
                    )
                    .removeClass("d-none");
            },
            error() {
                DOM_ELEMENTS.jstree_action_alert
                    .empty()
                    .html(
                        '<li class="list-group-item list-group-item-danger">خطایی رخ داده است.</li>'
                    )
                    .removeClass("d-none");
            },
            complete() {
                MaskLoading.hide();
            }
        });
    })
    .bind("rename_node.jstree", (e, data) => {
        MaskLoading.show();
        var node = new NodeClass();
        if (Number(data.node.id) == data.node.id) {
            node.rename(Number(data.node.id), data.text, {
                success: msg => {
                    DOM_ELEMENTS.jstree_action_alert
                        .empty()
                        .html(
                            '<li class="list-group-item list-group-item-success">' +
                                msg.messages[0] +
                                "</li>"
                        )
                        .removeClass("d-none");
                },
                error() {
                    DOM_ELEMENTS.jstree_action_alert
                        .empty()
                        .html(
                            '<li class="list-group-item list-group-item-danger">خطایی رخ داده است.</li>'
                        )
                        .removeClass("d-none");
                },
                complete() {
                    MaskLoading.hide();
                }
            });
        } else {
            MaskLoading.show();
            node.create(Number(data.node.parent), data.node.text, {
                success: msg => {
                    DOM_ELEMENTS.jstree_action_alert
                        .empty()
                        .html(
                            '<li class="list-group-item list-group-item-success">' +
                                msg.messages[0] +
                                "</li>"
                        )
                        .removeClass("d-none");
                },
                error() {
                    DOM_ELEMENTS.jstree_action_alert
                        .empty()
                        .html(
                            '<li class="list-group-item list-group-item-danger">خطایی رخ داده است.</li>'
                        )
                        .removeClass("d-none");
                },
                complete() {
                    MaskLoading.hide();
                }
            });
            window.location.reload();
        }
    })
    .bind("delete_node.jstree", (e, data) => {
        var node = new NodeClass();
        MaskLoading.show();

        node.delete(Number(data.node.id), {
            success: msg => {
                DOM_ELEMENTS.jstree_action_alert
                    .empty()
                    .html(
                        '<li class="list-group-item list-group-item-success">' +
                            msg.messages[0] +
                            "</li>"
                    )
                    .removeClass("d-none");
            },
            error() {
                DOM_ELEMENTS.jstree_action_alert
                    .empty()
                    .html(
                        '<li class="list-group-item list-group-item-danger">خطایی رخ داده است.</li>'
                    )
                    .removeClass("d-none");
            },
            complete() {
                MaskLoading.hide();
            }
        });
    });

$("#jstree").on("changed.jstree", function(e, data) {
    if (data.action === "deselect_node" || data.action === "deselect_all") {
        DOM_ELEMENTS.nodeEditButton.attr("href", "#");
        DOM_ELEMENTS.deleteNodeForm.attr("action", "#");
    } else {
        let edit_node_route = AdminRoutes.node.edit;
        edit_node_route = edit_node_route.replace(
            ":id",
            getLastSelectedItem(data.selected).id
        );
        DOM_ELEMENTS.nodeEditButton.attr("href", edit_node_route);

        let delete_node_route = AdminRoutes.node.delete;
        delete_node_route = delete_node_route.replace(
            ":id",
            getLastSelectedItem(data.selected).id
        );
        DOM_ELEMENTS.deleteNodeForm.attr("action", delete_node_route);

        let last_selected_node = getLastSelectedItem(data.selected);
        DOM_ELEMENTS.selected_node_holder.empty().html(last_selected_node.text);
    }
});

/**
 * @param {array} inputs
 * @return {Object}
 */
function getLastSelectedItem(inputs) {
    return getNodeById(Number(inputs[inputs.length - 1]));
}

/**
 * @param {Number} id
 * @return {Object}
 */
function getNodeById(id) {
    return $.jstree.reference(treeMain).get_node(id);
}
