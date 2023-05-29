$('#post').click(function (e) {
    // Saves blog to database
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

function Deletes(x) {
    // Delete Blog by ID
    $("#_delAlert").css("display", "block");
    $("#_delAlert").removeClass("alert-warning alert-danger").addClass("alert-primary");
    $("#delMsg").html('Processing! Please Wait...');
    $.ajax({
        type: "post",
        url: "../core/blogLogic.php",
        data: {"deleteID" : x},
        success: function (response) {
            if (response == "200") 
            {
                $("#delMsg").html('Blog Deleted.');
                $("#_delAlert").removeClass("alert-primary alert-warning").addClass("alert-success");
                setTimeout(function () {
                    window.location.href = './blogs';
                }, 2200);
            } 
            else if (response === "400") 
            {
                $("#delMsg").html('Blog not deleted. Try again.');
                $("#_delAlert").removeClass("alert-primary").addClass("alert-warning");
            } 
            else if (response === "500") 
            {
                $("#_delAlert").removeClass("alert-warning alert-primary").addClass("alert-danger");
                $("#delMsg").html('Server Error');
            }
        },
    });
}