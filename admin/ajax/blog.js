$('#post').click(function (e) {
    e.preventDefault();
    if ($.trim($("#title").val()) === "" || $.trim($("#body").val()) === "" || $.trim($("#tags").val()) === "") {
        $("#_alert").css("display", "block");
        $("#_alert").removeClass("alert-primary").addClass("alert-warning");
        $("#msg").html('All fields are required.');
        return false;
    }
    else{
        $("#_alert").css("display", "block");
        $("#_alert").removeClass("alert-warning alert-danger").addClass("alert-primary");
        $("#msg").html('Processing! Please Wait...');
        var btn = document.getElementById('post');
        btn.disabled = true;
        var tags = $("#tags").val()
        var body = $("#body").val()
        var title = $("#title").val()
        $.ajax({
            type: "post",
            url: "../core/blogLogic.php",
            data: {"tags" : tags, "body" : body, "title" : title},
            success: function (response) {
                console.log(response);
                if (response == "200") 
                {
                    $("#msg").html('Blog saved.');
                    $("#_alert").removeClass("alert-primary alert-warning").addClass("alert-success");
                    setTimeout(function () {
                        window.location.href = '.';
                    }, 2200);
                } 
                else if (response === "400") 
                {
                    $("#msg").html('Blog not saved. Try again.');
                    $("#_alert").removeClass("alert-primary").addClass("alert-warning");
                    btn.disabled = false;
                } 
                else if (response === "500") 
                {
                    $("#_alert").removeClass("alert-warning alert-primary").addClass("alert-danger");
                    $("#msg").html('Server Error');
                    btn.disabled = false;
                }
          },
        });
    }
});