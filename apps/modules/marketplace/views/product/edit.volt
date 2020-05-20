{% extends 'layout/base.volt' %}

{% block title %}{{ title }}{% endblock %}

{% block css %}

{% endblock %}

{% block content %}
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <h1 class="my-4">Shop Name</h1>
                <div class="list-group">
                    <a href="#" class="list-group-item active">Edit Product</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Product Reviews
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url("marketplace/product/editProduct/"~product['idProduct'])}}">
                            <div class="form-group">
                              <label for="productName">Product Name</label>
                              <input type="text" class="form-control" id="productName" name="productName" value="{{product['productName']}}">
                            </div>
                            <div class="form-group">
                              <label for="stok">Stok</label>
                              <input type="number" class="form-control" id="stok" name="stok" value="{{product['stock']}}">
                            </div>
                            <div class="form-group">
                                <label for="price">Price per Product</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{product['price']}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" >{{product['description']}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Edit Product</button>
                        </form>
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
