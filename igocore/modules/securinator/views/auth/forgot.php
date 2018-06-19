<!DOCTYPE html>
<html>
<style>

    body{
        background: url("http://ignitiongo.local/assets/img/boxed-bg.jpg");
    }

    #body-box{
        border-radius:6px;
        margin-top:5%;  
        margin-left:22%;
        font-size:16px;
    }

    #forgot-text{
        font-size:14px;
    }

    #forgot-label{
        background:none;
    }

    #email, #new-pw, #confirm-pw{
        border-radius:6px;
        font-size:14px;
    }

    #invalid-email{
        font-size:14px;
        color:#ff3333; 
        float:left;
        padding:2% 0% 0% 1.5%;
    }

    #submit, #submit1 {
        border-radius:6px;
        display:inline-block;
        float:right;
        font-size:16px;
    }

    .hidden{
        display:none;
    }

    #new-pw, #confirm-pw{
        margin-top:2%;
    }

    #show-pw-text{
        font-size:14px;
        display:inline-block;
        float:left;
        padding:1% 0 0 2%;
    }

    

</style>

<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<title>Forgot Password</title></head>

<body>
<div class="container" id="body-box">
    <div class="card col-sm-6">
        <div class="card-header h3" id="forgot-label">Forgot Password?</div>
        <div class="card-body forgotpw-card-body">
            <div id="email-div">    
                <p id="forgot-text">
                        If you have forgotten your password and/or username, 
                        enter the email address used for your account.
                        <?php /* and we will send you an e-mail
                        with instructions on how to access your account. */
                        ?> </p>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" class="form-control" type="email" placeholder="Your Email">
                </div>
                <div id="invalid-email" class="hidden">Invalid Email</div>
                <br/>
                <button id="submit1" class="btn btn-primary" onclick='showResetFields();'>Reset Password</button>
            </div>

            <div id="changepw-div" class="hidden">
                <h5 id="new-pw-label">Please enter a new password:</h5>
                <input type="password" id="new-pw" class="form-control" placeholder="New password: ">
                <input type="password" id="confirm-pw" class="form-control" placeholder="Retype password: ">
                <div  id="show-pw-text">
                    <input type="checkbox" id="showPW-check" onclick="showPassword()" > Show Password
                </div>
                <br>
                <button type="submit" id="submit" class="btn btn-primary" onclick='checkPW();'>Reset Password</button>
            </div>

            <div id="success-msg" class="hidden">
                <h2>Success!</h2>
                <h6>Your password has been changed successfully. Please log in again with your new password.</h6>
            </div>

        </div>
    </div>
</div>


<script>
    function showResetFields(){
        var em = $("#email").val().trim();
        if(em.length < 5) {
            $('#invalid-email').removeClass('hidden');
            return true;
        }
        var dataString = 'em1='+ em;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>users/recover",
            data: dataString,
            cache: false,
            success: function(result){
            $("#display").html(result.msg);
            $('#changepw-div').removeClass('hidden');
            $('#email-div').addClass('hidden');
        }
        });
    }
    

    function checkPW() {
        var newPW = document.getElementById("new-pw").value;
        var confirmPW = document.getElementById("confirm-pw").value;
        if (newPW != confirmPW) {
            alert("The passwords entered do not match.");
            return false;
        } else if (newPW.length < <?php echo $pw_min_length?>) {
            alert("Your password must be at least <?php echo $pw_min_length?> characters.");
        <?php if($pw_force_numbers == 0) { ?> 
        } else if (newPW.search(/\d/) == -1) {
            alert("Your password must contain at least one number.");
        <?php } ?> 
        } else { 
            var dataString = 'newpw='+ newPW+'&email='+$('#email').val().trim();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>users/reset_password",
                data: dataString,
                success: function(result) {
                    $('#changepw-div').addClass('hidden');
                    $('#success-msg').removeClass('hidden'); 
                    $('#forgot-label').addClass('hidden'); 
                    return true;
                },
                error: function(msg) {
                }
            });
        }
    }

    function showPassword(){
        var pw1 = document.getElementById("new-pw");
        var pw2 = document.getElementById("confirm-pw");
        if (pw1.type === "password") {
            pw1.type = "text";
            pw2.type = "text";
        } else {
            pw1.type = "password";
            pw2.type = "password";
        }
    }

</script>
</body>
</html>
