@extends('backend.layouts.app')

@section('content')
    <section class="content-main">
        <form action="{{ route('products.import_store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
                <div class="col-9">
                    <div class="content-header">

                        <h2 class="content-title">Import Products</h2>
                        {{-- <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                    <button class="btn btn-md rounded font-sm hover-up">Import</button>
                </div> --}}
                    </div>
                </div>
                @csrf
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Media</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-upload">
                                <img src="{{ asset('back-assets/imgs/theme/upload.svg') }}" alt="">
                                <input class="form-control" name="fileupload" type="file">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>
                                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                                <button class="btn btn-md rounded font-sm hover-up">Import</button>
                            </div>
                        </div>
                    </div> <!-- card end// -->

                </div>
            </div>

        </form>
        <hr>
        <form action="{{ route('category.import_store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="content-header">

                        <h2 class="content-title">Import Category</h2>
                        {{-- <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                    <button class="btn btn-md rounded font-sm hover-up">Import</button>
                </div> --}}
                    </div>
                </div>
                @csrf
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Media</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-upload">
                                <img src="{{ asset('back-assets/imgs/theme/upload.svg') }}" alt="">
                                <input class="form-control" name="fileupload" type="file">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>
                                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                                <button class="btn btn-md rounded font-sm hover-up">Import</button>
                            </div>
                        </div>
                    </div> <!-- card end// -->

                </div>
            </div>

        </form>

    </section> <!-- content-main end// -->
@endsection
