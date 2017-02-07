<?php header("Access-Control-Allow-Origin: http://local.v1.hwrw.l.devhart.com"); ?>
<?php 
add_action("wp_ajax_wpDetails", "getWpDetails");
add_action("wp_ajax_nopriv_wpDetails", "getWpDetails");

function getWpDetails() {
  $code = 'Sa4sps8Urn2sD1Vw';
  
  if ($_GET['pid'] === $code) {
    $filename = "../wp-includes/version.php";
    $content = (string) file_get_contents($filename);
    $id = "wp_version = '";
    $versionStart = stripos($content, $id) + strlen($id);
    $versionEnd = stripos($content, "'", $versionStart);
    $version = substr($content, $versionStart, $versionEnd-$versionStart);
    
    $all_plugins = get_plugins();

    $upgrade_plugins = array();
	$current = get_site_transient( 'update_plugins' );
	foreach ( (array)$all_plugins as $plugin_file => $plugin_data) {
		if ( isset( $current->response[ $plugin_file ] ) ) {
			$upgrade_plugins[ $plugin_file ] = (object) $plugin_data;
			$upgrade_plugins[ $plugin_file ]->update = $current->response[ $plugin_file ];
		} 
	}

    $response = array();
    $response["last_updated"] = file_exists($filename) ? date("m/j/Y", filemtime($filename)) : "n/a";
    $response["version"] = $version;
    
    $response["plugins"] = array();
    foreach($all_plugins as $keyFile=>$pluginArr) {
      $response["plugins"][$keyFile] = array(
        "name" => $pluginArr["Name"],
        "version" => $pluginArr["Version"],
        "last_updated" => date("m/j/Y", filemtime("../wp-content/plugins/" . $keyFile)),
        "update_available" => false,
      );
    }
    
    foreach($upgrade_plugins as $keyFile=>$pluginObj) {
      $response["plugins"][$keyFile]["update_available"] = true;
      $response["plugins"][$keyFile]["new_version"] = $pluginObj->update->new_version;
    }
    
    echo json_encode($response);
  } else {
    echo '0';
  }
  wp_die();
}

function getPluginMeta($content, $meta) {
  $metaStart = stripos($content, $meta) + strlen($meta);
  $metaEnd = stripos($content, "\r\n", $metaStart);
  return trim(substr($content, $metaStart, $metaEnd-$metaStart));
}
?>