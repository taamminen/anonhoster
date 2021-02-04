$("#register-form").submit(function() {
  $.ajax({
    url: "/register",
    method: "post",
    dataType: "json",
    data: {
      username: $("[name=username]").val(),
      password: $("[name=password]").val(),
      confirm_password: $("[name=confirm_password]").val(),
      csrf: $("[name=csrf]").val()
    }, success: function(data) {
      console.log(data);
      if (data["message"] == "") {
        alert("Registration was successful. Now you can log in.");
        window.location.href = "/login";
      } else {
        alert(data["message"])
      };
    }, error: function(data) {console.log(data);}
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
      password: $("[name=password]").val(),
      csrf: $("[name=csrf]").val()
    }, success: function(data) {
      console.log(data);
      if (data["message"] == "") {
        alert("You are successfully logged in.");
        window.location.href = "/files";
      } else alert(data["message"]);
    }, error: function(data) {console.log(data);}
  });
  return false;
});

$("#about").text(
  $("#about").text().replace(/(https?:\/\/[^\s]+)/g, function (url) {
    return '<a href="' + url + '">' + url + '</a>';
  })
);
