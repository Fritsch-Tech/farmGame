$(document).ready(function() {
    $("#loginButton").click(function(e) {
        var uname = $('#inputUsername').val();
        var pw = $('#inputPassword').val();
        if (uname == "" || pw == "") {
            alert("Bitte geben sie werte ein!");
        }
        else {
            $.ajax({
                url: prefix + '/api/userToken',
                type: 'POST',
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify({
                    "email": $('#inputEmail').val(),
                    "password": $('#inputPassword').val()
                }),
                statusCode: {
                    200: function (data) {

                    },
                    401: function (data) {
                        alert("401");
                    },
                    404: function (data) {
                        alert("404");
                    }
                }
            }).done(function (data) {

                document.cookie = "userToken=" + data.data.token;
                window.location.href = prefix + "/"
            }).fail(function (xmlHttpRequest, textStatus, errorThrown) {
                alert(textStatus, errorThrown);
            });
        }
    });
});