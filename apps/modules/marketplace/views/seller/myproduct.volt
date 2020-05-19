{% extends 'layout/base.volt' %}

{% block title %}Home{% endblock %}

{% block content %}

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <h1 class="my-4">Shop Name</h1>
                <div class="list-group">
                    <a href="#" class="list-group-item active">My Product</a>
                </div>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                </div>

                <div class="row">
                    {% for product in products %}
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="{{url("marketplace/product/detailProduct/"~product.getId().getId())}}">{{product.getProductName()}}</a>
                                </h4>
                                <h5>Rp. {{product.getPrice()}}</h5>
                                <p class="card-text">Stok : {{product.getStock()}}</p>
                                <a class="btn btn-success"  href="{{url("marketplace/product/editProduct/"~product.getId().getId())}}">Edit</a>
                                <a class="btn btn-danger"  href="{{url("marketplace/product/deleteProduct/"~product.getId().getId())}}">Hapus</a>
                            </div>
                           
                            <div class="card-footer">
                                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                            </div>
                        </div>
                    </div>
                    {% endfor %}
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

{% endblock %}
