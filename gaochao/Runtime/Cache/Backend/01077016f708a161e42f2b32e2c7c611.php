<?php if (!defined('THINK_PATH')) exit();?><div class="upload-img-box clearfix">
<?php
 $btn_class=''; $is_show=""; if($config['multi']!="true"){ $html=''; if($info!=''){ $is_show='style="display:block;"'; $size=getimagesize(str_replace('/gaochao/Uploads','Uploads',thumb($info))); $width=$size[0]; $height=$size[1]; if($width>140){ $wscale=140/$width; $width=140; $height=$height*$wscale; } if($height>140){ $hscale=140/$height; $height=140; $width=$width*$hscale; } $paddingTB=(140-$height)/2; $html.='<div class="upload-pre-item" style="margin:0;padding-top:'.$paddingTB.'px;padding-bottom:'.$paddingTB.'px;"><img src="'.thumb($info).'" width="'.$width.'" height="'.$height.'" /><div class="delThis" title="删除" onclick="delThis_'.$config['index'].'(this)" index="'.$id.'"></div></div>'; } }else{ $html=''; $btn_class=' upload-pre-item pull-left upload_'.$config['multi']; $_list=M($config['table'])->where(array($config['table_id']=>$id,$config['val_key']=>array('neq','')))->select(); $index=0; foreach ($_list as $row) { $index++; $size=getimagesize(str_replace('/gaochao/Uploads','Uploads',thumb($row[$config['val_key']]))); $width=$size[0]; $height=$size[1]; if($width>140){ $wscale=140/$width; $width=140; $height=$height*$wscale; } if($height>140){ $hscale=140/$height; $height=140; $width=$width*$hscale; } $paddingTB=(140-$height)/2; $html.='<div class="upload-pre-item pull-left" style="padding-top:'.$paddingTB.'px;padding-bottom:'.$paddingTB.'px;"><img src="'.thumb($row[$config['val_key']]).'" width="'.$width.'" height="'.$height.'" /><div class="delThis" title="删除" onclick="delThis_'.$config['index'].'(this)" index="'.$row['id'].'"></div></div>'; } } if($config['multi']=="true"){ echo $html; } if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 9.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6.0")){ ?>
	<input type="file" id="upload_picture_<?=$config['index']?>">

	<script type="text/javascript">
	if(typeof(swfobject)!="object"){
		$("head").append('<link rel="stylesheet" type="text/css" href="/gaochao/Public/Plugins/uploadify/uploadify.css" />');
		$("head").append('<script type="text/javascript" src="/gaochao/Public/Plugins/uploadify/jquery.uploadify.min.js"><\/script>');
	}
	</script>
	<?php
 }else{ ?>
	<script type="text/javascript">
	if(is_import==undefined){
		$("head").append('<link rel="stylesheet" type="text/css" href="/gaochao/Public/Plugins/uploadify/uploadify.css" />');
	}
	var is_import=true;
	</script>

	<div id="upload_picture_<?=$config['index']?>" class="upload-area html5_img <?=$btn_class?>" style="margin:0;">
		<label class="cnsr-button" onchange="fileSelected_<?=$config['index']?>(this)">
			<input type="file" multiple="true" name="download" class="file_btn" id="file_btn_<?=$config['index']?>" />
		</label>
		<?php
 if($config['multi']!="true"){ echo '<div class="upload-img-box clearfix" '.$is_show.'>'.$html.'</div>'; } ?>
		<div id="user_avatar-queue_<?=$config['index']?>" class="cnsr-queue"></div>
	</div>
	<?php
 } ?>
</div>
<?php
 if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 9.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6.0")){ $width=142; $height=142; ?>
