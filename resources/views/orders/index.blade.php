@extends('layouts.layout')
@section('content')
    <div class="page-header clearfix">
        <h2 class="pull-left">Orders</h2>
        <a href="/orders/new" class="btn btn-success pull-right">
            Create order</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>OrderNumber</th>
            <th>Description</th>
            <th>Total</th>
        </tr>
        </thead>
        @foreach($orders as $order)
            :
            <tr>
                <td>
                    <a href="/orders/view/{{{ $order->getId() }}}">
                        {{{ $order->getId() }}}</a>
                </td>
                <td>{{{ $order->getCustomer()->getName() }}}</td>
                <td>{{{ $order->getOrderNumber() }}}</td>
                <td>{{{ $order->getDescription() }}}</td>
                <td>{{{ $order->getTotal() }}}</td>
            </tr>
        @endforeach
    </table>
@stop