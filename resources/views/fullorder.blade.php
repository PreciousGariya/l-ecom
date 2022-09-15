@extends('layouts.app')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> Full Order
                <span></span> Account
            </div>
        </div>
    </div>
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>#{{$singal_order->id}}</td>
                                        <td>{{$singal_order->created_at}}</td>
                                        <td>{{$singal_order->o_status}}</td>
                                        <td>{{$singal_order->total_value}} for {{count(json_decode($singal_order->order_details))}} item</td>
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Url</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                //    print_r($singal_order->order_details);
                                //    die;

                                    $total=[];
                                   foreach (json_decode($singal_order->order_details) as $key => $order_detail) {

                                    ?>

                                    <tr>
                                        <td><a href="{{route('products.show',$order_detail->slug)}}">view Product</a></td>
                                        <td>{{$order_detail->product_name}}</td>
                                        <td><img src="/{{$order_detail->image}}" width="200" alt=""></td>
                                        <td>{{$order_detail->price}}</td>
                                        <td>{{$order_detail->quantity}}</td>
                                        <td>{{$order_detail->quantity*$order_detail->price}}</td>

                                        <?php   $total[$key]=$order_detail->quantity*$order_detail->price ?>
                                    </tr>

                                    <?php }  ?>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Total</td>
                                        <td class="float-right" rowspan="5"><h6><?php echo array_sum($total); ?></h6></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
