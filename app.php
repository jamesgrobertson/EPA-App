<html>
	<body>
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
			 SOAP-ENC:arrayType="xsd:string[1]"
			 >
			 <string  xsi:type="xsd:string">303D</string>
			 </array>
			 </programsList>';
			$wsdl = 'http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL';
			$client = new nusoap_client($wsdl);
			$results = $client -> call('getEntitiesByLatLong', $params);
			$error = $client -> getError();
			krumo($results);
			if ($error) { print $error;
			};
		} else {print 'something went wrong';
		}
		?>
	</body>
</html>