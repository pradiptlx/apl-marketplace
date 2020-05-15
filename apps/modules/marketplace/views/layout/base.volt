<!DOCTYPE HTML>
<html lang="id">
<head>
    <title>{% block title %}{% endblock %} - Marketplace</title>

    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-grid.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-reboot.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/daterangepicker/daterangepicker.css') }}">

    {% block css %}
    {% endblock %}

</head>
<body>
{% include 'layout/navbar.volt' %}
<div class="container-fluid my-5">
    {% block content %}

    {% endblock %}
</div>
</body>

<script src="{{ static_url('/assets/js/bootstrap.bundle.js') }}"></script>
<script src="{{ static_url('/assets/js/jquery-3.4.1.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
{#<script src="{{ static_url('/assets/vendor/bootstrap/js/popper.js') }}"></script>#}
{#<script src="{{ static_url('/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>#}
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ static_url('/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/countdowntime/countdowntime.js') }}"></script>
{% block js %}{% endblock %}

</html>
