<!DOCTYPE html>
<html5>
<head>

<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE10">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>个人文件上传系统</title>
<!-- <link href="./static/bootstrap/post_file.css" rel="stylesheet"> -->
<link href="../static/bootstrap/bootstrap.css" rel="stylesheet">
<link href="../static/bootstrap/body.css" rel="stylesheet">
<script type="text/javascript" src="../static/js/jquery.js"></script>

</head>

<body>
	
<div id="fbody"><div class="container"><br><div id="ai_list" class="span12">
	
	<div class="span8 div_left" style="min-height:400px;">
		<div class="alert alert-warning">
			<p>Version:</p>
			<p>1.2: (2014/9/19)
				支持多文件上传。下一版本添加上传的文件预览（图片）。
			</p>
		</div>
		
	</div>
			
	<div class="span4 pull-right"><br>
	<?php 
		if (isset($_POST['submit'])){
			$uploaddir = "D:/Program Files (x86)/xampp/htdocs/my_use/upload/"; //设置文件保存目录 注意包含/    
			//$type=array("txt");//设置允许上传文件的类型   
			//$patch="http://127.0.0.1/cr_downloadphp/upload/files/";//程序所在路径
			$repeat = 0; $succeed = 0; $failed = 0; $total = 0;  //统计上传情况
			//创建一个二维数组将$_FILES数组中的值换一个结构存储，方便一个一个文件上传
			$files = Array();
			$tmp = Array('name' => "",'type' => "",'size' => "",'error' => "",'tmp_name' => "");
			$files[] = $tmp;
			//$_FILES结构转换
			foreach($_FILES['_file']['name'] as $tmpname){
				$files[$total]['name'] = $tmpname;
				$files[$total]['type'] = $_FILES['_file']['type'][$total];
				$files[$total]['size'] = $_FILES['_file']['size'][$total];
				$files[$total]['error'] = $_FILES['_file']['error'][$total];
				$files[$total]['tmp_name'] = $_FILES['_file']['tmp_name'][$total];
				$total++;
			}
			//逐个上传
			for($i = 0; $i < $total; $i++){
				$filename=$files[$i]['name']; 
				$filetype=$files[$i]["type"];
				$filesize=$files[$i]["size"];
				//$md5_filename = md5(substr($filename,0,strlen($filename)-4).time()).".txt";
				$md5_filename = $filename;
				//文件类型 大小
				//if ($filetype != "text/plain" || $filesize>2000000){
				//	echo "<script>alert('只能上传txt文件且不大于2M！');</script>";
				//}else
				//文件数量多，重复就跳过
				if (file_exists($uploaddir.$md5_filename)){
					$repeat++;
					//echo "<script>alert('file already exists!');</script>";						
				}else{				
					$upstatus = move_uploaded_file(
						$files[$i]["tmp_name"],
						$uploaddir.$md5_filename
					);
					if ($upstatus != false){
						$succeed++;
						//echo "<script>alert('upload succeed!');</script>";
					}else{
						$failed++;
						//echo "<script>alert('upload failed!');</scirpt>";
					}
				}
			}
			echo "<script> alert('total:".$total.",succeed:".$succeed.",repeat:".$repeat.",failed:".$failed."'); location.href='upload.php';</script>";
		}
	?>	
		<script>
			//展示选中的文件
			function displayfiles(){
				var files = document.getElementById("_file[]").files;
				var display = "";
				var n = files.length;
				for(var i=0; i<n; i++) display += files[i].name + "<br>";
				document.getElementById("disfiles").innerHTML = display;
			}
		</script>
		<form action="" method="post" enctype="multipart/form-data">	
			<div id="file">
				<input type="file" multiple name="_file[]" id="_file[]" onchange="displayfiles()"/>
				<center><input class="btn btn-primary" style="margin-top:10px;"type="submit" name="submit" value="Submit"  /></center>
			</div>
		</form>
		<div id="disfiles">
		</div>
				
	</div>	
</div></div></div>

</body>
</html5>
