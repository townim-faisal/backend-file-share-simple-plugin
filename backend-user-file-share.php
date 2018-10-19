<?php

/**
 * Plugin Name: Backend User File Share
 * Plugin URI: 
 * Description: This plugin enables a functionality so that admin can share files with all the users in backend.
 * Version: 1.0
 * Author: Townim Faisal
 * Author URI: 
 * License: GPL2
 */

add_action( 'wp_head', 'backend_user_file_share' );
add_action( 'admin_menu', 'backend_user_file_share_menu' );

function backend_user_file_share() {

}


function backend_user_file_share_menu() {
	add_menu_page( 'Backend User File Share', 'Manage Backend User Files', 'read', 'backend-user-file-share-manage-files', 'backend_user_file_share_manage_files' );
	add_submenu_page( 'backend-user-file-share-manage-files', 'Upload Files', 'Upload Files', 'manage_options', 'backend-user-file-share-upload-files', 'backend_user_file_share_upload' );
}

function backend_user_file_share_manage_files() {

	if( is_super_admin() && isset($_GET['delete']) ) {
		if( unlink( plugin_dir_path( __FILE__ ).'uploads/' . $_GET['delete'] ) ) {
			echo $_GET['delete'] . ' deleted successfully.';
		} else {
			echo 'Could not delete ' . $_GET['delete'] . '. Something went wrong!';
		}
	}

	include('admin/backend-user-file-share-admin.php');
}

function backend_user_file_share_upload() {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$target_dir = plugin_dir_path( __FILE__ ).'uploads/';
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}

	}
?>
	<h3>Add File</h3>
	<form action="admin.php?page=backend-user-file-share-upload-files" method="post" enctype="multipart/form-data">
		Select file to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload" name="submit">
	</form>
<?php
}

?>