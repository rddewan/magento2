define(['jquery'],function ($) {
    'use strict'

    return function (className, duration) {
        $(className).hide().fadeIn(duration || 2000)
    }
    /*$(function (){
        $('.block-promo').hide().fadeIn(2000)
    })*/
})
