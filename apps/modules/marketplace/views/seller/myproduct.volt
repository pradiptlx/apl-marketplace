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
                                    <a href="{{url("marketplace/product/detailProduct/"~product.id)}}">{{product.product_name}}</a>
                                </h4>
                                <h5>Rp. {{product.price}}</h5>
                                <p class="card-text">Stok : {{product.stock}}</p>
                                <a class="btn btn-success"  href="{{url("marketplace/product/editProduct/"~product.id)}}">Edit</a>
                                <a class="btn btn-danger"  href="{{url("marketplace/product/deleteProduct/"~product.id)}}">Hapus</a>
                                <br>
                                <br>
                                <button class="btn btn-info" data-toggle="modal" data-target="#myModal"~{{product.id}}>Edit Stok</button>
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
        <div class="modal fade" id="myModal"~{{product.id}} role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 style="text-align: left">Edit Stok</h4>
                </div>
                <form method="POST" action="{{url("marketplace/seller/editStock/"~product.id)}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{product.stock}}">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Edit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- /.container -->

{% endblock %}
