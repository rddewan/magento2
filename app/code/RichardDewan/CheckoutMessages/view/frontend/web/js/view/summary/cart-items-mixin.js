define([],function (){
    'use strict';

    return function (Component) {
        return Component.extend({
            defaults: {
                template: 'RichardDewan_CheckoutMessages/summary/cart-items'
            },
            isItemsBlockExpanded: function () {
                //this._super();
                return true;
            },
            newMethod: function (){
                console.log('mixin cart log')
            }

        })

    }
})
