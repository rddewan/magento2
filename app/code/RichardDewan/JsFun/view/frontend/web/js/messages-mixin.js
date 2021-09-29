/*
magento mixin
mixin : just touch the function we wish to modify instead of copying all the file
 */
define([],function () {
    'use strict'

    return function (originalMessage) {
        /*originalMessage.defaults.hideTimeout = 1000;
        return originalMessage;*/
        return originalMessage.extend({
            defaults: {
                hideTimeout: 1000,
                hideSpeed: 100
            }
        })
    }

})
