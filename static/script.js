$('#register-form').submit(function() {
    $.ajax({
        url: "/api/check.username/" + $("[name=username]").val(),
        type: "GET", dataType: "json",
        success: function(data) {
            if (data["error"] != false) {
                $(".title").text(data["error"]);
                return false;
            } else return true;
        }
    });
});