<script type="text/javascript">
//上传图片
/* 初始化上传插件 */
$("#upload_picture_<?=$config['index']?>").uploadify({
	formData :{
		'<?=session_name()?>':'<?=session_id()?>'
	},
	'multi'        : <?=$config['multi']?>,//false表示关闭多文件上传，如果需要开启需要把值设置为true
	"height"          : <?=$height?>,
	"swf"             : "/gaochao/Public/Plugins/uploadify/uploadify.swf",
	"fileObjName"     : "download",
	"upload_type"     : "img",
	"buttonText"      : "",
	"uploader"        : "<?=U('uploadPicture',array('session_id'=>session_id()))?>",
	"width"           : <?=$width?>,
	'removeTimeout'	  : 1,
	'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
	"onUploadSuccess" : uploadPicture_<?=$config['index']?>,
	'onFallback' : function() {
		alert('未检测到兼容版本的Flash.');
	}
});
function uploadPicture_<?=$config['index']?>(file, data){
	var data = $.parseJSON(data);
	uploadPictureCallback_<?=$config['index']?>(data);
}
$("#upload_picture_<?=$config['index']?>").append('<div class="upload-img-box clearfix"><?=$html?></div>');
</script>
<?php
 }else{ ?>

<script>
var xhr_<?=$config['index']?> = new XMLHttpRequest();
//监听选择文件信息
var file_num_<?=$config['index']?>;
var file_length_<?=$config['index']?>;
function fileSelected_<?=$config['index']?>(){
	<?php
 if($config['max_num']!=''){ ?>
	var uploaded_file_num_<?=$config['index']?> = $("#upload_picture_<?=$config['index']?>").parent().find(".upload-pre-item").length;
	if(uploaded_file_num_<?=$config['index']?> > <?=$config['max_num']?>){
		return false;
	}
	<?php
 } ?>
	//HTML5文件API操作
	file_num_<?=$config['index']?>=0;
	file_length_<?=$config['index']?>=0;
	var file = document.getElementById('file_btn_<?=$config['index']?>').files[file_num_<?=$config['index']?>];
	file_length_<?=$config['index']?>=document.getElementById('file_btn_<?=$config['index']?>').files.length-1;
	if (file) {
		var fileSize = 0;
		if (file.size > 1024 * 1024){
		  fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
		  fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
		}
		$("#user_avatar-queue_<?=$config['index']?>").html('<div class="file_info clearfix"><span class="fileName">'+file.name+'('+fileSize+')</span><a class="cancel" href="javascript:cancleUploadFile_<?=$config['index']?>()">X</a></div><div class="progress"><div class="js_progress-bar progress-bar progress-bar-warning progress-bar-striped active" style="width:0%;"></div></div>').fadeIn();
		uploadFile_<?=$config['index']?>(file_num_<?=$config['index']?>);
	}
}

//上传文件
function uploadFile_<?=$config['index']?>(file_num_<?=$config['index']?>) {
	  var fd = new FormData();
	  //关联表单数据,可以是自定义参数
	  fd.append("name", $('#name_<?=$config['index']?>').val());
	  fd.append("download", document.getElementById('file_btn_<?=$config['index']?>').files[file_num_<?=$config['index']?>]);

	  //监听事件
	  xhr_<?=$config['index']?>.upload.addEventListener("progress", uploadProgress_<?=$config['index']?>, false);
	  xhr_<?=$config['index']?>.addEventListener("load", uploadComplete_<?=$config['index']?>, false);
	  xhr_<?=$config['index']?>.addEventListener("error", uploadFailed_<?=$config['index']?>, false);
	  xhr_<?=$config['index']?>.addEventListener("abort", uploadCanceled_<?=$config['index']?>, false);
	  //发送文件和表单自定义参数
	  xhr_<?=$config['index']?>.open("POST", "<?=U('uploadPicture',array('session_id'=>$config['index'].session_id()))?>");
	  xhr_<?=$config['index']?>.send(fd);
}
//取消上传
function cancleUploadFile_<?=$config['index']?>(){
	xhr_<?=$config['index']?>.abort();
	$("#user_avatar-queue_<?=$config['index']?>").fadeOut(function(){
		$(this).html("");
	})
}
//上传进度
function uploadProgress_<?=$config['index']?>(evt) {
	if (evt.lengthComputable) {
		var percentComplete = Math.round(evt.loaded * 100 / evt.total);
		$('.js_progress-bar').css({"width":percentComplete.toString()+'%'});
		if(percentComplete.toString()==100){
			setTimeout(function() {
				$("#user_avatar-queue_<?=$config['index']?>").fadeOut(function(){
					$(this).html("");
				})
			},500);
		}
	}
}
//上传成功响应
function uploadComplete_<?=$config['index']?>(evt){
	//服务断接收完文件返回的结果
	var data = $.parseJSON(evt.target.responseText);
	var result=uploadPictureCallback_<?=$config['index']?>(data);
	if(result==true && file_num_<?=$config['index']?><file_length_<?=$config['index']?>){

		<?php
 if($config['max_num']!=''){ ?>
		var uploaded_file_num_<?=$config['index']?> = $("#upload_picture_<?=$config['index']?>").parent().find(".upload-pre-item").length;
		if(uploaded_file_num_<?=$config['index']?> > <?=$config['max_num']?>){
			return false;
		}
		<?php
 } ?>
		file_num_<?=$config['index']?>++;
		uploadFile_<?=$config['index']?>(file_num_<?=$config['index']?>);
	}
}
//上传失败
function uploadFailed_<?=$config['index']?>(evt) {
	alert("上传失败");
}
//取消上传
function uploadCanceled_<?=$config['index']?>(evt) {
	alert("您取消了本次上传.");
}
</script>
<?php
 } ?>


