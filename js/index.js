$(document).ready(function(){

	initFileUploader("#zdrop");
		function initFileUploader(target) {
			var previewNode = document.querySelector("#zdrop-template");
			previewNode.id = "";
			var previewTemplate = previewNode.parentNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);


			var zdrop = new Dropzone(target, {
				url: 'upload.php',
                maxFiles:1,
				maxFilesize:100000,
				previewTemplate: previewTemplate,
				previewsContainer: "#previews",
				clickable: "#upload-label"
			});

			zdrop.on("addedfile", function(file) { 
				$('.preview-container').css('visibility', 'visible');
				//html ='<a href="">Download link</a>';
				$("#liks").show();

			});

			zdrop.on("totaluploadprogress", function (progress) {
				var progr = document.querySelector(".progress progress-bar");
					if (progr === undefined || progr === null)
							return;

						progr.style.width = progress + "%";
					});

					zdrop.on('dragenter', function () {
						$('.fileuploader').addClass("active");
					});

					zdrop.on('dragleave', function () {
						$('.fileuploader').removeClass("active");			
					});

					zdrop.on('drop', function () {
						$('.fileuploader').removeClass("active");	
					});
					
		  }

	});

	function view_drive()
	{
		
		var time_id = $('#duration').val();
		var one_time = $("#one_time:checked").val();
		var drive = $('#storage:checked').val();
	 	window.location ="functions.php?go=my_drive&time="+time_id+"&d="+drive+"&o="+one_time;
	}

	function insert_exp()
	{
		
		var time_id = $('#duration').val();
		var one_time = $("#one_time:checked").val();
	 	window.location ="functions.php?fn=get_link&time="+time_id+"&o="+one_time;
	}
	

	function myFunction() {
		/* Get the text field */
		var copyText = document.getElementById("myInput");
	  
		/* Select the text field */
		copyText.select();
	  
		/* Copy the text inside the text field */
		document.execCommand("Copy");
	  
		/* Alert the copied text */
		alert("Copied the text: " + copyText.value);
	  } 