<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>How is the Water? | Results</title>
		<meta name="description" content="Results" />
		<meta name="author" content="James Robertson" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="wrapper">
			<header>
				<h1>How is the Water?</h1>
			</header>
			<div id="main">
				<?php
		require_once '../krumo/class.krumo.php';
		require_once 'lib/nusoap.php';
		if (is_numeric($_POST['latitude']) && is_numeric($_POST['longitude']) && is_numeric($_POST['radius'])) {
			$params = '<latitude xsi:type="xsd:decimal">' . $_POST['latitude'] . '</latitude>
			 <longitude xsi:type="xsd:decimal">' . $_POST['longitude'] . '</longitude>
			 <searchRadiusMiles xsi:type="xsd:decimal">' . $_POST['radius'] . '</searchRadiusMiles>
			 <programsList
			 xmlns:ns1="http://waters9i-waters/SpatialServices.xsd"
			 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
			 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
			 xsi:type="ns1:waters9i_waters_PrgList"
			 >
			 <array
			 xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
			 xsi:type="SOAP-ENC:Array"
			 SOAP-ENC:arrayType="xsd:string[2]"
			 >
			 <string  xsi:type="xsd:string">303D</string>
			 <string  xsi:type="xsd:string">WQS</string>
			 </array>
			 </programsList>';
			$wsdl = 'http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL';
			$client = new nusoap_client($wsdl);
			$results = $client -> call('getEntitiesByLatLong', $params);
			$error = $client -> getError();
			$entities = $results['watersApplications']['array'][0]['watersEntities']['array'];
			krumo($entities);

				?>
				<?php
				foreach ($entities as $key => $entity) {
					print '<div>' . $entity['entityName'] . '</div>';
					print '<div>' . $entity['entityTypeDescription'] . '</div>';
					print '<div>' . $entity['watersHightlights']['array'][2]['highlightValue'] . '</div>';
					print '<div>' . $entity['watersUrls']['array'][0]['urlAddress'] . '</div>';
					print '<div>' . $entity['endDateDescription'] . '</div>';
				}
				if ($error) { print $error;
				};
				} else {print 'You must enter a radius.';
				}
				?>
			</div>
			<footer>
				<p>
					&copy; Copyright  by James Robertson
				</p>
				<p>
					Submitted as an entry for the EPA's Apps for the Environment Challenge.
				</p>
			</footer>
		</div>
	</body>
</html>