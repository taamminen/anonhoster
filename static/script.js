$("#register-form").submit(function() {
  $.ajax({
    url: "/register",
    method: "post",
    dataType: "json",
    data: {
      username: $("[name=username]").val(),
      password: $("[name=password]").val(),
      confirm_password: $("[name=confirm_password]").val()
    }, success: function(data) {
      console.log(data);
      if (data["message"] == "") {
        alert("Registration was successful. Now you can log in.");

      } else alert(data["message"]);
    }
  });
  return false;
});

$("#login-form").submit(function() {
  $.ajax({
    url: "/login",
    method: "post",
    dataType: "json",
    data: {
      username: $("[name=username]").val(),
      password: $("[name=password]").val()
    }, success: function(data) {
      console.log(data);
      if (data["message"] == "") {
        alert("You are successfully logged in.");
      } else alert(data["message"]);
    }
  });
  return false;
});
