{% extends 'layout/base.volt' %}

{% block title %}{{ title }}{% endblock %}

{% block css %}
<link rel="stylesheet" type="text/css" href="{{ static_url('/assets/css/login/util.css') }}">
<link rel="stylesheet" type="text/css" href="{{ static_url('/assets/css/login/main.css') }}">
{% endblock %}

{% block content %}
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w"
                      method="post" action="{{ url('/marketplace/user/verifyToken') }}">
					<span class="login100-form-title p-b-32">
						{{ title }}
					</span>

                    <span class="txt1 p-b-11">
						Token
					</span>
                    <div class="wrap-input100 validate-input m-b-36" data-validate = "Token is required">
                        <input class="input100" type="tel" name="token" >
                        <span class="focus-input100"></span>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        Submit
                    </button>

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
{% endblock %}

{% block js %}
    <script src="{{ static_url('/assets/js/login/main.js') }}"></script>
{% endblock %}