<script type="text/javascript">
	function uploadPictureCallback_<?=$config['index']?>(data){
		var src = '';
		if(data.status){
			src = data.url || '/gaochao/' + data.save_path;
			var width=data.width;
			var height=data.height;
			if(width>140){
				var wscale=140/width;
				width=140;
				height=height*wscale;
			}
			if(height>140){
				var hscale=140/height;
				height=140;
				width=width*hscale;
			}
			var paddingTB=(140-height)/2;
			if(<?=$config['multi']?>){
				var index=$(".setCover").length+1;
				var html='<div class="upload-pre-item pull-left" style="padding-top:'+paddingTB+'px;padding-bottom:'+(paddingTB)+'px;"><input type="hidden" name="<?=$config['name']?>[]" value="'+data.id+'"/><img src="' + src + '" style="width:'+width+'px;height:'+height+'px;"/><div class="delThis" title="删除" index="'+data.id+'" onclick=\'delCache_<?=$config['index']?>(this,"'+data.id+'")\'></div></div>';
				$("#upload_picture_<?=$config['index']?>").before(html).parent().fadeIn();
			}else{
				var html='<div class="upload-pre-item" style="margin:0;padding-top:'+paddingTB+'px;padding-bottom:'+(paddingTB)+'px;"><input type="hidden" name="<?=$config['name']?>" value="'+data.id+'"/><img src="' + src + '" style="width:'+width+'px;height:'+height+'px;"/><div class="delThis" title="删除" index="'+data.id+'" onclick=\'delCache_<?=$config['index']?>(this,"'+data.id+'")\'></div></div>';
				$("#upload_picture_<?=$config['index']?>").find('.upload-img-box').html(html).fadeIn();
			}
			return true;
		}else{
			tips(data.info,1000);
			return false;
		}
	}

	//删除已经添加到数据库的图片
	function delThis_<?=$config['index']?>(obj){
		var image_id=$(obj).attr('index');
		if(confirm("确定删除吗？")){
			$.post('<?=U("ajaxDelete_".$config["table"])?>',{'image_id':image_id,'id':'<?=$id?>','name':'<?=$config[name]?>'},function(data){
				if(data.status==1){
					var objParent=$(obj).parent();
					objParent.remove();
					tips(data.info,1500,'success');
				}else{
					tips(data.info,1500,'error');
				}
			},'json');
		}
	}
	//删除临时上传的图片，也就是上传后还没有点击发布的图片
	function delCache_<?=$config['index']?>(obj){
		if(confirm("确定删除吗？")){
			<?php
 if($config['multi']!="true"){ ?>
				$('#file_btn_<?=$config['index']?>').val("");
			<?php
 } ?>
			var temp_id=$(obj).attr('index');
			$.post("<?=U('delTempFile')?>",{id:temp_id},function(data){
				if(data.status==1){
					var objParent=$(obj).parent();
					objParent.remove();
					tips(data.info,1500,'success');
				}else{
					tips(data.info,1500,'error');
				}
			})
		}
	}
</script>