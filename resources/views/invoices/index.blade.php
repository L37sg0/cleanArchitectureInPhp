@extends('layouts.layout')
@section('content')
    <div class="page-header clearfix">
        <h2 class="pull-left">Invoices</h2>
        <a href="/invoices/new" class="btn btn-success pull-right">
            Create invoice</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Order</th>
            <th>Date</th>
            <th>Total</th>
        </tr>
        </thead>
        @foreach($invoices as $invoice)
            :
            <tr>
                <td>
                    <a href="/invoices/view/{{{ $invoice->getId() }}}">
                        {{{ $invoice->getId() }}}</a>
                </td>
                <td>{{{ $invoice->getOrder()->getOrderNumber() }}}</td>
                <td>{{{ (string) $invoice->getInvoiceDate()->format('Y-m-d h:i:s') }}}</td>
                <td>{{{ $invoice->getTotal() }}}</td>
            </tr>
        @endforeach
    </table>
@stop