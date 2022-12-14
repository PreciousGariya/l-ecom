@extends('backend.layouts.app')

@section('content')
<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Add New Subscription Product</h2>
                <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                    <button class="btn btn-md rounded font-sm hover-up">Publich</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Basic Details</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Product title</label>
                            <input type="text" placeholder="Type here" class="form-control" id="product_name">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Full description</label>
                            <textarea placeholder="Type here" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Regular price</label>
                                    <div class="row gx-2">
                                        <input placeholder="$" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Promotional price</label>
                                    <input placeholder="$" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Currency</label>
                                <select class="form-select">
                                    <option> USD </option>
                                    <option> EUR </option>
                                    <option> RUBL </option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Tax rate</label>
                            <input type="text" placeholder="%" class="form-control" id="product_name">
                        </div>
                        <label class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="">
                            <span class="form-check-label"> Make a template </span>
                        </label>
                    </form>
                </div>
            </div> <!-- card end// -->

        </div>

    </div>
</section>
@endsection
