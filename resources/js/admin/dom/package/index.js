import "jquery";

let PackageDOM = {
    DOM_ELEMENT: {
        addProductToPackageButton: $("#addProductToPackage"),
        productBoxHolder: $("#productBoxHolder")
    },
    init() {
        PackageDOM.bindUIAction();
    },
    bindUIAction() {
        PackageDOM.DOM_ELEMENT.addProductToPackageButton.click(
            PackageDOM.methods.addProductInputHolder
        );
    },
    methods: {
        addProductInputHolder: () => {
            PackageDOM.DOM_ELEMENT.productBoxHolder.append(
                '<div class="form-group m-1"><input type="number" name="products[]" class="form-control"></div>'
            );
        }
    }
};
PackageDOM.init();
export { PackageDOM };
