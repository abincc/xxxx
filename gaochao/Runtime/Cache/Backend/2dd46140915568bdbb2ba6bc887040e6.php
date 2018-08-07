<?php if (!defined('THINK_PATH')) exit(); $cur_path=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME; $menu_info['path'] = ''; $menu_list = get_menu_list (); foreach ( $menu_list as $key => $value ) { if ($cur_path == $value ['url']) { $menu_info = $value; } } $menu_path = explode("-",$menu_info['path']); $menu_1 = array(); $menu_2 = array(); $menu_3 = array(); foreach($menu_result as $row_1){ if(!$row_1["child"]) continue; $first = array_slice($row_1["child"],0,1); $second = array_slice($first[0]["child"],0,1); $row_1['data']['url'] = $second[0]['data']['url']; if($row_1['data']['id']==$menu_path[2]){ $row_1['data']['class'] = "cur"; foreach($row_1['child'] as $row_2){ $third = array_slice($row_2["child"],0,1); $row_2['data']['url'] = $third[0]['data']['url']; if($row_2['data']['id']==$menu_path[3]){ $row_2['data']['class'] = "active"; foreach($row_2['child'] as $row_3){ $row_3['data']['class'] = ''; $fourth = array_slice($row_3,0,1); if($fourth['data']['id']==$menu_path[4]){ $row_3['data']['class'] = 'active'; } $menu_3[] = $row_3['data']; } } if($row_2['data']['url']){ $menu_2[] = $row_2['data']; } } } if($row_1['data']['url']){ $menu_1[] = $row_1['data']; } } ?>
<!DOCTYPE html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?php
 if(!empty($seo['title'])){ $seo['title'] = $seo['title'].' | '.C('SITE_TITLE'); }else{ $seo['title'] = C('SITE_TITLE'); } if(empty($seo['keywords'])){ $seo['keywords']=C('SITE_KEYWORD'); } if(empty($seo['description'])){ $seo['description']=C('SITE_DESCRIPTION'); } $member_info=session("member_info"); ?>
<title><?=$seo['title']?></title>
<meta name="keywords" content="<?=$seo['keywords']?>" />
<meta name="description" content="<?=$seo['description']?>" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
var _ROOT_='/gaochao';
var _STATIC_='/gaochao/Public/Static';
var _PLUGIN_='/gaochao/Public/Plugins';
var _JS_='/gaochao/Public/Backend/js';
var _IMG_='/gaochao/Public/Backend/img';
var _CSS_='/gaochao/Public/Backend/css';
</script>
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Static/css/common.css?1518508939" />
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Plugins/select2/select2.css?1518509003" />
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Backend/css/admin.min.css?1518508931" />
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Backend/css/backend.css?1518508931" />

<script type="text/javascript" src="/gaochao/Public/Static/js/common.js?1518508939"></script>
<script type="text/javascript" src="/gaochao/Public/Backend/js/common.js?1518508938"></script>
<!--[if lt IE 9]>
  <script type="text/javascript" src="/gaochao/Public/Static/js/ie9.js?1518508939"></script>
<![endif]-->
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Static/css/ie6.css?1518508939" />
<script type="text/javascript" src="/gaochao/Public/Static/js/ie6.js?1518508939"></script>
<![endif]-->


</head>
<body class="skin-gray">
	<header class="main-header">
	<a href="<?=U('/Backend')?>" class="logo">
		<span class="logo-mini"><b>尚软</b></span>
		<span class="logo-lg"> <i>CNSunRun</i>
	</span>
	</a>

	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle topbar-toggle js_collapse" data-toggle="collapse" data-target=".nav_box" role="button"><img src="/gaochao/Public/Backend/img/main_menu.png" alt=""></a>
		<div class="nav_box">
			<?php
 foreach($menu_1 as $row){ ?>
			<a href="<?=U($row['url'])?>" class="<?=$row['class']?>">
				<?=$row['title']?>
			</a>
			<?php
 } ?>
		</div>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
