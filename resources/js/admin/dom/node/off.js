import $ from 'jquery';
import {OffCls} from './../../utiles/OffCls'

let OffDom = {
    DOM_ELEMENT: {
        price_holder: $('#price_holder'),
        off_percent_holder: $('#off_percent_holder'),
        off_amount_holder: $('#off_amount_holder'),
    },
    init(){
        OffDom.bindUIAction();
    },
    bindUIAction(){
        OffDom.DOM_ELEMENT.off_percent_holder.change(OffDom.methods.off_percent_holder_change);
        OffDom.DOM_ELEMENT.off_amount_holder.change(OffDom.methods.off_amount_holder_change);
    },
    methods: {
        off_percent_holder_change: () => {
            let price = OffDom.DOM_ELEMENT.price_holder.val() || 0;
            if (price) {
                OffDom.DOM_ELEMENT.off_amount_holder.val(
                    OffCls.convertPercentOffToAmountOff(OffDom.DOM_ELEMENT.price_holder.val(), OffDom.DOM_ELEMENT.off_percent_holder.val())
                )
            }
        },
        off_amount_holder_change: () => {
            let price = OffDom.DOM_ELEMENT.price_holder.val() || 0;
            if (price) {
                OffDom.DOM_ELEMENT.off_percent_holder.val(
                    OffCls.convertAmountOffToPercentOff(OffDom.DOM_ELEMENT.price_holder.val(), OffDom.DOM_ELEMENT.off_amount_holder.val())
                )
            }
        }
    }
};
OffDom.init();
export {OffDom};