jQuery(document).ready(function($) {

    // Show the login dialog box on click
    var $body = $('body');
    var $formLogin = $('form#login');
    $('.login_button').on('click', function(e){
        $body.prepend('<div class="login_overlay"></div>');
        $body.children().not("form#login").addClass("blurred");
        $formLogin.fadeIn(1000);
        $('div.login_overlay, form#login a.close').on('click', function(e){
        	e.preventDefault();
        	$body.children().not("form#login").addClass("unblur");
            $('div.login_overlay').fadeOut(1000, function() {
            	$(this).remove();
            	$body.children().removeClass("blurred unblur");
            });
            
            $('form#login').fadeOut(1000);
        });
        e.preventDefault();
    });

    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $('form#login p.status').show().html(bl_ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: bl_ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val() },
            success: function(data){
                $('form#login p.status').html(data.message);
                if (data.loggedin == true){
                    document.location.href = bl_ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});