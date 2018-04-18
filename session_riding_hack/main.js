function send() {
    var message = $('#text_message').val();
    console.log(message);
    
    var request = $.ajax({
        url: 'http://dev.localhost/m183/session_riding/index.php?',
        type: 'POST',
        data: {
            op: "newpost",
            content: message
        }
    });

    request.done(function () {
        console.log('dude got rekt');
        $('#text_message').val();
    });
}

  


