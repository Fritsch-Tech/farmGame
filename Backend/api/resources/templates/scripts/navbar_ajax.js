var res = "";
var isDone = false;
$(document).ready(function () {
    document.getElementById('home').href = prefix + parseHref(document.getElementById('home'));
    document.getElementById('home1').href = prefix + parseHref(document.getElementById('home1'));
    document.getElementById('devices').href = prefix + parseHref(document.getElementById('devices'));
    document.getElementById('documentation').href = prefix + parseHref(document.getElementById('documentation'));
    if (getCookie("userToken") != "") {
        $.ajax({
            url: prefix + '/api/devices/favorites?token=' + getCookie("userToken") + "&fields=id,name",
            type: 'GET',
            dataType: "json",
            statusCode: {
                200: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var row = '<a class="dropdown-item" href="' + prefix + '/devices?id=' + data[i].id + '">' + data[i].id + ' ' + data[i].name + '</a>';
                        res += row;
                    }
                    $("#deviceArea").html(res);
                },
                204: function (data) {
                    res = '<a class="dropdown-item">No Favourites</a>';
                    $("#deviceArea").html(res);
                },
                404: function (data) {
                    res = '<a class="dropdown-item">Something went Wrong</a>';
                    $("#deviceArea").html(res);
                }
            }
        }).done(function (data) {


        }).fail(function (xmlHttpRequest, textStatus, errorThrown) {
        });
        $("#loginArea").html('' +
            '<li class="nav-item dropdown">\n' +
            '    <a class="notification nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>\n' +
            '    <div id="notify-dropdown" class="dropdown-menu" aria-labelledby="notify-dropdown">\n' +
            '    </div>\n' +
            '</li>' +
            '<li id="dropdown" class="nav-item dropdown">\n' +
            '    <a id="userButton" class="nav-link dropdown" href="' + prefix + '/settings"></a>\n' +
            '    <div id="userMenu" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">\n' +
            '        <a id="logout" class="dropdown-item" href="' + prefix + '/logout">Logout</a>' +
            '    </div>\n' +
            '</li>');

        $.ajax({
            url: prefix + '/api/users/' + getCookie("userToken") + "?search-type=token&fields=name&token=" + getCookie("userToken"),
            type: 'GET',
            dataType: "json",
            statusCode: {}
        }).done(function (data) {
            $("#userButton").html(data.name);
        }).fail(function (xmlHttpRequest, textStatus, errorThrown) {
            alert(textStatus, errorThrown);
        });

        devicesToAccept();

    } else {
        if (!(window.location.pathname == prefix + "/login" || window.location.pathname == prefix + "/")) window.location.href = prefix + "/login";
        $("#loginArea").html('' +
            '<li class="nav-item">' +
            '<a class="nav-link" href="' + prefix + '/login">Login</a> ' +
            '</li>')
        $("#deviceArea").html('<a class="dropdown-item">Please Login</a>')
    }
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function parseHref(myHref) {
    var tempArray = myHref.toString().split("/", 4);
    return "/" + tempArray[3];
}

function AcceptanceReply(id, decision) {
    $.ajax({
        url: prefix + '/api/devicesToAccept/' + id + '?token=' + getCookie("userToken") + '&&accept=' + decision,
        type: 'PATCH',
        dataType: "json",
        statusCode: {}
    }).done(function (data) {
        devicesToAccept();
    })
}

function devicesToAccept() {
    $.ajax({
        url: prefix + '/api/devicesToAccept?token=' + getCookie("userToken"),
        type: 'GET',
        dataType: "json",
        statusCode: {}
    }).done(function (data, textStatus, xhr) {
        var res = "";
        if (xhr.status.toString() == "200") {
            for (var i = 0; i < data.length; i++) {
                res += '    <div class="dropdown-item disabled">\n' +
                    '         <a id="acceptance-item" class="nav-item disabled">' + data[i].data.deviceName + '</a></br>\n' +
                    '         <div class="btn-group btn-wide">\n' +
                    '             <button class="btn btn-success btn-wide" onclick="AcceptanceReply(' + data[i].data.deviceID + ', 1)">Accept</button><button class="btn btn-danger btn-wide" onclick="AcceptanceReply(' + data[i].data.deviceID + ', 0)">Decline</button>\n' +
                    '         </div>\n' +
                    '    </div>';
                if(i < data.length - 1){
                    res += '<hr />';
                }
            }
        } else if (xhr.status.toString() == "204") {
            res = '' +
                '<div class="dropdown-item disabled">' +
                '    <a id="acceptance-item" class="nav-item disabled">No devices to accept</a>' +
                '</div>';
        } else{
            res = '' +
                '<div class="dropdown-item disabled">' +
                '    <a id="acceptance-item" class="nav-item disabled">Something went wrong</a>' +
                '</div>';
        }
        $("#notify-dropdown").html(res);
    })
}

