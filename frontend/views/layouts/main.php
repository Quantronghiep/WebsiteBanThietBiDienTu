<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/rusu/rusu/shop-fullwidth.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Apr 2022 04:35:40 GMT -->
<head>
    <base href="<?php echo $_SERVER['SCRIPT_NAME'] ?>" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rusu - shop fullwidth</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
    ========================= -->


    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php require_once 'header.php'; ?>

<div class="main-content">
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($this->error)): ?>
            <div class="alert alert-danger">
                <?php
                echo $this->error;
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
    </div>
    <!--    hiển thị nội dung động -->
    <?php echo $this->content; ?>
</div>

<?php require_once 'footer.php'; ?>




<!-- JS
============================================ -->

<!-- Plugins JS -->
<script src="assets/js/plugins.js"></script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/script.js"></script>



</body>


<!-- Mirrored from htmldemo.net/rusu/rusu/shop-fullwidth.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Apr 2022 04:36:28 GMT -->
</html>