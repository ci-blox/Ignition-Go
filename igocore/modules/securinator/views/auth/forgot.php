
<div class="container">
 <div class="form-group">
 <label for="email">Email:</label>
 <input id="email" class="form-control" type="email" placeholder="Your Email">
 </div>
<button type="submit" id="submit" class="btn btn-default">Reset Password</button>
<div id="display"></div>
<script>
$(document).ready(function(){
$("#submit").click(function(){
var em = $("#email").val();
var dataString = 'em1='+ em;
$.ajax({
type: "POST",
url: "<?php echo base_url(); ?>/securinator/forgot",
data: dataString,
cache: false,
success: function(result){
$("#display").html(result);
}
});
return false;
});
});
</script>
</div>