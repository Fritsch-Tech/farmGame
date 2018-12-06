$(document).ready(function() {
        $.ajax({
            url: prefix + '/api/devices?token=' + getCookie("userToken") + '&fields=id,name,accessLevel,favorised',
            type: 'GET',
            dataType: "json",
            statusCode: {
            }
        }).done(function (data) {
            var res = "";
            for(var i = 0;i < data.length;i++){
                res += '' +
                    '<li class="nav-link">' +
                    '    <a class="nav-link text-danger devicelist-item" href="' + prefix + '/devices?id=' + data[i].id + '">' + data[i].id + ' ' + data[i].name + '</a>' +
                    '</li>';

                if(i < data.length - 1){
                    res += '<li class="devicelistSeperator"><hr /></li>';
                }
            }
            $("#device-list-area").html(res);
        }).fail(function (xmlHttpRequest, textStatus, errorThrown) {
            alert(textStatus, errorThrown);
        });


    if(getUrlParameter("id") > 0){
        $.ajax({
            url: prefix + '/api/.....',
            type : 'GET',
            dataType: "json",
            statusCode: {}
        }).done(function (data) {

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);
        }).fail(function (xmlHttpRequest, textStatus, errorThrown) {
            alert(textStatus, errorThrown);
        })
    }else
    {
        $("#sensorArea").html("<h3>Please select a device</h3>")
    }
});
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
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


var temp = "<div class=\"list-group list-group-flush\">\n" +
    "                        <div id=\"sensor1\" class=\"list-group-item\">Sensor 1\n" +
    "                            <div id=\"chart_div\"></div>\n" +
    "                        </div>\n" +
    "                        <div class=\"list-group-item\">Dapibus ac facilisis in</div>\n" +
    "                        <div class=\"list-group-item\">Morbi leo risus</div>\n" +
    "                        <div class=\"list-group-item\">Porta ac consectetur ac</div>\n" +
    "                        <div class=\"list-group-item\">Vestibulum at eros</div>\n" +
    "                </div>";