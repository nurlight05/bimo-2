@extends('base')

@section('title', 'Склад')

@section('warehouse-active', 'nav-active active')

@section('content')
<div class="row">
    <div class="col-lg-12 portlets">
        <div class="panel">
            <div class="panel-header panel-controls">
                <h3><i class="fa fa-table"></i> <strong>Приходы</strong></h3>
            </div>
            @livewire('incomes')
        </div>
    </div>
</div>
@endsection

@push('modals')
    {{-- Modals --}}
    {{-- @stack('modals') --}}
@endpush

@push('styles')

@endpush

@push('scripts')

@endpush