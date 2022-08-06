<div class="panel-content">
    <div class="m-b-20">
        <div class="btn-group">
            <button onclick="location.href='{{ route('income.create') }}'" class="btn btn-sm btn-dark">
                <i class="fa fa-plus"></i>
                Добавить приход
            </button>
        </div>
    </div>
    <div>
        <div class="row m-b-20">
            <div class="col-xs-12">
                @php
                    $sum = 0;
                    if ($incomes) {
                        foreach ($incomes as $income) {
                            $sum += $income->total;
                        }
                    }
                @endphp
                <p style="text-align: right !important; font-size: 20px !important;"><strong>Итого: </strong>{{ $sum }} тг.</p>
            </div>
        </div>
        <div class="m-b-20 date-filter">
            <div>
                <p>с</p>
                <input class="form-control" type="date" name="" id="">
            </div>
            <div>
                <p>до</p>
                <input class="form-control" type="date" name="" id="">
            </div>
            <button class="btn btn-primary">Поиск</button>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <label>
                    <select class="form-control">
                        <option wire:click="setPerPage(10)" value="10" @if ($perPage == 10) selected @endif>10</option>
                        <option wire:click="setPerPage(25)" value="25" @if ($perPage == 25) selected @endif>25</option>
                        <option wire:click="setPerPage(50)" value="50" @if ($perPage == 50) selected @endif>50</option>
                        <option wire:click="setPerPage(100)" value="100" @if ($perPage == 100) selected @endif>100</option>
                    </select>
                </label>
            </div>
            <div class="col-xs-6">
                <div class="text-right">
                    <label>
                        <input wire:model.debounce.300ms="search" placeholder="Поиск..." type="search" class="form-control" aria-controls="table-editable">
                    </label>
                </div>
            </div>
        </div>
        <table class="table table-hover dataTable" id="table-editable">
            <thead>
                <tr>
                    <th>
                        №
                    </th>
                    <th wire:click="sortBy('created_at')" class="is-sortable">
                        Дата создания
                        @include('includes.sort-icon', ['field' => 'created_at'])
                    </th>
                    <th>
                        Сумма
                    </th>
                    <th class="text-right">
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incomes as $index => $item)
                <tr>
                    <td>
                        {{ $item->id }}
                    </td>
                    <td>
                        {{ $item->created_at }}
                    </td>
                    <td>
                        {{ $item->total }}
                    </td>
                    <td class="text-right">
                        <a class="edit btn btn-sm btn-default" href="{{ route('income.edit', ['warehouse' => $item->id]) }}">
                            <i class="icon-note"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center">
                        <td colspan="3">Ничего не найдено</td>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{-- <div class="row">
            <div class="col-md-6">
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                    Показан {{ $paginated->firstItem() }}-{{ $paginated->lastItem() }} из {{ $paginated->total() }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    {{ $paginated->links() }}
                </div>
            </div>
        </div> --}}
    </div>
</div>

@push('modals')

@endpush

@push('styles')
    <style>
        .is-sortable {
            cursor: pointer;
        }
        .date-filter {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 5px;
        }
        .date-filter div {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .date-filter div p {
            margin-bottom: 0;
        }
        .date-filter button {
            margin-bottom: 0;
        }
    </style>
@endpush

@push('scripts')

@endpush