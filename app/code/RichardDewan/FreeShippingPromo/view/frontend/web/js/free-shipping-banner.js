/**
 * Most UI Component implementations use "uiComponent" for the base class.
 * This is technically the same as referencing the "uiCollection" class.
 * The class is then commonly aliased in Magento code as "Component".
 *
 */
define(
    [
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'underscore',
        'knockout'
    ], function (Component,customerData,_,ko) {
        'use strict';

        // This code executes before the component has been initialized.
        console.log('Free Shipping Banner UI Component has been loaded');

        // You'd normally always return Component.extend(), then pass the
        // configuration as JSON into this parent class.
        return Component.extend({
            defaults: {
                /*message: 'Free Shipping Banner UI Component',*/
                //message: '${$.messageDefault}', //polly fill '${data}'
                freeShippingThreshold: 100,
                subtotal: 0.0,
                template: 'RichardDewan_FreeShippingPromo/free-shipping-banner',
                //tracks is a systhetic suger provided by knockout plugin es5 magento auto include
                tracks: {
                    subtotal: true,
                    //message: true
                }
            },
            initialize: function () {
                this._super();
                var self = this;

                var cart = customerData.get('cart');
                //wait for the deferred promise data
                customerData.getInitCustomerData().done(function () {
                    if (!_.isEmpty(cart()) && !_.isUndefined(cart().subtotalAmount)){
                        self.subtotal = parseFloat(cart().subtotalAmount);
                    }
                });

                cart.subscribe(function (cart) {
                    if (!_.isEmpty(cart) && !_.isUndefined(cart.subtotalAmount)){
                        self.subtotal = parseFloat(cart.subtotalAmount);
                    }
                })

                //self.message is a computed funtion
                self.message = ko.computed(function () {
                    //subtotal = 0 return messageDefault
                    if (_.isUndefined(self.subtotal) || self.subtotal === 0) {
                        return self.messageDefault;
                    }
                    //subtotal  > 0 or or subtotal < 100 return messageItemsInCart
                    if (self.subtotal > 0 && self.subtotal < self.freeShippingThreshold) {
                        var subtotalRemaining = self.freeShippingThreshold - self.subtotal;
                        var formattedSubtotalRemaining = self.formatCurrency(subtotalRemaining);
                        return  self.messageItemsInCart.replace('$xx.xx',formattedSubtotalRemaining);
                    }
                    //subtotal >= 100 return messageFreeShipping
                    if (self.subtotal >= self.freeShippingThreshold) {
                        return  self.messageFreeShipping;
                    }
                })

                /*var self = this
                window.setTimeout(function () {
                    self.subtotal = 40.20;
                },2000);
                console.log(this.message);*/
            },
            formatCurrency: function (value) {
                return '$' + value.toFixed(2);
            }
        });
    })
