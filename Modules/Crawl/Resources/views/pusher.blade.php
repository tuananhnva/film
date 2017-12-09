<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Page Description">
        <meta name="author" content="HUNG">
        <title>Page Title</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul id="messages" class="list-group">
                    </ul>
                </div>
            </div>
        </div>
        <script>
            (function () {
                Pusher.logToConsole = true;
                var pusher = new Pusher('ac7f4956a3ea7fa3fffd', {
                    encrypted: true
                });

                var channel = pusher.subscribe('crawl');
                channel.bind('App\\Events\\SomeEvent', addMessage);
                function addMessage(data)
                {
                    var listItem = $("<li class='list-group-item'></li>");
                    var html = '<h1><a target="_blank" href="' +
                            data.article.new_link_from_domain + '">' +
                            data.article.new_title +  '</a></h1><h3>' +
                            data.article.nec_description + '</h3>' +
                            data.article.nec_content;
                    listItem.html(html);
                    $('#messages').prepend(listItem);
                }
            })();
        </script>
    </body>
</html>