@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{$product['name']}}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Vue.component('product', require('./components/ecommerce/Product.vue')) -->
                        <product src="{{ json_encode($product)  }}"></product>
                            <hr/>
                        <admin src="{{ json_encode($product)  }}"></admin>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
