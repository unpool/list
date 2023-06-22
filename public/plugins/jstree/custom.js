import $ from 'jquery';
import {NodeClass} from '/resources/js/admin/classes/Node';
// 6 create an instance when the DOM is ready
// var treeMain = $('#jstree').jstree({
//     "core": {
//         "check_callback": true
//     },
//     "plugins": ["dnd"]
// }).bind("move_node.jstree", function (e, data) {
//     let parent_node = getNodeById(data.parent);
//     console.log(data.node);
//     var confirm = window.confirm('از جابه‌جایی ' + data.node.text + ' به عنوان فرزند ' + parent_node.text + ' اطمینان دارید؟ ');
//
//     if (confirm) {
//         // send Ajax for Replace
//         var node = new NodeClass();
//         node.move(data.node.id, data.parent);
//     }
//     else {
//     }
//     location.replace(window.location.href);
// });
//
// /**
//  * @param {Number} id
//  */
// function getNodeById(id) {
//     return $.jstree.reference(treeMain).get_node(id);
// }
//
// // 7 bind to events triggered on the tree
//
// $('#jstree').on("changed.jstree", function (e, data) {
//     window.jstree_selected_node = data;
//     $('#selected_data').html(data.node.text);
//     $('#edit_node_modal__opener_btn').removeClass('d-none');
//     $('#deselect_btn').removeClass('d-none');
// });
// $('#deselect_btn').on('click', () => {
//     $('#jstree').jstree("deselect_all", true);
//     $('#selected_data').html('هیچ دسته‌ای انتخاب نشده است.');
//     $('#edit_btn').addClass('d-none');
//     $('#deselect_btn').addClass('d-none');
// });

export {};