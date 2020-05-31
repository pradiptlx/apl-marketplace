{% extends 'layout/base.volt' %}

{% block title %}{{ title }}{% endblock %}

{% block css %}

{% endblock %}

{% block content %}
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <h1 class="my-4">{{ product.product_name }}</h1>
                <a type="button" href="{{ url('/marketplace/product/addToWishlist/'~product.id) }}"
                   class="btn btn-info">Add To Wishlist</a>
                <a type="button" href="{{ this.url.getBaseUri()~'/marketplace/cart/addCart/?q='~product.id}}"
                   class="btn btn-primary">Add To Cart</a>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card mt-4">
                    <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                    <div class="card-body">
                        <h3 class="card-title">{{product.product_name}}</h3>
                        <h4>Rp. {{product.price}}</h4>
                        <p class="card-text">{{product.description}}</p>
                        <h5>Penjual : {{product.seller_name}}</h5>
                        <p>{{product.email}}</p>
                        <p>Telp : {{product.telp}}</p>
                        <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                        4.0 stars
                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Product Reviews
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <a href="#" class="btn btn-success">Leave a Review</a>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->

        </div>

    </div>
    <!-- /.container -->

{% endblock %}

{% block js %}

{% endblock %}
