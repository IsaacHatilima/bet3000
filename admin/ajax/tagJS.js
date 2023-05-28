$('#save_tag').click(function(e){
    if ($.trim($("#tag").val()) === "") {
        $("#_alert").css("display", "block");
        $("#_alert").removeClass("alert-primary").addClass("alert-warning");
        $("#msg").html('Tag is required.');
        return false;
    }
    else{
        $("#_alert").css("display", "block");
        $("#_alert").removeClass("alert-warning alert-danger").addClass("alert-primary");
        $("#msg").html('Processing! Please Wait...');
        var btn = document.getElementById('save_tag');
        btn.disabled = true;
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "../core/tagsLogic.php",
            data: $("form").serialize(),
            cache: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response == "200") 
                {
                    $("#msg").html('Tag saved.');
                    $("#_alert").removeClass("alert-primary alert-warning").addClass("alert-success");
                    setTimeout(function () {
                        window.location.href = './tags';
                    }, 2200);
                } 
                else if (response === "400") 
                {
                    $("#msg").html('Tag not saved. Try again.');
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
    $("#_delAlert").css("display", "block");
    $("#_delAlert").removeClass("alert-warning alert-danger").addClass("alert-primary");
    $("#delMsg").html('Processing! Please Wait...');
    $.ajax({
        type: "post",
        url: "../core/tagsLogic.php",
        data: {"deleteID" : x},
        success: function (response) {
            console.log(response);
            if (response == "200") 
            {
                $("#delMsg").html('Tag Deleted.');
                $("#_delAlert").removeClass("alert-primary alert-warning").addClass("alert-success");
                setTimeout(function () {
                    window.location.href = './tags';
                }, 2200);
            } 
            else if (response === "400") 
            {
                $("#delMsg").html('Tag not deleted. Try again.');
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