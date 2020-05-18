<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Optional JavaScript-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navContent" class="collapse navbar-collapse">
            <ul class="nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="forecast.php">Weather Forecast</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1 class="text-center">Welcome</h1>
    <!-- Geocoding API -->
    <div class="container">
        <h2 id="text-center">Enter Address: </h2>
        <form id="location-form">
            <input type="text" id="location-input" class="form-control form-control-lg">
            <br>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
        <div class="card-block" id="formatted-address"></div>
        <div class="card-block" id="address-components"></div>
        <div class="card-block" id="geometry"></div>
    </div>

    <script>
        // Call Geocode
        //geocode();

        // Get location form
        var locationForm = document.getElementById('location-form');

        // Listen for submit
        locationForm.addEventListener('submit', geocode);

        function geocode(e) {
            // Prevent actual submit
            e.preventDefault();

            var location = document.getElementById('location-input').value;

            axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                    params: {
                        address: location,
                        key: 'AIzaSyAvnLiylgVHNl58O1mP0feKX-LCOkfJVR8'
                    }
                })
                .then(function(response) {
                    // Log full response
                    console.log(response);

                    // Formatted Address
                    var formattedAddress = response.data.results[0].formatted_address;
                    var formattedAddressOutput = `
          <ul class="list-group">
            <li class="list-group-item">${formattedAddress}</li>
          </ul>
        `;

                    // Address Components
                    var addressComponents = response.data.results[0].address_components;
                    var addressComponentsOutput = '<ul class="list-group">';
                    for (var i = 0; i < addressComponents.length; i++) {
                        addressComponentsOutput += `
            <li class="list-group-item"><strong>${addressComponents[i].types[0]}</strong>: ${addressComponents[i].long_name}</li>
          `;
                    }
                    addressComponentsOutput += '</ul>';

                    // important 
                    var lat = response.data.results[0].geometry.location.lat;
                    var lng = response.data.results[0].geometry.location.lng;
                    var geometryOutput = `
          <ul class="list-group">
            <li class="list-group-item"><strong>Latitude</strong>: ${lat}</li>
            <li class="list-group-item"><strong>Longitude</strong>: ${lng}</li>
          </ul>
        `;

                    // Output
                    document.getElementById('formatted-address').innerHTML = formattedAddressOutput;
                    document.getElementById('address-components').innerHTML = addressComponentsOutput;
                    document.getElementById('geometry').innerHTML = geometryOutput;
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

    </script>
    <!-- Geocoding API END -->
    <!-- Footer -->
    <!-- Double check class name -->
    <div class="fluid-container bg-dark text-white py-2">
        <h6 class="text-center mb-0">Copyright RMIT © 2020</h6>
    </div>
</body>

</html>
