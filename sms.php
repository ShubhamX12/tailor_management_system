<?php
require_once('function.php');
dbconnect();
session_start();

if (!is_user()) {
	redirect('index.php');
}

?>

		

<?php
 $user = $_SESSION['username'];
$usid = $pdo->query("SELECT id FROM users WHERE username='".$user."'");
$usid = $usid->fetch(PDO::FETCH_ASSOC);
 $uid = $usid['id'];
 include ('header.php');
 ?>



 
        <div id="page-wrapper" style="box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);
-webkit-box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);
-moz-box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);padding:10px">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Send SMS</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<style>
        iframe {
          width: 100%;
          border: 0;
          min-height: 80%;
          height: 600px;
          display: flex;
        }
		.container{
			width: 900px;
		}
	    .body{
		color: blue;
		}
      </style>
    </head>
    <body>
      <div class="container"> 
   
        <a href="#compose-modal" data-toggle="modal" id="compose-button" class="btn btn-primary pull-right hidden">Compose</a>
   
        <button id="authorize-button" class="btn btn-primary hidden">Authorize</button>
   
        <table class="table table-striped table-inbox hidden">
          <thead>
            <tr>
              <th>From</th>
              <th>Subject</th>
              <th>Date/Time</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
   
      <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title">Compose</h4>
            </div>
            <form onsubmit="return sendEmail();">
              <div class="modal-body">
                <div class="form-group">
                  <input type="email" class="form-control" id="compose-to" placeholder="To" required />
                </div>
   
                <div class="form-group">
                  <input type="text" class="form-control" id="compose-subject" placeholder="Subject" required />
                </div>
   
                <div class="form-group">
                  <textarea class="form-control" id="compose-message" placeholder="Message" rows="10" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="send-button" class="btn btn-primary">Send</button>
              </div>
            </form>
          </div>
        </div>
      </div>
   
      <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title">Reply</h4>
            </div>
            <form onsubmit="return sendReply();">
              <input type="hidden" id="reply-message-id" />
   
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" class="form-control" id="reply-to" disabled />
                </div>
   
                <div class="form-group">
                  <input type="text" class="form-control disabled" id="reply-subject" disabled />
                </div>
   
                <div class="form-group">
                  <textarea class="form-control" id="reply-message" placeholder="Message" rows="10" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="reply-button" class="btn btn-primary">Send</button>
              </div>
            </form>
          </div>
        </div>
      </div>
   
      <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   
      <script type="text/javascript">
        var clientId = '437989060965-8qjdbp40v029lpebohej05l08cbh63as.apps.googleusercontent.com'
        var apiKey = 'AIzaSyCLTwzYirjS6kZQT36Nu3Q0_u3UenHjroE';
        var scopes =
          'https://www.googleapis.com/auth/gmail.readonly '+
          'https://www.googleapis.com/auth/gmail.send';
   
        function handleClientLoad() {
          gapi.client.setApiKey(apiKey);
          window.setTimeout(checkAuth, 1);
        }
   
        function checkAuth() {
          gapi.auth.authorize({
            client_id: clientId,
            scope: scopes,
            immediate: true
          }, handleAuthResult);
        }
   
        function handleAuthClick() {
          gapi.auth.authorize({
            client_id: clientId,
            scope: scopes,
            immediate: false
          }, handleAuthResult);
          return false;
        }
   
        function handleAuthResult(authResult) {
          if(authResult && !authResult.error) {
            loadGmailApi();
            $('#authorize-button').remove();
            $('.table-inbox').removeClass("hidden");
            $('#compose-button').removeClass("hidden");
          } else {
            $('#authorize-button').removeClass("hidden");
            $('#authorize-button').on('click', function(){
              handleAuthClick();
            });
          }
        }
   
        function loadGmailApi() {
          gapi.client.load('gmail', 'v1', displayInbox);
        }
   
        function displayInbox() {
          var request = gapi.client.gmail.users.messages.list({
            'userId': 'me',
            'labelIds': 'INBOX',
            'maxResults': 10
          });
          request.execute(function(response) {
            $.each(response.messages, function() {
              var messageRequest = gapi.client.gmail.users.messages.get({
                'userId': 'me',
                'id': this.id
              });
              messageRequest.execute(appendMessageRow);
            });
          });
        }
   
        function appendMessageRow(message) {
          $('.table-inbox tbody').append(
            '<tr>\
              <td>'+getHeader(message.payload.headers, 'From')+'</td>\
              <td>\
                <a href="#message-modal-' + message.id +
                  '" data-toggle="modal" id="message-link-' + message.id+'">' +
                  getHeader(message.payload.headers, 'Subject') +
                '</a>\
              </td>\
              <td>'+getHeader(message.payload.headers, 'Date')+'</td>\
            </tr>'
          );
          var reply_to = (getHeader(message.payload.headers, 'Reply-to') !== '' ?
            getHeader(message.payload.headers, 'Reply-to') :
            getHeader(message.payload.headers, 'From')).replace(/\"/g, '"');
   
          var reply_subject = 'Re: '+getHeader(message.payload.headers, 'Subject').replace(/\"/g, '"');
          $('body').append(
            '<div class="modal fade" id="message-modal-' + message.id +
                '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
              <div class="modal-dialog modal-lg">\
                <div class="modal-content">\
                  <div class="modal-header">\
                    <button type="button"\
                            class="close"\
                            data-dismiss="modal"\
                            aria-label="Close">\
                      <span aria-hidden="true">×</span></button>\
                    <h4 class="modal-title" id="myModalLabel">' +
                      getHeader(message.payload.headers, 'Subject') +
                    '</h4>\
                  </div>\
                  <div class="modal-body">\
                    <iframe id="message-iframe-'+message.id+'" srcdoc="<p>Loading...</p>">\
                    </iframe>\
                  </div>\
                  <div class="modal-footer">\
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
                    <button type="button" class="btn btn-primary reply-button" data-dismiss="modal" data-toggle="modal" data-target="#reply-modal"\
                    onclick="fillInReply(\
                      \''+reply_to+'\', \
                      \''+reply_subject+'\', \
                      \''+getHeader(message.payload.headers, 'Message-ID')+'\'\
                      );"\
                    >Reply</button>\
                  </div>\
                </div>\
              </div>\
            </div>'
          );
          $('#message-link-'+message.id).on('click', function(){
            var ifrm = $('#message-iframe-'+message.id)[0].contentWindow.document;
            $('body', ifrm).html(getBody(message.payload));
          });
        }
   
        function sendEmail()
        {
          $('#send-button').addClass('disabled');
   
          sendMessage(
            {
              'To': $('#compose-to').val(),
              'Subject': $('#compose-subject').val()
            },
            $('#compose-message').val(),
            composeTidy
          );
   
          return false;
        }
   
        function composeTidy()
        {
          $('#compose-modal').modal('hide');
   
          $('#compose-to').val('');
          $('#compose-subject').val('');
          $('#compose-message').val('');
   
          $('#send-button').removeClass('disabled');
        }
   
        function sendReply()
        {
          $('#reply-button').addClass('disabled');
   
          sendMessage(
            {
              'To': $('#reply-to').val(),
              'Subject': $('#reply-subject').val(),
              'In-Reply-To': $('#reply-message-id').val()
            },
            $('#reply-message').val(),
            replyTidy
          );
   
          return false;
        }
   
        function replyTidy()
        {
          $('#reply-modal').modal('hide');
   
          $('#reply-message').val('');
   
          $('#reply-button').removeClass('disabled');
        }
   
        function fillInReply(to, subject, message_id)
        {
          $('#reply-to').val(to);
          $('#reply-subject').val(subject);
          $('#reply-message-id').val(message_id);
        }
   
        function sendMessage(headers_obj, message, callback)
        {
          var email = '';
   
          for(var header in headers_obj)
            email += header += ": "+headers_obj[header]+"\r\n";
   
          email += "\r\n" + message;
   
          var sendRequest = gapi.client.gmail.users.messages.send({
            'userId': 'me',
            'resource': {
              'raw': window.btoa(email).replace(/\+/g, '-').replace(/\//g, '_')
            }
          });
   
          return sendRequest.execute(callback);
        }
   
        function getHeader(headers, index) {
          var header = '';
          $.each(headers, function(){
            if(this.name.toLowerCase() === index.toLowerCase()){
              header = this.value;
            }
          });
          return header;
        }
   
        function getBody(message) {
          var encodedBody = '';
          if(typeof message.parts === 'undefined')
          {
            encodedBody = message.body.data;
          }
          else
          {
            encodedBody = getHTMLPart(message.parts);
          }
          encodedBody = encodedBody.replace(/-/g, '+').replace(/_/g, '/').replace(/\s/g, '');
          return decodeURIComponent(escape(window.atob(encodedBody)));
        }
   
        function getHTMLPart(arr) {
          for(var x = 0; x <= arr.length; x++)
          {
            if(typeof arr[x].parts === 'undefined')
            {
              if(arr[x].mimeType === 'text/html')
              {
                return arr[x].body.data;
              }
            }
            else
            {
              return getHTMLPart(arr[x].parts);
            }
          }
          return '';
        }
      </script>
      <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
    </body>


        </div>
        <!-- /#page-wrapper -->
	    



<script src="js/bootstrap-timepicker.min.js"></script>


<script>
jQuery(document).ready(function(){
    
  
  jQuery("#ssn").mask("999-99-9999");
  
  // Time Picker
  jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

  
});
</script>







<?php
 include ('footer.php');
 ?>