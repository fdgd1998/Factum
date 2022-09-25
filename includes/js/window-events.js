$(document).ready(function() {
    window.onbeforeunload = function() {
        if (true) {
            return "Data will be lost if you leave the page, are you sure?";
        }
    };
});