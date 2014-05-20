/**
 * Created by Benjamin on 5/6/14.
 */

function getParameterByName(name)
{
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

var state = new Object();

{
    "jqm":
    {
        "page":
        {
            "header":
            {

            }
        },

    },
}


function updtateList(data)
{
    for ( var i = 0; i < data.length; i++)
    {
        var fName = data[i].fName;
        var uid = data[i].uid;
        //alert(id);
        var lstItem = '<li><a href="?uid=' + uid + '#' + intent + '" >' + fName + '</a></li>';
        // add list item here
        $('#userlist').append(lstItem);
    }
    $('#userlist').listview('refresh');
    $('#users').trigger('updatelayout');

}

function getUsers()
{
    var url = 'user.php';
    $.getJSON(url,
        function(data)
        {
            for ( var i = 0; i < data.length; i++)
            {
                var fName = data[i].fName;
                var uid = data[i].uid;
                //alert(id);
                var lstItem = '<li><a href="?uid=' + uid + '#' + intent + '" >' + fName + '</a></li>';
                // add list item here
                $('#userlist').append(lstItem);
            }
            $('#userlist').listview('refresh');
            $('#users').trigger('updatelayout');
        }
    );


}

function userList(intent)
{
    var url = 'user.php';
    $.getJSON(url,
        function(data)
        {
            for ( var i = 0; i < data.length; i++)
            {
                var fName = data[i].fName;
                var uid = data[i].uid;
                //alert(id);
                var lstItem = '<li><a href="?uid=' + uid + '#' + intent + '" >' + fName + '</a></li>';
                // add list item here
                $('#userlist').append(lstItem);
            }
            $('#userlist').listview('refresh');
            $('#users').trigger('updatelayout');
        }
    );

}

function setEventHandlers()
{
    $('#users').on('pagebeforeshow', function(){userList("");});

}