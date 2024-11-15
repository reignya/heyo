<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Directions | Cebu Technological University Danao Campus</title>
    <link rel="apple-touch-icon" href="images/ctu.png">
    <link rel="shortcut icon" href="images/ctu.png">
   
    <link rel="apple-touch-icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">
    <link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../admin/assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <style>
        #map {
            height: 380px;
            width: 100%;
        }
        body {
            font-family: Arial, sans-serif;
            background: whitesmoke;
        }
        #controls {
            margin: 7px;
        }
        input[type="text"] {
            padding: 7px;
            margin: 5px 0;
            width: 200px;
        }
        select {
            padding: 7px;
            margin: 5px 0;
            width: 210px;
        }
        button {
            padding: 7px;
            border-radius: 9px;
      background-color: rgb(53, 97, 255);        
      color: white;
      border: solid ;
        cursor:pointer;
        font-weight:bold;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }
        button:hover {
            background-color: darkblue;
            border: solid blue;
        }
    </style>
</head>
<body>
<?php include_once('includes/sidebar.php');?>

<!-- Left Panel -->

<!-- Right Panel -->

 <?php include_once('includes/header.php');?>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>CTU Routing Map</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li class="active">Maps</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map container -->
    <div id="map"></div>

    <!-- Controls for entering start and end points with autocomplete and travel modes -->
    <div id="controls">
        <input id="start" type="text" placeholder="Enter start location">
        <input id="end" type="text" placeholder="Enter end location">
        <select id="travelMode">
            <option value="DRIVING">Driving</option>
            <option value="WALKING">Walking</option>
            <option value="BICYCLING">Bicycling</option>
            <option value="TRANSIT">Transit</option>
        </select>
        <button onclick="calculateRoute()" clas="btn-success">Get Directions</button>
    </div>

    <!-- Error handling -->
    <div id="error-message" style="color: red; margin-top: 10px;"></div>

    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let startAutocomplete;
        let endAutocomplete;

        // Initialize the map and set location to Cebu Technological University - Danao Campus
        function initMap() {
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();

            // Center the map at Cebu Technological University - Danao Campus
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 10.5223, lng: 124.0286}, // Coordinates for Cebu Technological University - Danao Campus
                zoom: 15
            });
            
            directionsRenderer.setMap(map);

            // Initialize autocomplete
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');
            startAutocomplete = new google.maps.places.Autocomplete(startInput);
            endAutocomplete = new google.maps.places.Autocomplete(endInput);
        }

        function calculateRoute() {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;
            const travelMode = document.getElementById('travelMode').value;

            // Create a directions request
            const request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode[travelMode]
            };

            // Calculate the route
            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    document.getElementById('error-message').innerText = 'Directions request failed due to ' + status;
                }
            });
        }

        // Load Google Maps API with error handling
        function loadScript() {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBDtc2Hnee_1qlV102sYcAE0Yyic050HoU&libraries=places&callback=initMap`;
            script.async = true;
            script.onerror = function() {
                document.getElementById('error-message').innerText = 'Failed to load Google Maps API. Please check your API key and internet connection.';
            };
            document.head.appendChild(script);
        }

        // Load the script on window load
        window.onload = loadScript;
    </script>

</body>
</html>
