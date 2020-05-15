<!DOCTYPE HTML>
<html lang="id">
<head>
    <title>{% block title %}{% endblock %} - Marketplace</title>

    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-grid.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-reboot.css') }}"/>

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
{% block js %}{% endblock %}

</html>
