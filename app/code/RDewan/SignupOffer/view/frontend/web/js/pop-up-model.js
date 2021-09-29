// noinspection JSUnresolvedVariable

define(['jquery', 'Magento_Ui/js/modal/modal', 'sweetalert'], function ($, modal, swal) {
    'use strict'

    /*
    Set options for modal widget
     */
    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: "Signup",
        buttons: [{
            text: $.mage.__('Subscribe'),
            click: function (data) {
                let form_data = $("#form-subscribe").serialize();

                if ($('#first_name').val() === '') {
                    swal.fire({
                        title: 'Error!',
                        text: 'Name cannot be empty',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else if ($('#last_name').val() === '') {
                    swal.fire({
                        title: 'Error!',
                        text: 'Last Name cannot be empty',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else if ($('#email').val() === '') {
                    swal.fire({
                        title: 'Error!',
                        text: 'Email cannot be empty',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else if ($('#dob').val() === '') {
                    swal.fire({
                        title: 'Error!',
                        text: 'Birthday cannot be empty',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else if ($('input[name=gender]:checked').val() === '' || $('input[name=gender]:checked').val() === undefined) {
                    swal.fire({
                        title: 'Error!',
                        text: 'Gender cannot be empty',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else {
                    jQuery('body').loader('show');
                    $.ajax({
                        url: '/signup-offer/Home/Subscribe',
                        type: 'POST',
                        dataType: 'json',
                        data: form_data,
                        success: function (data) {
                            $('#popup-modal').modal('closeModal');

                           /** subscription was successful now create a coupon code */
                            if (data.success) {
                                createCoupon(data.subscriber_hash)
                            }
                            /** message was missing from response */
                            else if (data.message === undefined) {
                                jQuery('body').loader('hide');
                                swal.fire({
                                    title: 'Info',
                                    text: data[0],
                                    icon: 'info',
                                    confirmButtonText: 'Close'
                                })
                            }
                            /** something else happened */
                            else {
                                jQuery('body').loader('hide');
                                swal.fire({
                                    title: 'Sorry!',
                                    text: data.message,
                                    icon: 'info',
                                    confirmButtonText: 'Close'
                                })
                            }
                        },
                        error: function (error) {
                            console.log(error);
                            jQuery('body').loader('hide');

                            /** response json success value was false */
                            if (!error.responseJSON.success) {
                                swal.fire({
                                    title: 'Subscription Error!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                    confirmButtonText: 'Close'
                                })
                            }
                            /** something else happened */
                            else {
                                swal.fire({
                                    title: 'Error!',
                                    text: 'Sorry there was some error',
                                    icon: 'error',
                                    confirmButtonText: 'Close'
                                })

                            }

                        }
                    });
                }
            }
        }]
    };

    /*Initialize modal widget*/
    modal(options, $('#popup-modal'));
    $(".modal-popup._inner-scroll .modal-inner-wrap").attr('style', 'max-height: 90% !important');

    /*Creating an event when clicking the button will display a popup:*/
    $('#voucher-btn').on('click', function () {
        $('#popup-modal').modal('openModal');
    })

    /**
     * call to controller and create coupon code
     * @param subscriber_hash
     */
    function createCoupon(subscriber_hash) {
        $.ajax({
            url: '/signup-offer/Coupon/Coupon',
            type: 'POST',
            dataType: 'json',
            data: {'subscriber_hash':subscriber_hash},
            success: function (data) {
                jQuery('body').loader('hide');
                if (data.success) {
                    swal.fire({
                        title: data.coupon,
                        text: 'Above is your welcome voucher \n' + data.message,
                        icon: 'success',
                        confirmButtonText: 'Close',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    })
                }
                else {
                    swal.fire({
                        title: 'Error!',
                        text: 'Sorry there was some error',
                        icon: 'error',
                        confirmButtonText: 'Close',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    })

                }
            },
            error: function (error) {
                jQuery('body').loader('hide');
                swal.fire({
                    title: 'Error!',
                    text: error.message,
                    icon: 'error',
                    confirmButtonText: 'Close',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                })
            }
        })
    }

    /*$(function () {
        console.log('popup module loaded')
    })*/

    /*return function (className,duration) {
        $(className).hide().fadeIn(duration || 2000)
    }*/
})
