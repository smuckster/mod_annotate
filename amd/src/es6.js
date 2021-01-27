define(['core/str'], function(str) {

    if(str) {
        const test = () => {
            alert('ES6 stuff is working');
        };

        return {test: test};
    }
});