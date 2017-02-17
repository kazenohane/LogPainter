
<!DOCTYPE html>
<html lang="zh-CN">



<!--COC Log Painter @Fengyu-->
<!-- Version 2.1  01/31/2016 La>
<!-- Version 2.2  09/17/2016   >
<!-- Copyright 2017, hina.moe >
<!-- 

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->

<!-- 代码压缩懒得做了啊，写的乱糟糟的 =。= >

<head>
<!-- jQuery CDN-->
<script src="jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!-- bootstrap CDN-->

<script src="bootstrap.min.js"></script>
<!--  Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>

<style type="text/css">
body{
	background-color: #D1EAF7
	/*background-image: linear-gradient(90deg, #e3e1fc, #f6ffbe);*/
}
#div_page{
	margin:50px;
}
#div_names{
	margin-left:50px;
	margin-right:50px;
	margin-top:20px;
	margin-bottom:20px;
}
.button_player{
	width:100%;
	text-align:left;
}
#textarea_log_input{
	height:300px;
	text-align:left;
}
#div_log_output{
	float:left;
	width:100%;
}
#textarea_log_output{
	width:100%;
	height:300px;
}
#button_log_analyze, #button_log_command, #button_log_clear, #button_log_other, #button_log_pic_text{
	width:150px;
	height:50px;
}
#div_log_view{
	width:100%;
	height:300px;
	float:left;
	background-color: #D1EAF7
	overflow:auto;
}
.div_center{
	text-align:center;
}
.div_italic{
	font-style:italic;
}
#div_button{
	margin:10px;
}
h3{

}
li{
	border-radius:5px;
	width:50%;
	background-color: #f6ffbe;
}
.input_name{
	background:transparent;
	border:0px;
	height:34px;
}
</style>

<body>
<div id="div_page">
<div>
	<div class="div_center"><h3>QQ跑团记录着色器</h3><h5>v2.2 by 风羽</h5></div>
	<div class="div_italic">
	<a href="http://aligo.github.io/log-colourer.js">前辈的mirc版传送门</a>
	</div>
	<h5>将QQ聊天记录的【文本】复制到下面这个文本框中,然后点击按钮【Analyze】</h5>
	
</div>
<div>
	<textarea class="form-control" id ="textarea_log_input"></textarea>
</div>

<div id = "div_button" class="div_center">
	<div>
	<button  class="btn btn-info" id = "button_log_command">指令过滤 On</button>
	<button  class="btn btn-warning" id = "button_log_other">（开头内容过滤 On</button>
	<button  class="btn btn-info" id = "button_log_pic_text"> [图片]过滤 On</button>
	</div>
	<p></p>
	<div>
	<button  class="btn btn-success" id = "button_log_analyze">Analyze</button>
	<button  class="btn btn-info" id = "button_log_clear">清除输入</button>
	</div>
	
</div>
<br>
<div id="div_names">
</div>
<div  class="div_center"><a href="http://www.goddessfantasy.net/bbs/index.php?action=post;board=1209.0" target="_blank" >贴到风羽的果园版</a></div>
<div id="div_log">
<h5>复制预览部分内容可得TXT文本，输出部分为果园用代码</h5>

	 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#div_log_view" aria-controls="div_log_view" role="tab" data-toggle="tab">预览</a></li>
	<li role="presentation"><a href="#div_log_output" aria-controls="div_log_output" role="tab" data-toggle="tab">输出</a></li>
  </ul>
  <div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="div_log_view">
	</div>
	<div role="tabpanel" class="tab-pane fade" id="div_log_output">
		<textarea class="form-control" id ="textarea_log_output"></textarea>
	</div>
   </div>
   	
</div>	
</div>

<script id="html_player_grid" type="html/template">
	<div class="col-sm-2">
		<input type="text" class="font-control input_name" name="&id" value="&name" placeholder="删除消息请点右边开关">
	</div>
	<div class="col-sm-2">
		&select
	</div>
	<div class="col-sm-1">
		<button type ="button" class="btn btn-success button_player" name ="&id">On</button>
	</div>
		<div class="col-sm-1">
	</div>
 </script> 
 
<script type="text/javascript">

