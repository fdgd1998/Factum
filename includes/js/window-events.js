$(document).ready(function() {
    window.onbeforeunload = function() {
        if (reload) {
            return "Data will be lost if you leave the page, are you sure?";
        }
    };
});