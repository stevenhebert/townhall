<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../public_html/lib/styles.css" type="text/css">

    <!-- jQuery (required for Bootstap's JS plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- jQuery Form, Additional Methods, Validate -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

    <!-- jQuery Validate File -->
    <script src="js/jquery-validate.js"></script>

    <!-- Google reCAPTCHA -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <title>Contact Us</title>
</head>
<body>
    <main class="bgimg">

        <div class="container">
    <header>
            <h1>Contact Us</h1>
    </header>


        <div class="row">
            <div class="col-sm-6">

                <!-- BEGIN CONTACT FORM -->
                <form id="contact-form" action="php/mailer.php" method="post" novalidate>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Your Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Your Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-pencil"></i>
                            </div>
                            <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-comment"></i>
                            </div>
                            <textarea name="message" rows="5" id="message" class="form-control" placeholder="Your Message (2000 charaters max)"></textarea>
                        </div>
                    </div>

                    <!-- google reCAPTCHA -->
                    <div class="g-recaptcha" data-sitekey="6LfbhS8UAAAAAKw4v_CvLi9C7wTXp66FeGEWZnv-"></div>

                    <button class="btn btn-default" type="reset">Reset</button>
                    <button class="btn btn-info" type="submit">Submit</button>
                </form>
                <!-- END CONTACT FORM-->

                <!-- Form error/success message area -->
                <div id="output-area"></div>

            </div><!-- /.col-sm-6 -->
        </div><!-- /.row -->

            <!---sticky footer--->
            <nav class="navbar navbar-inverse navbar-fixed-bottom">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Townhall</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="#">Welcome</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span></span>license:https://creativecommons.org/licenses/by-nc-sa/2.0/legalcode</a></li>
                        <li><a href="#"><span></span>copyright:by ruimc77</a></li>
                    </ul>
                </div>
            </nav>

        </div>


        </div>
</main>
</body>
</html>