(function($, w, d){

	$(d).ready(function(){
		$("#div_log").hide();
		
		var input = "<?php
		$name = $_GET['log'];
		if($name != null){
			$filename = "logs/".$name;
			$fp=fopen($filename,"r");
			$str = fread($fp,filesize($filename));
			$str = str_replace("\r\n","\\r\\n",$str);
			echo($str);
		}
		?>";
		$("#textarea_log_input").val(input);
		if(input != ""){
			$("#button_log_analyze").click();
			$("html,body").animate({scrollTop: $("#div_names").offset().top}, 500);
		}
	});
	$("#button_log_command").click(function(){
		commandFilter = !commandFilter;
			if(!commandFilter){
				$(this).removeClass('btn-info');
				$(this).text('指令过滤 Off');
				$(this).addClass('btn-warning');
			}else{
				$(this).addClass('btn-info');
				$(this).text('指令过滤 On');
				$(this).removeClass('btn-warning');
			}
	});
	$("#button_log_other").click(function(){
		otherFilter = !otherFilter;
			if(!otherFilter){
				$(this).removeClass('btn-info');
				$(this).text('（开头内容过滤 Off');
				$(this).addClass('btn-warning');
			}else{
				$(this).addClass('btn-info');
				$(this).text('（开头内容过滤 On');
				$(this).removeClass('btn-warning');
			}
	});
	$("#button_log_pic_text").click(function(){
		picTextFilter = !picTextFilter;
			if(!picTextFilter){
				$(this).removeClass('btn-info');
				$(this).text('[图片]过滤 Off');
				$(this).addClass('btn-warning');
			}else{
				$(this).addClass('btn-info');
				$(this).text('[图片]过滤 On');
				$(this).removeClass('btn-warning');
			}
	});	
	$("#button_log_clear").click(function(){
		$("#textarea_log_input").val("");
	});
	$("#textarea_log_output").click(function(){ 
		$(this).select();
	});
	

//Closure Variables
	
	//Player Index
	var nameList =[];	
	//Log Lines
	var logList = [];

//Configuration
	
	//Color Index
	var colorList = "red;green;pink;orange;purple;black;blue;yellow;beige;brown;teal;navy;maroon;limegreen;white;fuchsia".split(';');
	var colorNameList = "红色;绿色;粉红;橘色;紫色;黑色;蓝色;黄色;米色;棕色;蓝绿;深蓝;紫红;莱姆;白色;桃红".split(';');
	//Default color of time
	var timeColor = "silver"; 
	var commandFilter = true;
	var otherFilter = true;
	var picTextFilter = true;
	//TODO_IF_NEEDED it can be extended to more colors a player so that name and content can be seperated clearly
	function Player(name, colorIndex){
		this.name = name;
		this.color = colorList[colorIndex];
		this.valid = true;
	}
	function Line(time, player, content){
		this.time = time;
		this.player = player;
		this.content = content;
	}
	function getPlayer(name){
		for(var j=0;j<nameList.length;j++){
			if(nameList[j].name == name){
				return nameList[j];
			}
		}
		return null;
	}

	function getSelectsHTML(id){
		var selectID = "select_"+id;
		var html = "";
		html += '<select name ="' + id + '" id ="' + selectID + '" class="form-control">';
		for(var i=0;i<colorNameList.length;i++){
			html += '<option value="'+colorList[i]+'" style="background-color:'+colorList[i]+';">'+colorNameList[i] + '</option>';
		}
		html += '</select>';
		return html;
	}
	//deprecated
	function getButtonHTML(id){
		var html ="";
		html += '<button type ="button" class="btn btn-success" id ="' + id + '">' + "On" + '</button>'; 
		return html;
	}
	
	function packageGrid(html, i){
		return '<div class="col-sm-'+ i.toString()+'">' + html + '</div>';		
	}
	function getPlayerCell(id, name){
		var html = "";
		/*
		var selectID = "option_"+name;
		var buttonID = "button_"+name;
		var labelHTML = '<label>' + name +'</label>';
		html += packageGrid(labelHTML,1);
		html += packageGrid(getSelectsHTML(selectID),3);
		html += packageGrid(getButtonHTML(buttonID),2);
		*/
		//Using template
		var selectedColor = nameList[id].color; 
		html = $("#html_player_grid").html().replace(/&name/g, name)
				.replace(/&id/g, id).replace('&select',getSelectsHTML(id));
		
		return html;
	}
	function getPlayerGrids(){
		//2 players 1 line
		var html = '<div class="div_center div_italic" style="color:red"><p>出现的PC名字 (点击可以修改)</p><br></div>';
		
		for(var i=0;i<nameList.length;i++){
			if( i % 2 == 0){
				html += '<div class="row">';
			}
			html += getPlayerCell(i, nameList[i].name);
			if( i % 2 == 1){
				html += '</div>';
			}
		}
		if( i % 2 == 0){
				html += '</div>';
		}
			
		$("#div_names").html(html);
		
		
		$("select").change(function() {
			var color = $(this).val();
			var id = parseInt($(this).attr("name"));
			$(this).css("background-color",color);
			changeColor(id,color);
		});

		$("input").change(function() {
			var newName = $(this).val();
			var id = parseInt($(this).attr("name"));
			nameList[id].name = newName;
			paintLog();	
		});
		
		$(".button_player").click(function() { 
			var id = parseInt($(this).attr("name"));
			var switchNow = changeSwitch(id);
			if(!switchNow){
				$(this).removeClass('btn-success');
				$(this).text('Off');
				$(this).addClass('btn-default');
			}else{
				$(this).addClass('btn-success');
				$(this).text('On');
				$(this).removeClass('btn-default');
			}
		});
		//Update select s' colors
		selectInit();
	}
	function selectInit(){
		for(var i=0;i<nameList.length;i++){
			var selectID = "#select_"+i;
			color = nameList[i].color;
			$(selectID).val(color);
			$(selectID).css("background-color",color);
		}
	}
	function changeSwitch(playerID){
		nameList[playerID].valid = !nameList[playerID].valid;
		paintLog();	
		return nameList[playerID].valid;
	}
	
	function changeColor(playerID, color){
		nameList[playerID].color = color;
		//Update it
		if(nameList[playerID].valid){
			paintLog();
		}
	}
  
	var regLetter = /^[a-zA-Z].*/;
		
	function parseInput(){
		//Initialize
		parsedLines =[];
		nameList = [];
		logList =[];
		$("#div_names").html("");
		$("#div_log").hide();
			
		var data = $("#textarea_log_input").val();
		var regHeader = /\d{4}-\d{2}-\d{2} (\d{1,2}:\d{2}:\d{2}) (AM|PM)? ?([^\(]*)/;// 2016-01-03 \d{2}:\d{2}:\d{2}/g name
		var regHeader2 = /(.*?)(\([0-9]+\))? +(\d{1,2}:\d{2}:\d{2}).*/;// \d{2}:\d{2}:\d{2}/
		var regDiscard = /^(\.r|\.R|\/me|\.help|\.ww|。r|。R|、me|。ww).*/;
		var regOther = /^(\(|（).*/;
		var regPicText = /\[图片\]/;
		var lines = data.split("\n");
		var name = "";
		var time = "";
		var colorIndex = 0;
		var player = "";
		for(var i = 0;i < lines.length; i++){
			if(lines[i].length == 0){continue;}
			//Recognize message header
			var res = lines[i].match(regHeader);
			var res2 = lines[i].match(regHeader2);
			
			//Deal with new name
			
			if(res != null || res2 != null){
				if(res != null){
					name = res[3].trim();
					time = res[1];
				}else if(res2 != null){
					name = res2[1].trim();
					time = res2[3];
				}
				if(name != "" && name != "系统消息"){
					var exist = false;
					for(var j=0;j<nameList.length;j++){
						if(nameList[j].name == name){
							exist = true;
							break;
						}
					}
					if(exist == false){
					
						nameList[nameList.length] = new Player(name, colorIndex);
						colorIndex ++;
					}
				}
				
			}else{
				if(name == ""){continue;}//Discard messages that come without headers
				if(name == "系统消息"){continue;}
				//Discard 系统消息
				
				//Deal with message content
				if(commandFilter){
					var discard = lines[i].match(regDiscard);
					if(discard != null){
						continue;
					}
				}
				
				if(otherFilter){
					var other = lines[i].match(regOther);
					if(other != null){
						continue;
					}
				}
				
				if(picTextFilter){
					lines[i] = lines[i].replace(regPicText,"");
					if(lines[i].length == 0){continue;}
				}
				
				
				//Fix time length to 8
				if(time.length != 8){time = ' '+time; }
				
				var log = new Line(time,getPlayer(name),lines[i]);
				logList[logList.length] = log;
			}
		}
		
		return nameList.length;
	}
	
	function paintLog(){
		var output = "";
		var outputHTML = "";

		for(var i = 0;i < logList.length; i++){
			//Skip invalid names
			if(logList[i].player.valid == false){continue;}
			
			var playerColor = logList[i].player.color;
			
			//HTML中 <a>会被默认为tag
			var name = logList[i].player.name;
			var resLetter = name.match(regLetter);
			if(resLetter){name = ' '+name;}
			
			output += ("[color="+timeColor+"]"+logList[i].time+"[/color] ");
			output += ("[color="+playerColor+"]"+"<"+logList[i].player.name+"> ");
			output += logList[i].content;
			output += "[/color]\n";
			
			outputHTML += ("<span style=\"color:"+timeColor+";\">"+logList[i].time+"</span> ");
			outputHTML += ("<span style=\"color:"+playerColor+";\">"+"<"+name+"> ");
			outputHTML += logList[i].content;
			outputHTML += "</span><br>";
		}
		
		$("#textarea_log_output").val(output);
		
		$("#div_log_view").html(outputHTML);
	}
	
	$("#button_log_analyze").click(function (e) {
		var playersNum = parseInput();
		
		if(playersNum > 0){
			getPlayerGrids();
			
			paintLog();
			
			$("#div_log").show();
		}else{
			$("#div_names").html('<div class="div_center div_italic" style="color:red"><p>无法识别聊天记录文本，请确认</p><p>使用咨询请加群 522107138</p></div>');
		}
	})
}(jQuery, window, document));

</script>
</body>
<!--COC Log Painter @Fengyu-->
</html>