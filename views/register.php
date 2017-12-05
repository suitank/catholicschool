<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School | Register</title>

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/app.css">
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <h3 class="display-2">Home Study Catholic School - Register</h3>
    </div>
  </div>

  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
    <div id="alert101" class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Sorry, it appears this email address is already registered. Did you already create an account? Then please <a href="/views/login.php">log in</a> to that account
    </div>
    <div id="alert102" class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Login failed. Please try <a href="/views/login.php">log in</a> later.
    </div>
    <div id="alert500" class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Server side error. </strong><span class="alert-content"></span>
    </div>
    <div id="alert200" class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Signup Success! </strong><span class="alert-content">Welcome to Catholic School.</span>
    </div>
    <div id="alert0" class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Sorry, some unknown error occurred! Please contact us at <strong>support@ada.school</strong> to resolve this problem.
    </div>

    <form id="signup_form" action="action.php" method="post">
      <input type="hidden" id="Account_Id" name="Account_Id" value="">
      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-group" data-validate="email">
          <input type="text" class="form-control" name="email" id="email" placeholder="you@example.com" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>

        <label for="password">Password</label>
        <div class="input-group" data-validate="password">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>

        <label for="password">Confirm Password</label>
        <div class="input-group" data-validate="confirm-password">
          <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>
      </div>

      <div class="controll-bar">
        <a href="../index.php">
          <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
        </a>
        <button id="btn_signup" type="button" class="btn btn-primary" disabled>Create Account</button>
      </div>
    </form>
  </div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/moment.min.js"></script>

<script>
  'use strict';
  $(document).ready(function() {
    $('#signup_form input[required]').on('keyup change', function() {
      let $form = $(this).closest('form'),
          $group = $(this).closest('.input-group'),
          $addon = $group.find('.input-group-addon'),
          $icon = $addon.find('span'),
          state = false;
            
      if (!$group.data('validate')) {
        state = $(this).val() ? true : false;
      } else if ($group.data('validate') == "email") {
        state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val());
      } else if ($group.data('validate') == "password") {
        if ($(this).val().length && ($('#confirm-password').val() == $(this).val())) {
          state = true;
        } else {
          state = false;
        }

        let $confirmAddon = $('#confirm-password').next();
        let $confirmIcon = $confirmAddon.find('span');
        if (state) {
          $confirmAddon.removeClass('danger');
          $confirmAddon.addClass('success');
          $confirmIcon.attr('class', 'glyphicon glyphicon-ok');
        } else {
          $confirmAddon.removeClass('success');
          $confirmAddon.addClass('danger');
          $confirmIcon.attr('class', 'glyphicon glyphicon-remove');
        }
      } else if ($group.data('validate') == "confirm-password") {
        if ($(this).val().length && ($('#password').val() == $(this).val())) {
          state = true;
        } else {
          state = false;
        }

        let $confirmAddon = $('#password').next();
        let $confirmIcon = $confirmAddon.find('span');
        if (state) {
          $confirmAddon.removeClass('danger');
          $confirmAddon.addClass('success');
          $confirmIcon.attr('class', 'glyphicon glyphicon-ok');
        } else {
          $confirmAddon.removeClass('success');
          $confirmAddon.addClass('danger');
          $confirmIcon.attr('class', 'glyphicon glyphicon-remove');
        }
      }

      if (state) {
        $addon.removeClass('danger');
        $addon.addClass('success');
        $icon.attr('class', 'glyphicon glyphicon-ok');
      } else {
        $addon.removeClass('success');
        $addon.addClass('danger');
        $icon.attr('class', 'glyphicon glyphicon-remove');
      }
          
      if ($form.find('.input-group-addon.danger').length == 0) {
        $('#btn_signup').prop('disabled', false);
      } else {
        $('#btn_signup').prop('disabled', true);
      }
    });

    $('#signup_form input[required]').trigger('change');

    $('#btn_signup').on('click', function(e) {
      $('.alert-danger').slideUp("fast");

      $.ajax({
        type: "post",
        url: "../app/api_signup.php",
        data: {
          email: $('#email').val(),
          password: $('#password').val()
        },
        dataType: "json",
        success: function(response) {
          
          if (response.status == 101) {

            $('#signup_form #email').focus();
            $('#alert101').slideDown("slow");
          } else if (response.status == 102) {
            $('#signup_form #email').focus();
            $('#alert102').slideDown("slow");
          } else if (response.status == 500) {
            $('#alert500 .alert-content').html(response.message);
            $('#alert500').slideDown("slow");
          } else if (response.status == 200) {
            
            $('#Account_Id').val(response.Account_Id);
            $('#alert200').slideDown("slow");


            setTimeout(function() {
              $.ajax({
                type: "post",
                url: "../app/api_session.php",
                data: {
                  type: "set",
                  email: response.email,
                  account_id: response.Account_Id
                },
                dataType: "json",
                success: function(response) {
                  $('#signup_form').submit();
                },
                error: function(xhr, status, error) {
                  var err = xhr.responseText;
                  alert(err);
                  $('.alert-danger').slideDown("slow");
                }
              })
            }, 2000);
          } else {
            // $('#alert-connect').slideDown("slow");
            $('#alert0').slideDown("slow");
          }
        },
        error: function( jqXHR, textStatus, errorThrown) {
          $('#alert500 .alert-content').html('Server internal error');
          $('#alert500').slideDown("slow");
        },
      });
    });
  });
</script>
</body>
</html>