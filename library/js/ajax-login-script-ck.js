jQuery(document).ready(function(e){var t=e("body"),n=e("form#login");e(".login_button").on("click",function(r){t.prepend('<div class="login_overlay"></div>');t.children().not("form#login").addClass("blurred");n.fadeIn(1e3);e("div.login_overlay, form#login a.close").on("click",function(n){n.preventDefault();t.children().not("form#login").addClass("unblur");e("div.login_overlay").fadeOut(1e3,function(){e(this).remove();t.children().removeClass("blurred unblur")});e("form#login").fadeOut(1e3)});r.preventDefault()});e("form#login").on("submit",function(t){e("form#login p.status").show().text(ajax_login_object.loadingmessage);e.ajax({type:"POST",dataType:"json",url:ajax_login_object.ajaxurl,data:{action:"ajaxlogin",username:e("form#login #username").val(),password:e("form#login #password").val(),security:e("form#login #security").val()},success:function(t){e("form#login p.status").text(t.message);t.loggedin==1&&(document.location.href=ajax_login_object.redirecturl)}});t.preventDefault()})});