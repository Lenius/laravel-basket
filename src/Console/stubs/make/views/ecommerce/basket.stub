@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        Did you know?
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Fast delevery</li>
                            <li>Safe payment</li>
                        </ul>
                    </div>
                </div>


            </div>


            <div class="col-md-9">

                <div class="card">
                    <div class="card-header">
                        Shopping basket
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(Basket::contents())
                        <form action="{{route('basket')}}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col"></th>
                                    <th scope="col">Count</th>
                                    <th scope="col"></th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Tax</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Basket::contents() as $index => $item)
                                    <tr>
                                        <td><a href="{{route('product.item',[$item->id])}}">{{$item->name}}</a>
                                            @if( $item->hasOptions())
                                                <br/><br/> Tilvalg <br/>
                                                @foreach($item->options as $option)
                                                    {{$option['name']}} = {{$option['value']}} ({{$option['price']}})<br/>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td><a href="{{route('basket.item.inc',[$index])}}"><i class="fas fa-plus"></i></a></td>
                                        <td><input class="form-control" type="text" name="quantity[{{$index}}]" value="{{$item->quantity}}" style="width:90px"/></td>
                                        <td><a href="{{route('basket.item.dec',[$index])}}"><i class="fas fa-minus"></i></a></td>
                                        <td>{{$item->single(false)}}</td>
                                        <td>{{$item->tax}}</td>
                                        <td>{{$item->total(false)}}</td>
                                        <th scope="col"><a href="{{route('basket.item.remove',[$index])}}"><i class="fas fa-trash"></i></a></th>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tr>
                                    <td colspan="6">{{ __('ecommerce.price') }}</td>
                                    <td>{{ Basket::total(false)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">{{ __('ecommerce.tax') }}</td>
                                    <td>{{ Basket::tax()}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">{{ __('ecommerce.total') }}</td>
                                    <td>{{ Basket::total()}}</td>
                                </tr>
                            </table>
                            <input type="submit" value="{{ __('ecommerce.update') }}" class="btn btn-success"> <a href="{{route('basket.destroy')}}" value="" class="btn btn-danger">{{ __('ecommerce.empty') }}</a>
                        </form>
                        @else
                                Basket empty try add some demo <a href="{{route('basket.demo')}}">data</a>
                        @endif
                    </div>
                </div>
                <hr/>
                <div class="card">
                    <div class="card-header">
                        Products
                    </div>
                    <div class="card-body">
                        <div class="row">
                        @foreach($products as $product)
                                <div class="col-md-3">
                            <div class="card">
                                <img class="card-img-top" src="{{$product['image']}}" alt="{{$product['name']}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product['name']}}</h5>
                                    <p class="card-text">Demo product.</p>
                                    <a href="{{route('product.item', [$product['id']])}}" class="btn btn-primary">Buy</a>
                                </div>
                            </div>
                                </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
