<?php

function listdir_by_date($path){
    $dir = opendir($path);
    $list = array();
    while($file = readdir($dir)){
        if ($file != '.' and $file != '..'){
            // add the filename, to be sure not to
            // overwrite a array key
            $ctime = filectime($path . $file) . ',' . $file;
            $list[$ctime] = $file;
        }
    }
    closedir($dir);
    krsort($list);
    return $list;
}

?>

<div class="wrap">
	<h2>Backend User File Share</h2>
	<h3>Manage Files</h3>
<?php
	$files = listdir_by_date( plugin_dir_path( __FILE__ ).'../uploads/' );

	if ( sizeof($files) == 0 ) {
		echo "<b>No file is added yet!</b>";
	} else {
	
		echo '<table border=1 cellpadding=10 cellspacing=0 width=100%>
				<tr>
					<th>File Name</th>
					<th>Date</th>
				</tr>';
		foreach ($files as $key => $value) {
			$token = explode(',', $key);
			$utime = $token[0];

			echo '<tr>';
			echo '<td>
					<a href="'. plugin_dir_url( __FILE__ ).'../uploads/' . $value .'">' . $value . '</a>';
			
			if ( is_super_admin() ) {
				echo ' [ <small><a href="admin.php?page=backend-user-file-share-manage-files&delete=' . $value . '"">Delete</a></small> ]';
			}

			echo '</td>';
			echo '<td>' . date("F d Y H:i:s.", $utime) . '</td>';
			echo '</tr>';
		}
		echo '</table>';

	}
?>
</div>