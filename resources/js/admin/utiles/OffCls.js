let OffCls = (function () {
    /**
     * @param {number} price
     * @param {number} off_amount
     * @returns {number}
     */
    function convertAmountOffToPercentOff(price, off_amount) {
        /**
         * @type {number}
         */
        let price_with_off = price - off_amount;
        return (price - price_with_off) / 100;
    };

    /**
     * @param price
     * @param off_percent
     * @returns {number}
     */
    function convertPercentOffToAmountOff(price, off_percent) {
        return (price * off_percent) / 100;
    };

    return {
        convertAmountOffToPercentOff,
        convertPercentOffToAmountOff
    }
})();

export {OffCls};