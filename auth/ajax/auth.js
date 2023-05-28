$('#login').click(function(e){
    if ($.trim($("#username").val()) === "" || $.trim($("#password").val()) === "") {
        $("#auth_alert").css("display", "block");
        $("#auth_alert").removeClass("alert-primary").addClass("alert-warning");
        $("#msg").html('Username and Password are required.');
        return false;
    }
    else{
        $("#auth_alert").css("display", "block");
        $("#auth_alert").removeClass("alert-warning alert-danger").addClass("alert-primary");
        $("#msg").html('Authenticating! Please Wait...');
        var btn = document.getElementById('login');
        btn.disabled = true;
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "./core/core.php",
            data: $("form").serialize(),
            cache: false,
            processData: false,
            success: function (response) {
                if (response == "200") 
                {
                    $("#msg").html('Authenticated! Redirecting.');
                    $("#auth_alert").removeClass("alert-primary alert-warning").addClass("alert-success");
                    setTimeout(function () {
                        window.location.href = '../admin/pages/';
                    }, 2200);
                } 
                else if (response === "404") 
                {
                    $("#msg").html('Invalid Username or Password.');
                    $("#auth_alert").removeClass("alert-primary").addClass("alert-warning");
                    btn.disabled = false;
                } 
                else if (response === "500") 
                {
                    $("#auth_alert").removeClass("alert-warning alert-primary").addClass("alert-danger");
                    $("#msg").html('Server Error');
                    btn.disabled = false;
                }
          },
        });
    }
});