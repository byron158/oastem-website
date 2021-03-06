<?php
require_once('../google_common.php');
require_once('../config.php');


if(isset($_GET['list'])){
	$drive = getDriveService();
	$folders = array();
	foreach(listFileIdInFolder($drive,$MEDIA_FOLDER_ID) as $item){
		$data = $drive->files->get($item);
		if($data->getMimeType() == 'application/vnd.google-apps.folder'){
			array_push($folders,$data->getId());
		}
	}
	echo json_encode($folders);
}elseif(isset($_GET['get'])){
	if(isset($_POST['fid'])){
		$drive = getDriveService();
		$fid = $_POST['fid'];
		
		foreach(listFileIdInFolder($drive,$fid) as $item){
			$data = $drive->files->get($item);
			$con = str_replace("&export=download","",$data->getWebContentLink());
			if(startsWith($data->getMimeType(),'image/')){
				echo "<a href='$con' target='_blank'><div class='m-img' style=\"background-image:url('" . $data->getThumbnailLink() ."')\">
				</div></a>";
				
			}
		}

	}else{
		echo 'error';
	}
}

?>