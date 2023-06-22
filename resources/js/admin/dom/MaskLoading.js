import $ from 'jquery';

let MaskLoading = (() => {
    let DOM_element = {
        mask_loader: $('#mask_loading')
    };
    let show = () => {
        DOM_element.mask_loader.removeClass('d-none');
    };

    let hide = () => {
        DOM_element.mask_loader.addClass('d-none');
    };

    return {
        show,
        hide
    }
})();

export {MaskLoading};