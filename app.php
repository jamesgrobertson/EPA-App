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
				<h2>Results</h2>
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



				?>
				<?php
				if (is_array($entities)) {
					foreach ($entities as $key => $entity) {
						print '<div class="box">';
						print '<div class="name"><strong>Name:</strong> ' . $entity['entityName'] . '</div>';
						print '<div class="type"><strong>Status:</strong> ' . $entity['entityTypeDescription'] . '</div>';
						print '<div class="tmdl"><strong>Has a TMDL been developed?:</strong> ' . $entity['watersHightlights']['array'][2]['highlightValue'] . '</div>';
						print '<div class="data"><strong>Last Data Available:</strong> ' . $entity['endDateDescription'] . '</div>';
						print '<div class="report"><a href="' . $entity['watersUrls']['array'][0]['urlAddress'] . '">Read the Full Report</a></div>';
						print '</div>';
					}
				} else { print '<p>There were no results found within that radius.</p>';
				}
				if ($error) { print $error;
				};
				} else {print '<p>You must enter a radius.</p>';
				}
				?>
				<div class="box">
					<p>
						<a href="index.html">Do Another Search ></a>
					</p>
					<p>
						<a href="more-information.html">Learn what the terms mean ></a>
					</p>
				</div>
				<footer id="footer">
					<p>
						Created by <a href="http://www.jamesgrobertson.com">James Robertson</a> and Vanessa Dennis.
					</p>
					<p>
						Submitted as an entry for the EPA's <a href="http://appsfortheenvironment.challenge.gov/">Apps for the Environment Challenge</a>.
					</p>
					<p>
						Code licensed under the GPL and hosted on <a href="https://github.com/jamesgrobertson">github</a>.
					</p>
				</footer>
			</div>
	</body>
</html>