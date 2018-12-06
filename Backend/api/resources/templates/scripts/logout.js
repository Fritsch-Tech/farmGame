$(document).ready(function() {
    delete_cookie("userToken")
    window.location.href = prefix + "/";
});
function delete_cookie( name ) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}