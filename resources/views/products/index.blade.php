@extends('base')

@section('title', 'Товары')

@section('products-active', 'nav-active active')

@section('products-all-active', 'active')

@section('content')
<div class="row">
    <div class="col-lg-12 portlets">
        <div class="panel">
            <div class="panel-header panel-controls">
                <h3><i class="fa fa-table"></i> <strong>Все товары</strong></h3>
            </div>
            @livewire('products')
        </div>
    </div>
</div>
@endsection

@push('modals')

@endpush

@push('styles')

@endpush

@push('scripts')

@endpush