/*
map only works with local AMD module
path works with exteranl file
 */
var config = {
    //map only works with local AMD module
    "map": {
        //*: all required js module can use thi alias
        "*": {
            "fadeInElement": "RichardDewan_JsFun/js/fade-in-element",
            "Magento_Review/js/submit-review":"RichardDewan_JsFun/js/submit-review"
        }
    },
    //path used for external JS file
    "paths": {
        //"vue": "RichardDewan_JsFun/js/vue.min"
        //"vue": "https://cdn.jsdelivr.net/npm/vue@2/dist/vue"
        //fallback
        "vue": [
            "https://cdn.jsdelivr.net/npm/vue@2/dist/vue",
            "RichardDewan_JsFun/js/vue.min"
        ]
    },
    //ship: relationships between 3rd party plugin and dependencies can be used with no AMD module - mainly traditional JS
    "shim" : {
        "RichardDewan_JsFun/js/jquery-log": ["jquery"]
    },
    //include in every page
    "deps": ['RichardDewan_JsFun/js/every-page'],
    //magento config
    "config": {
        "mixins": {
            //mixin file core file
            "Magento_Ui/js/view/messages": {
                //our local mixin module
                "RichardDewan_JsFun/js/messages-mixin": true
            }
        }
    }
}
//console.log('magento log')