<!-- 				<li>
					<a href="javascript:void(0)" class="message js_message_btn">
						<img src="/gaochao/Public/Backend/img/alarm.png" alt=""><div class="message_num js_message_num">10</div>
					</a>
					<div class="message_box treeview-menu js_message_box">
						<div class="header text-center">你有 <span class="js_message_num">10</span> 个待查看消息</div>
						<ul class="message_list">
							<li>
								<a href="#">
									<h6>新检测任务通知<small>5 分钟前</small></h6>
								</a>
							</li>
							<li>
								<a href="#">
									<h6>检测异常通知<small>5 分钟前</small></h6>
								</a>
							</li>
							<li>
								<a href="#">
									<h6>新采样任务通知<small>5 分钟前</small></h6>
								</a>
							</li>
			            </ul>
			            <div class="footer"><a href="#">查看所有消息</a></div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0)" class="message js_message_btn">
						<img src="/gaochao/Public/Backend/img/email.png" alt=""><div class="message_num js_message_num">10</div>
					</a>
					<div class="message_box treeview-menu js_message_box">
						<div class="header text-center">你有 <span class="js_message_num">10</span> 个待查看消息</div>
						<ul class="message_list">
							<li>
								<a href="#">
									<h6>新检测任务通知<small>5 分钟前</small></h6>
								</a>
							</li>
							<li>
								<a href="#">
									<h6>检测异常通知<small>5 分钟前</small></h6>
								</a>
							</li>
							<li>
								<a href="#">
									<h6>新采样任务通知<small>5 分钟前</small></h6>
								</a>
							</li>
			            </ul>
			            <div class="footer"><a href="#">查看所有消息</a></div>
					</div>
				</li> -->
				<li><a href="/gaochao/">查看首页</a></li>
				<li><a href="<?=U('Backend/Base/Public/logout')?>" class="ajax-get">退出登录</a></li>
			</ul>
		</div>
	</nav>
</header>
<div class="message_bg js_message_bg"></div>
	<aside class="main-sidebar">
	<section class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="sidebar_top clearfix">
			<a href="<?=U('Backend/Base/Info/edit')?>" class="image">
				<img src="/gaochao/Public/Backend/img/login_logo.png" alt="<?=session('username')?>的头像" />
				<div><?=session('username')?></div>
			</a>
		</div>
		<ul class="sidebar-menu">
			<?php
 foreach($menu_2 as $row){ ?>
			<li class="menu">
				<a class="<?=$row['class']?>" href="<?=U($row['url'])?>"><?=$row['title']?></a>
			</li>
			<?php
 } ?>
			<li style="display:none;">
				<a href="<?=U('Backend/Demo/Index/index')?>">列表</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'form'))?>">表单</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'form_tab'))?>">表单带选项卡</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'editor'))?>">编辑器调用</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'dialog'))?>">弹窗</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'file'))?>">文件上传</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'down'))?>">下载</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'imgDel'))?>">图片删除</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'tips'))?>">提示</a>
				<a href="<?=U('Backend/Demo/Index/index',array('tpl'=>'timeline'))?>">时间轴</a>
			</li>
		</ul>
	</section>
	<footer class="main-footer clearfix">
		<div>版权所有 &copy; 2015-<?=date("Y")?></div>
		<div><a href="http://www.cnsunrun.com" target="_blank">武汉尚软科技</a></div>
	</footer>
