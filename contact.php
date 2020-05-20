<html>
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

    <title>Contact Us</title>
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
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="forecast.php">Weather Forecast</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" href="contact.php">Contact Us</a>
                <li>
            </ul>
        </div>
    </nav>
    <h1 class="text-center">Contact Us</h1>

    <!-- Contact Form -->
    <div class="card">

        <h3 class="card-header info-colour white-text text-center py-4">
            <strong> Send Your Enquiries Here </strong>
        </h3>
        <div class="card-body px-lg-5 pt-0">
            <form action="" method="POST" class="text-center" style="color: #757575;">
                    
                <div class="md-form">
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>

                <div class="md-form">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>

                <div class="md-form">
                    <input type="text" name="subject" class="form-control" placeholder="Subject">
                </div>

                <div class="md-form">
                    <textarea type="text" name="msg" rows="3" placeholder="Message"></textarea>
                </div>

                <button class="btn btn-info btn-block" type="submit" name="sendemail" >Send</button>

            </form>
        </div>

    </div>
                
    <!-- SendGrid API -->
    <?php
        require 'vendor/autoload.php';

        // API key from SendGrid
        $apikey = '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';

        // Connecting contact form to email
        if(isset($_POST['sendemail']))
        {
            $name = $_POST['name'];
            $email_id = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['msg'];

            // Included in vendor folder
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("s3730387@student.rmit.edu.au", "Jason Chandra");
            $email->setSubject($subject);
            $email->addTo($email_id, $name);
            $email->addContent("text/plain", $message);

            $sendgrid = new \SendGrid($apikey);
            // Verification if email was sent or not
            // Provided from SendGrid API
            try {
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";
            } catch (Exception $e){
                echo 'Email exception caught: ' . $e->getMessage() . "\n";
            }

        }
    ?>

    <!-- Footer -->
    <!-- Double check class name -->
    <div class="fluid-container bg-dark text-white py-2">
        <h6 class="text-center mb-0">Copyright RMIT © 2020</h6>
    </div>
</body>
</html>