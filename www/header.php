<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';
if (!isset($page_title)) {
    $page_title = "Lake Royal University";
}
?>
    <html>
    <head>
        <title><?= $page_title ?></title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
              integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
              crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
                integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
                integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf"
                crossorigin="anonymous"></script>

        <link rel="stylesheet" href="bootstrap-combobox.css">

        <style>
            .combobox.custom-select  {
                background: none;
            }
        </style>

        <style>
            html {
                position: relative;
                min-height: 100%;
            }

            body {
                margin-bottom: 60px; /* Margin bottom by footer height */
            }

            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                height: 60px; /* Set the fixed height of the footer here */
                line-height: 60px; /* Vertically center the text there */
                background-color: #f5f5f5;
            }

            .container {
                width: auto;
                max-width: 680px;
                padding: 0 15px;
            }

            html body footer.footer span.text-muted {
                padding-left: 20px;
            }
        </style>

        <style>
            body {
                padding: 0;
                margin: 0;
            }

            .top {
                background: url(../backgroundImage.jpg) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                height: 100vh;
                width: 100%;
                padding: 0;
                margin: 0;
                overflow: hidden;
                display: flex;
                align-items: center;
            }

            .login {
                border-radius: 15px;
                background-color: rgba(128, 125, 128, 0.65);
                padding: 15px;
                display: table;
                margin: 0 auto;
            }

            .login-td {
                font-family: Arial;
                padding: 10px;
            }

            .page_denied {
                border-radius: 15px;
                background-color: rgba(255, 64, 64, 0.80);
                padding: 15px;
                display: table;
                margin: 0 auto;
            }

            .page_denied-td {
                font-family: Arial;
                padding: 10px;
            }


            h1 {
                padding: .5em;
            }

            @media only screen and (max-width: 576px) {
                .top {
                    background: url(../backgroundImage.jpg) no-repeat center center fixed;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                    height: 100vh;
                    width: 100%;
                    padding: 0;
                    margin: 0;
                    overflow: hidden;
                    display: flex;
                    align-items: center;
                    z-index: -9999;
                }
            }
        </style>
        <script src="bootstrap-combobox.js"></script>

        <script>
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    console.log($(this).data("href"));
                    window.location = $(this).data("data-href");
                });
                $('.combobox').combobox();
            });
        </script>
    </head>
    <body><?php require_once 'nav.php' ?><h1><?= $page_title ?></h1>
