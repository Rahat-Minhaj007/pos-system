<?php
include("includes/header.php");
if (isset($_SESSION['loggedIn'])) {
?>
    <script>
        window.location.href = "index.php";
    </script>
<?php
}
?>

<div class="py-5 bg-light" style="min-height:92vh;">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card shadow rounded-4 ">

                    <?php alertMessage(); ?>

                    <div class="p-5">
                        <h4 class="text-dark text-center mb-3">
                            SIGN IN
                        </h4>

                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label for="">
                                    Email
                                </label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">
                                    Password
                                </label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-12 mb-3 ">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100">LOGIN</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>