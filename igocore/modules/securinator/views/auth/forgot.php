
<div class="container">

<div class="card col-sm-6">
    <div class="card-header h3">Forgot Password?</div>
    <div class="card-body forgotpw-card-body">
    <p>
			If you have forgotten your password and/or username, 
			enter the email address used for your account.
<?php            /* and we will send you an e-mail
            with instructions on how to access your account. */
         ?> </p>

        <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" class="form-control" type="email" placeholder="Your Email">
        </div>
        <br/>
        <button type="submit" id="submit" class="btn btn-primary" onclick='return resetpw();' >Reset Password</button>
<div id="display"></div>
<script>
function resetpw(){
var em = $("#email").val().trim();
if(em.length < 5) {
    $("#display").html('Email is required.');
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
}
});
return false;
}
</script>
</div>
</div>
</div>
</div>
