<div id="dialog-login_form" title="Sign In">
    <form name="ajax_login_form" action="<?php echo zen_href_link(FILENAME_LOGIN,'action=process') ?>" method="post" >
    <fieldset>
        <label for="email">Email</label>
        <div>
        <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
        </div>
        <label for="password">Password</label>
        <div>
        <input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
        </div>
        <br />
        <p id="login-message"></p>
    </fieldset>
    </form>
</div>
<script>
        $( "#dialog-login_form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Sign In": function() {
                    var email = $("#email").val();
                    var password = $("#password").val();
                    var this_dialog = $(this);
                    $.post(
                            ajax_login_form.action, 
                            { 'email_address' : email, 'password' : password ,'ajax_request':'post','securityToken':'<?php echo $_SESSION['securityToken'] ?>'} ,
                            function(data){
                                if(data.eventID=='NOTIFY_LOGIN_SUCCESS'){
                                    $("#ajax_update_section-header").html(data.result);
                                    this_dialog.dialog( "close" );
                                }else if(data.eventID=='NOTIFY_LOGIN_FAILURE'){
                                    var msg = $( "#login-message" );
                                    msg.text(data.result).addClass( "ui-state-highlight" ).show();
                                    setTimeout(function() {
                                        msg.animate({opacity: 'hide'}, "slow");
                                    }, 2000 );                                    
                                }
                            },
                            'json'
                        );
                    return false;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });    
</script>