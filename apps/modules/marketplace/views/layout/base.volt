<!DOCTYPE HTML>
<html lang="id">
<head>
    <title>{% block title %}{% endblock %} - Marketplace</title>

    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-grid.css') }}"/>
    <link rel="stylesheet" href="{{ static_url('/assets/css/bootstrap-reboot.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ static_url('/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="{{ static_url('/assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ static_url('/assets/vendor/select2/css/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="{{ static_url('/assets/vendor/daterangepicker/daterangepicker.css') }}">

    {% block css %}
    {% endblock %}

</head>
<body>
{% include 'layout/navbar.volt' %}
<div class="mt-5">
    {{ flashSession.output() }}

    {% block content %}

    {% endblock %}
</div>
</body>

<script src="{{ static_url('/assets/js/jquery-3.4.1.js') }}"></script>
<script src="{{ static_url('/assets/js/bootstrap.bundle.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
{#<script src="{{ static_url('/assets/vendor/bootstrap/js/popper.js') }}"></script>#}
{#<script src="{{ static_url('/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>#}
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/select2/js/select2.full.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ static_url('/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ static_url('/assets/vendor/countdowntime/countdowntime.js') }}"></script>

<script>
    $(document).ready(() => {
        $('.search-ajax').select2({
            ajax: {
                url: '{{ this.url.getBaseUri() }}/marketplace/product/searchProduct',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: data.results
                    };
                }
            },
            minimumInputLength: 4,
            placeholder: 'Search Product',
        })
        .on('select2:select', function (e) {
            window.location.href = "{{ this.url.getBaseUri() }}/marketplace/product/detailProduct/"+e.params.data.id;
        });

        setTimeout(function () {
            $('.alert').alert('close');
        }, 3000);

        $(function () {
            $('[data-toggle="popover"]').popover()
        });

        $('.popover-dismiss').popover({
            trigger: 'focus'
        });

        $('.alert').click(function () {
            $('.alert').alert('close')
        });
    });
</script>
{% block js %}{% endblock %}

</html>
