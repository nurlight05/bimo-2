@extends('base')

@section('title', 'Поставщики')

@section('suppliers-active', 'nav-active active')

@section('suppliers-all-active', 'active')

@section('content')
<div class="row">
    <div class="col-lg-12 portlets">
        <div class="panel">
            <div class="panel-header panel-controls">
                <h3><i class="fa fa-table"></i> <strong>Все поставщики</strong></h3>
            </div>
            @livewire('suppliers')
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