</aside>
	<div class="wrapper">
		<div class="content-wrapper js_content_wrapper">
			<div class="breadcrumb_box">
				<section class="top_menu">
					<ul class="nav nav-tabs">
					<li class="side_menu"><a href="javascript:void(0);" class="sidebar-toggle js_offcanvas"><img src="/gaochao/Public/Backend/img/side_menu.png"></a></li>
					<?php
 $small_tips = ''; foreach($menu_3 as $row){ if($menu_info['id']==$row['id'] || $row['id'] == $menu_path[3]){ $row['class'] = 'active'; $small_title=$row['title']; $small_tips = str_replace("\n",'</br>',$row['description']); } ?>
						<li class="js_tab <?=$row['class']?>"><a href="<?=U($row['url'])?>"><?=$row['title']?></a></li>
					<?php
 } ?>

					<?php
 if($small_tips){ ?>
						<!-- 问号 -S -->
						<li class="pull-right">
							<a href="javascript:void(0)" class="tip_msg_box js_tip_msg_box">
								<img src="/gaochao/Public/Backend/img/tip.png" alt="">
								<div class="tip_msg_up js_tip_msg_up"></div>
							</a>
						</li>
						<!-- 问号 -E -->
					<?php
 } ?>
					</ul>

				</section>
				<!-- 问号 -S -->
				<div class="tip_msg js_tip_msg">
					<h6>提示</h6>
					<?=$small_tips?>
					<div class="colse_dialog js_colse_dialog"></div>
				</div>
				<!-- 问号 -E -->
			</div>
			<section class="content">
				
    <div class="box box-body">
        <form action="" method="post" class="js_form">
            <input type="hidden" name="ids" value="<?=$info['id']?>" />
            <input type="hidden" name="buildings" id="building_ids" value="<?=$info['building_no']?>" />
            <input type="hidden" name="rooms" id="room_ids" value="<?=$info['room_no']?>" />
            <?php
 if(!$info['district_id']){ ?>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    选择小区
                </div>
                <div>
                <select name="district_id" class="form-control input-md super_select2 width_auto" data-placeholder="请选择小区">
                    <option value="">请选择小区</option>
                    <?=$district?>
                </select>
                </div>
            </div>
            <?php }else{?>
            <div class="form-group">
                <div class="control-label">
                    <h5><?=$info['district_title']?></h5>
                </div>
            </div>
            <?php
 } ?>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    小区楼栋
                </div>
                <div>
                    <span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 300px;">
                        <span class="selection">
                               <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                    <ul class="select2-selection__rendered" id="building_ul">
                                        <!-- <span class="select2-selection__clear">×</span> -->
                                        <li class="select2-search select2-search--inline" value="text"><input class="select2-search__field" id="building_id"  type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 2.75em;"></li>
                                    </ul>
                                </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    小区房号
                </div>
                <div>
                    <span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 300px;">
                        <span class="selection">
                               <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                    <ul class="select2-selection__rendered" id="room_ul">
                                        <!-- <span class="select2-selection__clear">×</span>    -->
                                        <li class="select2-search select2-search--inline" value="text"><input class="select2-search__field" id="room_id"  type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 2.75em;"></li>
                                    </ul>
                                </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </span>
                </div>

            </div>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    议事名称
                </div>
                <div>
                    <input type="text" class="form-control width_auto" name="title" value="<?=$info['title']?>" datatype="*1-20" nullmsg="请输入名称" errormsg="请输入名称" />
                    <span class="Validform_checktip">1-20个字符</span>
                </div>
            </div>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    描述
                </div>
                <div>
                    <textarea class="form-control"  name="description" datatype="*1-200" errormsg="请输入描述"><?=$info['description']?></textarea>
                    <span class="Validform_checktip">1~255字符以内</span>
                </div>
            </div>
            <div class="form-group">
                <div class="control-label">
                    <span class="required">*</span>
                    图片
                </div>
                <div>
                    <?php
 $config = array( 'index' => 1, 'table' => 'procedure_image', 'table_id' => 'pid', 'name' => 'image', 'multi' => 'true', 'val_key' => 'image' ); echo W('Common/Img/index', array($config, $info['id'])); ?>
                    <span class="Validform_checktip">注意图片尺寸：</span>
                </div>
            </div>

            <div class="form-group">
                <div class="control-label"><span class="required">*</span>投票截止时间</div>
                <div class="form-inline">
                <input id="d4312" class="form-control input-sm wdate" type="text" name="end_date" onclick="WdatePicker({})" value="<?=$info['end_date']?>" />
                </div>
            </div>

            <div class="form-group">
                <div class="control-label">
                    排序
                </div>
                <div>
                    <input type="text" class="form-control width_auto" name="sort" value="<?=$info['sort']?>" />
                    <span class="Validform_checktip">可空，正整数</span>
                </div>
            </div>          
            
            <div class="form-btn clearfix">
                <input type="submit" class="pull-left btn btn-primary" value="提交" />
                <a href="<?=U('index')?>" class="pull-left btn btn-default">取消并返回</a>
                <div class="js_validTips pull-left" style="height:34px;line-height:34px;">
                    <span class="js_tipContent Validform_checktip"></span>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="/gaochao/Public/Plugins/select2/select2.full.js?1518509003"></script>
    <script type="text/javascript" src="/gaochao/Public/Plugins/select2/super_select2.js?1518509003"></script>
    <script type="text/javascript">
        $(function(){
            $('.super_select2').super_select2();
        });
    </script>  
    <script type="text/javascript">
        var array1 = new Array();
        var array2 = new Array();
        var i = 0;
        var j = 0;
        $(function(){

            var building_ids = $("#building_ids").val();
            var room_ids = $("#room_ids").val();
            if(building_ids.split(',')[0] != null && building_ids.split(',')[0] != ''){
                array2 = building_ids.split(',');
            }

            if(room_ids.split(',')[0] != null && room_ids.split(',')[0] != ''){
                array1 = room_ids.split(',');
            }
            // array2 = building_ids.split(',');
            // array1 = room_ids.split(',');

            if(array2.length > 0){
                array2.forEach(function(e){  
                    $("#building_ul").append(" <li id="+ e +" class='select2-selection__choice' value="+ e +" title='融城'><span class='select2-selection__choice__remove'  role='presentation'></span> "+ e + "</li>");
                });
            }
            if(array1.length > 0){
                array1.forEach(function(e){  
                     $("#room_ul").append(" <li id="+ e +" class='select2-selection__choice' value="+ e +" title='融城'><span class='select2-selection__choice__remove' role='presentation'></span> "+ e + "</li>");
                });
            }

            i = i + array1.length;
            j = j + array2.length; 

            //----------------------------------//

            function removeByValue(arr, val) {  
              for(var i=0; i<arr.length; i++) {  
                if(arr[i] == val) {  
                  arr.splice(i, 1);  
                  break;  
                }  
              }  
            }


            //---------------------------------//


            //---------------------------------//

            $("#building_id").keydown(function (e) {
              var curKey = e.which;
              if (curKey == 13) {
                if(j <= 9){
                    $("#building_ul").append(" <li id="+ $("#building_id").val() +" class='select2-selection__choice' value="+ $("#building_id").val() +" title='融城'><span class='select2-selection__choice__remove'  role='presentation'></span> "+ $("#building_id").val() + "</li>");
                     array2[j] = $("#building_id").val();
                    // $("room_ids").value(array);
                    j = j + 1;
                }
                $("#building_ids").val(array2);


            //     $("#building_ul li").on("click",function(){   //核心代码
            //     　　var a=$(this).attr("value");    //获取每个li的value值
            //         if(a != "text"){
            //            $("#"+a).remove();
            //            removeByValue(array2, a);
            //            $("#building_ids").val(array2);
            //         }
            // 　　});
              }
            });

            $("#room_id").keydown(function (e) {
              var curKey = e.which;
              if (curKey == 13) {
                if(i <= 9){
                    $("#room_ul").append(" <li id="+ $("#room_id").val() +" class='select2-selection__choice' value="+ $("#room_id").val() +" title='融城'><span class='select2-selection__choice__remove' role='presentation'></span> "+ $("#room_id").val() + "</li>");
                    array1[i] = $("#room_id").val();
                    // $("room_ids").value(array);
                    i = i + 1;
                }
                $("#room_ids").val(array1);

            //     $("#room_ul li").on("click",function(){   //核心代码
            //     　　var a=$(this).attr("value");    //获取每个li的value值
            //         if(a != "text"){
            //            $("#"+a).remove();
            //            removeByValue(array1, a);
            //            $("#room_ids").val(array1);
            //         }
            // 　　});

              }
            });
        });
    </script>

			</section>
		</div>
		<!-- Main Footer -->
