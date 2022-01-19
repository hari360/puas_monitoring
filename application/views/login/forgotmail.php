<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Forgot Mail</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/style_red.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script><script type="text/javascript">

	function isEmailValid(email){
		var e = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return e.test(email);
	}
	function sendForm(){
		jQuery("#imessageOK, #imessageERROR").hide();
		jQuery(".required").removeClass("required");
		if(jQuery("#YourName").val()==""){jQuery("#YourName").addClass("required");window.scroll(0,0);return false;}if(jQuery("#YourEmail").val()==""){jQuery("#YourEmail").addClass("required");window.scroll(0,0);return false;}if(!isEmailValid(jQuery("#YourEmail").val())){jQuery("#YourEmail").addClass("required");window.scroll(0,0);return false;}if(jQuery("#YourMessage").val()==""){jQuery("#YourMessage").addClass("required");window.scroll(0,0);return false;}jQuery("#SendaMessage").val("Please Wait...");		var AddDetails; AddDetails+="&YourName="+encodeURIComponent(jQuery("#YourName").val());AddDetails+="&YourEmail="+encodeURIComponent(jQuery("#YourEmail").val());AddDetails+="&YourMessage="+encodeURIComponent(jQuery("#YourMessage").val());jQuery("input:radio[name=Iprefer]:checked").each(function(){
				AddDetails+="&Iprefer="+encodeURIComponent(this.value);
			});AddDetails+="&Myageis="+encodeURIComponent(jQuery("#Myageis").val());		
	}

</script>
</head>
<body>
<?php 
$attributes = array('class' => 'iform', 'id' => 'formatactterm');
echo form_open('login/sendforgotmail', $attributes);
?>
<ul>
<li class="iheader">Reset Password</li>
<li>
    <label for="email">Email</label>
    <input class="itext" type="text" name="YourEmail" id="YourEmail" />
</li>
<li><label>&nbsp;</label><input type="submit" class="ibutton" onclick="sendForm()" name="submit" id="submit" value="Submit!" /></li>
</ul>
<?php echo form_close();?>
<?php 
if (isset($response)) {
    echo "\r\n<ul>\r\n";
    echo "\r\n", $response, "\r\n";
    echo "</ul>\r\n";
}
?>
</body>
</html>