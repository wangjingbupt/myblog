<?php

class PostPhotoNew extends control{


	public function checkPara(){
		
		return true;
	}

	public function action(){

		$this->format();

	}


	public function includeFiles()
	{

		include(VIEW.'/photoNew.php');

	}
	
	public function format($datas=array())
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';

		$data['header']= <<<HTML
			<meta name="viewport" content="width=device-width">
			<link rel="stylesheet" href="/assets/css/style.css">
			<link rel="stylesheet" href="/assets/css/jquery.fileupload-ui.css">
HTML;
		$data['script'] = <<<HTML
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
var num;
{% for (var i=0, file; file=o.files[i]; i++) {
	 %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { 
					document.getElementById("photoNum").value =parseInt($("#photoNum").val())+1 	 
					num =  document.getElementById("photoNum").value;
					%}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
								<input type="hidden" name="photo_url" id="photo_url_{%=num%}" value ="{%=file.url%}"/>
            </td>
            <td class="size"><span><textarea rows="4" id='desc' name='desc_{%=num%}'  cols='150'  placeholder="图片描述"></textarea></span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}


</script>
<script>

$(document).ready(function(){           
		$("#photo_button").click(function(){       
	alert(document.getElementsByName('img_url').elements[0].value);
		//var img_obj = document.getElementsByName('img_url');
		
			//postdata(); 
			});   
		});   

function postdata(){ 
	var j = parseInt($("#photoNum").val())
  for (var i=0; i<j; i++) {
		post_data = "desc_$i="+$("#desc_$i").val();
	}
	$.ajax({ 
type: "POST", 
url: "/photo/add",     
data: "post_title="+$("#post_title").val()+"&post_content="+$("#desc").val(),  
success: function(msg){      
var dataObj=eval("("+msg+")");
if(dataObj.code == 'ok')
{
	window.location.href='/detail/'+dataObj.data._id;
}
else
{

}
}
	});}
</script>
<script>
$(document).ready(function(){           
		$("#newalbum_button").click(function(){       
				var insertText = '<input type="text" placeholder="相册名称" name="album_title" id="album_title" class="input-xlarge" style="margin-left:15px;">';
		document.getElementById("newAlbum").innerHTML = document.getElementById("newAlbum").innerHTML + insertText;
		});   
			});   

</script>
<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/assets/js/upload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="/assets/js/upload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/assets/js/upload/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/assets/js/upload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<!--
<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/assets/js/upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/assets/js/upload/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="/assets/js/upload/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/assets/js/upload/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="/assets/js/upload/locale.js"></script>
<!-- The main application script -->
<script src="/assets/js/upload/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
HTML;
		$GLOBALS['DATA'] = $data;
		ViewPhotoNew::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
