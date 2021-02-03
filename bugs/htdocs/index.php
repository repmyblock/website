<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		<META charset="UTF-8">
		<TITLE>Rep My Block - Represent My Block - Upload a File</TITLE>
		<link rel="icon" href="https://repmyblock.nyc/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="https://repmyblock.nyc/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="https://repmyblock.nyc/pics/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="https://repmyblock.nyc/font/montserrat.css">
		<link rel="stylesheet" type="text/css" href="https://repmyblock.nyc/css/RepMyBlock.css">		

		<style>
		#drop_file_zone {
		    background-color: #EEE; 
		    border: #999 5px dashed;
		    width: 100%; 
		    height: 300px;
		    padding: 8px;
		    font-size: 18px;
		}

		#drag_upload_file {
		  width:100%;
		  margin:0 auto;
		}

		#drag_upload_file p {
		  text-align: center;
		}

		#drag_upload_file #selectfile {
		  display: none;
		}
		</STYLE>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript">
		  var fileobj;
		  function upload_file(e) {
		    e.preventDefault();
		    fileobj = e.dataTransfer.files[0];
		    ajax_file_upload(fileobj);
		  }
		 
		  function file_explorer() {
		    document.getElementById('selectfile').click();
		    document.getElementById('selectfile').onchange = function() {
		        fileobj = document.getElementById('selectfile').files[0];
		      ajax_file_upload(fileobj);
		    };
		  }
		 
		  function ajax_file_upload(file_obj) {
		    if(file_obj != undefined) {
		        var form_data = new FormData();                  
		        form_data.append('file', file_obj);
		      $.ajax({
		        type: 'POST',
		        url: 'ajax.php',
		        contentType: false,
		        processData: false,
		        data: form_data,
		        success:function(response) {
		          alert(response);
		          $('#selectfile').val('');
		        }
		      });
		    }
		  }
		</script>
	</HEAD>
	
	<BODY>
		<DIV class="header">
			<div class="header-left">
		 		<a href="https://repmyblock.nyc" class="logo"><IMG SRC="https://static.repmyblock.nyc/pics/logo/RepMyBlock.png" height=70 class="header-logo"></a>
			</DIV>
		  <div class="header-right">
  	  	<a href="https://repmyblock.nyc/exp/website/contact">CONTACT</a>
	    	<a href="https://repmyblock.nyc/exp/website/login">LOGIN</a>
		  </DIV>
		</DIV> 
		
		<div class="navbar">
		  <a href="https://repmyblock.nyc//exp/website/propose">NOMINATE</a>
		  <a href="https://repmyblock.nyc/exp/website/interested">REPRESENT</a>
		  <a href="https://repmyblock.nyc/about/" class="active">ABOUT</a> 
		</div>

		<div class="main">
			<P CLASS="BckGrndCenter">Submit a problem with the RepMyBlock website</P>
			<div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
			  <div id="drag_upload_file">
			  	<BR><BR>
			    <p>Drop one file here and wait for the confirmation</p>
			    <p>or</p>
			    <p><input type="button" value="Select File" onclick="file_explorer();"></p>
			    <input type="file" id="selectfile">
			  </div>
			</div>
		</DIV>

		<div class="footer">
			<P CLASS="footerclass1">
				<DIV CLASS="FooterTitle">REP MY BLOCK</DIV>
				<DIV CLASS="FooterInfo">Represent Community By Running For County Committee</DIV>
			</P>
			
			<P CLASS="footerclass2">
				<DIV CLASS="FooterLinks">
					<A HREF="https://repmyblock.nyc/exp/website/about">ABOUT</A>
					<A HREF="https://repmyblock.nyc/exp/website/interested">REPRESENT</A>
					<A HREF="https://repmyblock.nyc/exp/website/propose">NOMINATE</A>
					<A HREF="https://repmyblock.nyc/exp/website/howto">HOWTO</A>
					<A HREF="https://repmyblock.nyc/exp/website/contact">CONTACT</A>
					<A HREF="https://repmyblock.nyc/exp/website/login">LOGIN</A>
				</DIV>
			
				<DIV CLASS="FooterSocial">
					<A TARGET="twitter" HREF="https://twitter.com/RepMyBlock">Twitter</A>
					<A TARGET="facebook" HREF="https://www.facebook.com/RepMyBlock">Facebook</A>
					<A TARGET="instagram" HREF="https://www.instagram.com/RepMyBlockNYC">Instagram</A>
				</DIV>
			
				<DIV CLASS="FooterStuff">
					<I>RepMyBlock is a <A HREF="https://repmyblock.us">Represent My Block</A> project.</I>
				</DIV>
			</P>
		</DIV>			
	
	</BODY>	
</HTML>
