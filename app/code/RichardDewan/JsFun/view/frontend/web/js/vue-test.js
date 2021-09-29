/*
AMD module for inline script
 */

define(['vue','jquery','RichardDewan_JsFun/js/jquery-log'],function (Vue,$) {
    'use strict'

    $.log('Testing output to the console')

    return function (config, element) {
        return new Vue ({
            el: '#' + element.id,
            data: {
                //message: 'This is a vue AMD module'
                message: config.message
            }
        })
    }

    /*new Vue({
        el: '#vue-test',
        data: {
            message: 'Vue test message'
        }
    })*/
})
