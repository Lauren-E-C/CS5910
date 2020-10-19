<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';
?>
    <html>
    <head>
        <title>Table Name</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>

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
        </style>

        <script>
            jQuery(document).ready(function($) {
                $(".clickable-row").click(function() {
                    console.log($(this).data("href"));
                    window.location = $(this).data("data-href");
                });
            });
        </script>
    </head>
    <body><?php
