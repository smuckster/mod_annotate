define(['core/str'], function(str) {

    if(str) {
        let test = () => {
            alert('ES6 stuff is working');
        };

        return {test: test};
    }
});