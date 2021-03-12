<?php 
	if(empty($_POST)){
		$envPath = realpath(__DIR__ . '/../../') . '/.env';
		if(file_exists($envPath)){
			die("Installation already done");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Doing some pre-installation checkup...</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
  	<div class="container">
  		<br/>
  		<div class="jumbotron">
  		
		<center>
			<h2>Doing some pre-installation checkup...</h2><br/>
		</center>

	<?php
		$all_ok = true;
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if (strpos($actual_link, 'install/index.php') !== false) {
      		$install_link = str_replace("install/index.php", "install-start", $actual_link);
    	} else {
      		$install_link = str_replace("install/", "install-start", $actual_link);
    	}
    	
		//Check for php version
		$checks = array();
        $checks['php'] = (PHP_MAJOR_VERSION >= 7 && PHP_MINOR_VERSION >=1) ? true : false;
        $checks['php_version'] = PHP_VERSION;

        //Check for php extensions
        $checks['openssl'] = extension_loaded('openssl') ? true : false;
        $checks['pdo'] = extension_loaded('pdo') ? true : false;
        $checks['mbstring'] = extension_loaded('mbstring') ? true : false;
        $checks['tokenizer'] = extension_loaded('tokenizer') ? true : false;
        $checks['xml'] = extension_loaded('xml') ? true : false;
        $checks['curl'] = extension_loaded('curl') ? true : false;
        $checks['zip'] = extension_loaded('zip') ? true : false;
        $checks['gd'] = extension_loaded('gd') ? true : false;
	?>

	<div>
	<table class="table">

		<tr>
            <td>PHP >= 7.1</td>
            <td>
            	<?php
					if($checks['php']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>OpenSSL PHP Extension</td>
            <td>
            	<?php
					if($checks['openssl']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>PDO PHP Extension</td>
            <td>
            	<?php
					if($checks['pdo']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>Mbstring PHP Extension</td>
            <td>
            	<?php
					if($checks['mbstring']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>Tokenizer PHP Extension</td>
            <td>
            	<?php
					if($checks['tokenizer']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>XML PHP Extension</td>
            <td>
            	<?php
					if($checks['xml']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>cURL PHP Extension</td>
            <td>
            	<?php
					if($checks['curl']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>zip PHP Extension</td>
            <td>
            	<?php
					if($checks['zip']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
            <td>gd PHP Extension</td>
            <td>
            	<?php
					if($checks['gd']){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						$all_ok = false;
					}
				?>
            </td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>

		<tr>
			<td class="col-md-6">
				<?php
					$storage_path = realpath(__DIR__ . '/../../storage/');
					$log_path = realpath(__DIR__ . '/../../storage/logs/');
					$framework = realpath(__DIR__ . '/../../storage/framework/');
					$is_writable = is_writable($storage_path) && is_writable($log_path) && is_writable($framework);
				?>
				Storage Directory is writeable?
			</td>
			<td class="col-md-6">
				<?php
					if($is_writable){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						echo "<br/>Please provide writable(recursive) permission to <br/><i>$storage_path</i>";
						$all_ok = false;
					}
				?>
			</td>
		</tr>
		<tr>
			<td>
				Cache Directory is writeable?
				<?php
					$cache_path = realpath(__DIR__ . '/../../bootstrap/cache');
				?>
			</td>
			<td>
				<?php
					if(is_writable($cache_path)){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						echo "<br/>Please provide writable permission to <br/><i>$cache_path</i>";
						$all_ok = false;
					}
				?>
			</td>
		</tr>

		<tr>
			<td>
				Uploads Directory is writeable?
				<?php
					$upload_path = realpath(__DIR__ . '/../uploads');
					$upload_b_logo = realpath(__DIR__ . '/../uploads/business_logos');
					$upload_b_doc = realpath(__DIR__ . '/../uploads/documents');
					$upload_b_img = realpath(__DIR__ . '/../uploads/img');
					$upload_i_logo = realpath(__DIR__ . '/../uploads/invoice_logos');
				?>
			</td>
			<td>
				<?php
					if(is_writable($upload_path) && is_writable($upload_b_logo) && is_writable($upload_b_doc) && is_writable($upload_b_img) && is_writable($upload_i_logo)){
						echo "<i class='glyphicon glyphicon-ok text-success' aria-hidden='true'></i>";
					} else {
						echo "<i class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></i>";
						echo "<br/>Please provide writable(recursive) permission to <br/><i>$upload_path</i>";
						$all_ok = false;
					}
				?>
			</td>
		</tr>

	</table>

	<center>
		<br/><br/><br/>
		<p>
			<?php
				if($all_ok){
					echo "<span class='text-success'>All setting looks correct. Go to <a href=$install_link>next step</a></span>";
				} else {
					echo "<span class='text-danger'>Some setting are incorrect. Correct it and then refresh this page</span>";
				}
			?>
		</p>
	</center>
	</div>
	</div>
</body>
</html>