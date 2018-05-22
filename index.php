<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trasy</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container text-center">

    <!--HEADER-->
    <header class="panel">
        <h1>trasy</h1>

        <?php

            //REGISTER MESSAGE
            if (false == empty($_SESSION['message'])) {
                echo '<br><div class="alert alert-success">'.$_SESSION['message'].'</div>';
                unset($_SESSION['message']);
            }
        ?>

            <?php if (isset($_SESSION['logged']) && false === empty($_SESSION['logged'])) { ?>

            <div class="alert alert-info">
            <?php echo "Logged as: " . $_SESSION['logged']; ?>
            </div>

            <form action="php/logout.php" method="post">
                <input type="submit" value="LOGOUT" class="form-control">
            </form>

            <?php } else { ?>

            <div class="col-md-6">
                <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal-register">REGISTER</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal-login">LOGIN</button>
            </div>


            <!--MODAL REGISTER-->
            <div id="modal-register" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">REGISTRATION</h4>
                        </div>
                        <div class="modal-body">
                            <!--FORM-->
                            <form id="register-form" action="php/register.php" method="post">
                                <label for="register-input-email">E-mail:</label>
                                <input type="email" name="email" class="form-control" id="register-input-email" required>
                                <br>

                                <label for="register-input-password">Password:</label>
                                <input type="password" name="password" class="form-control" id="register-input-password" required>
                                <br>

                                <label for="register-input-password-repeat">Repeat password:</label>
                                <input type="password" name="password-repeat" class="form-control" id="register-input-password-repeat" required>
                                <br>
                                <!--<label for="register-submit"></label>-->
                                <input type="submit" value="REGISTER" id="register-submit">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>


            <!--MODAL LOGIN-->
            <div id="modal-login" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">LOGIN</h4>
                        </div>
                        <div class="modal-body">
                            <!--FORM-->
                            <form id="login-form" action="php/login.php" method="post">
                                <label for="login-try-input">E-mail:</label>
                                <input type="email" name="login-try" class="form-control" id="login-try-input" required>
                                <br>

                                <label for="password-try-input">PASSWORD</label>
                                <input type="password" name="password-try" class="form-control" id="password-try-input" required>
                                <br>

                                <!--<label for="login-submit"></label>-->
                                <input type="submit" value="LOGIN" id="login-submit">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        <?php } ?>

        <?php if (isset($_SESSION['logged']) && false === empty($_SESSION['logged']) && $_SESSION['logged'] === 'admin@admin.com') : ?>

            <!-- NEWS -->
            <form action="php/addNews.php" method="post">
                <h2>ADD NEWS:</h2>
                <label for="new-title">Title:</label>
                <input type="text" name="new-title" required class="form-control" id="new-title">
                <label for="new-text">Text:</label>
                <input type="text" name="new-text" required class="form-control" id="new-text">
                <br>
                <input type="submit" name="submit" class="btn btn-default btn-block">
            </form>

        <?php endif; ?>

    </header>

    <!--CONTENT-->
    <section>

        <article>

            <?php
                require 'php/getNews.php';
                $news = getNews();
                if ($news !== NULL) {
                    echo "<h2>NEWS</h2>";
                    foreach ($news as $key => $value) {
                        echo '<div class="jumbotron">';
                        echo '<h3>'.$value[1].'</h3>';
                        echo '<p>'.$value[2].'</p>';
                        echo "</div>";
                    }
                }
            ?>

        </article>

    </section>




    <!--FOOTER-->
    <footer>

    </footer>

</div>

<script>

    $(document).ready(function () {

        //REGISTRATION FORM
        $('#register-form').submit(function (e) {
            e.preventDefault();
            var password_input = $('#register-input-password').val();
            var password_input_repeat = $('#register-input-password-repeat').val();
            var unique_login_flag = true;

            if (password_input !== password_input_repeat) {
                alert('Password and RePassword must match!');
                return;
            }

            $.post(
                'php/check_login.php',
                {email: $('#register-input-email').val()},
                function (data) {
                    if (data === '0') {
                        alert('Unique email required!');
                        unique_login_flag = false;
                    }
            });

            if (unique_login_flag) {
                this.submit();
            }
        });
    });

</script>

</body>
</html>
