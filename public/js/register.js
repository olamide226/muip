function register() {
  // APPEND FORM DATA
  var data = new FormData();
  data.append('name', document.getElementById("user_name").value);
  data.append('email', document.getElementById("user_email").value);
  data.append('password', document.getElementById("user_password").value);
  data.append('cpassword', document.getElementById("user_cpassword").value);

  // INIT AJAX
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "ajax-register.php", true);

  // WHEN THE PROCESS IS COMPLETE
  xhr.onload = function () {
    if (xhr.status == 404 || xhr.status == 403) {
      alert("Error loading file!");
    } else {
      var res = JSON.parse(this.response);
      if (res['status']) {
        // REGISTER OK - REDIRECT
        window.location.href = "2d-more.html";
      } else {
        // REGISTER FAIL
        alert(res['message']);
      }
    }
  };

  // SEND
  xhr.send(data);
  return false;
}
$("#main55").on('submit', function(e){

     e.preventDefault();
     console.log("sending ajax...");
     var myform = document.getElementById("main");
       var fd = new FormData(myform );
       $.ajax({
           url: "ajax-register.php",
           data: fd,
           cache: false,
           processData: false,
           contentType: false,
           type: 'POST',
           success: function (res) {
               // do something with the result
               if (res['status']) {
                 // REGISTER OK - REDIRECT
                 window.location.href = "2d-more.html";
                 console.log(res);
               } else {
                 // REGISTER FAIL
                 alert(res['message']);
               }
           }
       });

  });

function setCookie(cname, cvalue, hours=1) {
  var d = new Date();
  d.setTime(d.getTime() + (hours*1*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function submit(){
  $.ajax({
    type: 'post',
    url: 'ajax-register.php',
    data: $('form').serialize() + '&_token={{ csrf_token() }}',
    success: function (res) {
      // alert('form was submitted');
      let res1 = JSON.parse(res)
        // do something with the result
        if (res1.status) {
          // REGISTER OK - REDIRECT
          setCookie('emv-226',  document.getElementById("user_email").value);//store email in preparation for payment
          window.location.href = "payment.php";
          console.log(res1.status);
        } else {
          // REGISTER FAIL
          $("form").addClass("was-validated");
          alert(res1.message);
        }
        // console.log(typeof(res1));
    }
  });
}

function login(){
  var formData = $('form').serialize()
  formData += '&req=in'

  $.ajax({
    type: 'post',
    url: 'ajax-login.php',
    data: formData,
    success: function (res) {
          if (res == 'OK') {
            window.location.href = "index.php";
          }else {

            alert('Wrong Username/Passowrd');
          }
          }
  });
}

  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_test_0aef15035be5e81a494cac0051c330a341d78d35',
      email: document.getElementById("user_email").value,
      amount: 1000,
      currency: "NGN",
      // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+234" + parseInt(document.getElementById("phone").value)
            }
         ]
      },
      callback: function(response){
          console.log('success. transaction ref is ' + response.reference);
          $("#tx").text(response.reference);
          // submit();
      },
      onClose: function(){
          // alert('window closed');
          $('#loading-image').show();
      }
    });
    handler.openIframe();
  }
