 var c = new Croppie(document.getElementById('demo-basic'), {
          viewport: {
              width: 200,
              height: 300,
              type: 'square' //default 'square'
          },
          
          boundary: {
              width: 275,
              height: 400
          },
          customClass: '',
          enableZoom: true, //default true // previously showZoom
          showZoomer: true, //default true
          mouseWheelZoom: true, //default true
          update: function (cropper) { }
      });

      // bind an image to croppie
      c.bind({
          url: "<?= $PicturePath ?>"
          <?php WriteStderr($null, "INSIDE Croppie.js -> $PicturePath"); ?>
      });

      // set the zoom programatically. Restricted to the min/max values of the slider
      c.setZoom(1.5);

      // get crop points from croppie
      var data = c.get();

      // get result from croppie
      // returns Promise
      var result = c.result('html').then(function (img) {
          //img is html positioning & sizing the image correctly if resultType is 'html'
          //img is base64 url of cropped image if resultType is 'canvas' 
      });
      
      document.addEventListener('DOMContentLoaded', function() {

			    var cropBtn = document.getElementById('cropBtn');

			    cropBtn.addEventListener('click', function() {

			        c.result({
			            type: 'base64',
			            circle: false,
			            format: 'png',
			            size: 'viewport'
			        }).then(function(imageResult) {

			            let formData = new FormData();
			            formData.append('base64_img', imageResult);

			            fetch('uploadcropped', {
			                method: 'POST',
			                body: formData
			            })
			            // .then(response => response.json())
			            .then(response => response.text())
									.then(text => {
									    console.log("Server returned:", text);
									})
			            .then(function(data) {
			                console.log(data);
			                window.location.href = "updatecandidateprofile";
			            });

			        });

			    });

			});
