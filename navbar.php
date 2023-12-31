<?php require_once('functions.php') ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">RateMyProfessor Data Visualizer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <?php
            if (isset($_SESSION['email'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="private.php">Make Comparisons</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="public.php">Public Page</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
            if (!isset($_SESSION['email'])) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="auth/signup.php">Sign up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auth/signin.php">Sign in</a>
                </li>
            <?php
            } else {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="auth/signout.php">Sign out</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>