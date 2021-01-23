define(['core/str'], function(str) {
    var init = function() {
        if(str) {
            helper();
        }
    };

    var helper = function() {
        //alert('Additional function is working');
    };

    return {
        init: init
    };
});