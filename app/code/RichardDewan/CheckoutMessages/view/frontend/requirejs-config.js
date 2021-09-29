var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/summary/cart-items': {
                'RichardDewan_CheckoutMessages/js/view/summary/cart-items-mixin':true
            }
        }
    },
    map: {
        '*': {
            'Magento_Checkout/template/sidebar': 'RichardDewan_CheckoutMessages/template/sidebar'
        }
    }
}
