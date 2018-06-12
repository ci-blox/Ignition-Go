
<div class="container">

<div class="card">
    <div class="card-body forgotpw-card-body">
      <p class="login-box-msg">Forgot Password?</p>

<div class="form-group">
 <label for="email">Email:</label>
 <input id="email" class="form-control" type="email" placeholder="Your Email">
 </div>
<button type="submit" id="submit" class="btn btn-primary" onclick='return resetpw();' >Reset Password</button>
<div id="display"></div>
<script>
function resetpw(){
var em = $("#email").val();
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