<?php  ?>

		
	</div>
	<!-- 图片弹出框 S -->
<div class="image_dialog">
	<img src=""  style="max-width:100%;" />
</div>
<div class="bg_image_shadow">
	
</div>

<script>
	$(function(){
		var winW = $(window).width();
		var winH = $(window).height();
		$('.image_dialog').css({'max-width':winW*0.8+'px'});

		$('.bg_image_shadow').on('click',function(){
			$('.image_dialog').css({'visibility':'hidden'});
			$('.bg_image_shadow').css({'visibility':'hidden'});
		});
	});
</script>
<!-- 图片弹出框 E -->
</body>
<script type="text/javascript" src="/gaochao/Public/Plugins/select2/select2.full.js?1518509003"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/select2/i18n/zh-CN.js?1518509003"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/select2/super_select2.js?1518509003"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/super_level/conf/area_data.js?1518508999"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/super_level/conf/select.js?1518508999"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/super_level/super_tree.js?1518508999"></script>
<script type="text/javascript" src="/gaochao/Public/Plugins/super_level/super_level.js?1518508999"></script>
<script>
$(function(){
	if($('.js_super_level').size()){
		new Super_level(area_data,'select',{set_super: {type: 'area',$obj: $('.js_super_level')}});
	}
	if($('.js_super_select2').size()){
		$('.js_super_select2').super_select2();
	}
	
});
</script>
</html>