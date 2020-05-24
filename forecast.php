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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Weather Forecast</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navContent" class="collapse navbar-collapse">
            <ul class="nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="weather.php">Weather Forecast</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="air.php">Air Quality</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                <li>
            </ul>
        </div>
    </nav>

    <h1 class="text-center">Current Weather Forecast</h1>
    <br>
    <h2 class="text-center">{{ address }}</h2>

    <div class="fluid-container mx-sm-5 px-sm-5">
        <div class="card text-center">
            <div class="card-header">
                <h3 id="current"></h3>
            </div>

            <div class="card-body">
                <h3>{{ temp }}&deg;C</h3>
                <br />

                <p>
                    <b>Minimum Temp:</b> {{ temp_min }}&deg;C

                    <br />

                    <b>Maximum Temp:</b> {{ temp_max }}&deg;C

                    <br />

                    <b>Pressure:</b> {{ pressure }}in

                    <br />

                    <b>Humidity:</b> {{ humidity }}&#37;

                    <br />

                    <b>Wind Speed:</b> {{ speed }}m/s

                    <br />

                    <b>Visibility:</b> {{ visibility }}km

                    <br />

                    <b>Sunrise:</b> {{ sunrise }}

                    <br />

                    <b>Sunset:</b> {{ sunset }}
                </p>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="fluid-container bg-dark text-white py-2 fixed-bottom">
        <h6 class="text-center mb-0">Copyright RMIT © 2020</h6>
    </div>
</body>

</html>
