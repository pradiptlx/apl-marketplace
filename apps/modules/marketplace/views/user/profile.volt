{% extends 'layout/base.volt' %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <a href="#" id="userLink" class="list-group-item list-group-item-action active">User Management</a>
                    <a href="#wishlist" id="wishlistLink" class="list-group-item list-group-item-action">Wishlist</a>


                </div>
            </div>
            <div class="col-md-9" id="user">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Your Profile</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <div class="form-group row">
                                        <label for="username" class="col-4 col-form-label">User Name</label>
                                        <div class="col-8">
                                            <input id="username" name="username" placeholder="Username"
                                                   class="form-control here"
                                                   type="text" value="{{ user.username }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-4 col-form-label">Full Name</label>
                                        <div class="col-8">
                                            <input id="name" name="fullname" placeholder="Full Name"
                                                   class="form-control here"
                                                   type="text" value="{{ user.fullname }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="select" class="col-4 col-form-label">Change User Membership</label>
                                        <div class="col-8">
                                            <select id="select" name="status_user" class="custom-select">
                                                {% if user.status_user|upper === 'BUYER' %}
                                                <option value="BUYER" selected>Buyer</option>
                                                <option value="SELLER">Seller</option>
                                                {% else %}
                                                    <option value="BUYER">Buyer</option>
                                                <option value="SELLER" selected>Seller</option>
                                                {% endif %}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Email</label>
                                        <div class="col-8">
                                            <input id="email" name="email" placeholder="Email" class="form-control here"
                                                   type="email" value="{{ user.email }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Address</label>
                                        <div class="col-8">
                                            <input id="address" name="address" placeholder="Jalan Satu"
                                                   class="form-control here"
                                                   type="text" value="{{ user.address }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Telp Number</label>
                                        <div class="col-8">
                                            <input id="telp_number" name="telp_number" placeholder="Jalan Satu"
                                                   class="form-control here"
                                                   type="text" value="{{ user.telp_number }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">New Password</label>
                                        <div class="col-8">
                                            <input id="newpass" name="newpass" placeholder="New Password"
                                                   class="form-control here" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update My
                                                Profile
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-9" id="wishlist" hidden>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Wishlist</h4>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}

{% block js %}
    <script>

        $(document).ready(function () {
            let userLink = $('#userLink');
            let wishlistLink = $('#wishlistLink');

            userLink.click(function () {
                $('#wishlist').attr('hidden', true);
                $('#user').attr('hidden', false);
                userLink.attr('class', 'list-group-item list-group-item-action active');
                wishlistLink.removeAttr('class', 'active').attr('class', 'list-group-item list-group-item-action');
            });

            wishlistLink.click(function () {
                $('#wishlist').attr('hidden', false);
                $('#user').attr('hidden', true);
                wishlistLink.attr('class', 'list-group-item list-group-item-action active');
                userLink.removeAttr('class', 'active').attr('class', 'list-group-item list-group-item-action');
            });
        });

    </script>
{% endblock %}
