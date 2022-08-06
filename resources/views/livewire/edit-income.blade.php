<div class="panel-content">
    <div class="row">
        <div class="col-md-4">
            <h3 style="margin-top: 0;"><strong>Выберите товары</strong></h3>
            <input wire:model="search" class="form-control" type="text" placeholder="Поиск по товарам...">
            <div class="search-results">
                <ul>
                    @forelse ($products as $item)
                        <li>
                            <div>
                                <p title="{{ $item->name }}">{{ $item->name }}</p>
                                <button wire:click="addIncomeProduct({{ $item->id }})" type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
                            </div>
                        </li>
                    @empty
                        <li>
                            <div>
                                <p>Ничего не найдено</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-hover dataTable" id="table-editable">
                <thead>
                    <tr>
                        <th>
                            №
                        </th>
                        <th>
                            Название
                        </th>
                        <th>
                            Количество
                        </th>
                        <th>
                            Цена (за единицу)
                        </th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incomeProducts as $index => $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                <p title="{{ $item['name'] }}" style="margin: 0; max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $item['name'] }}
                                </p>
                            </td>
                            <td>
                                <input wire:model="productQuantities.{{ $index }}" class="form-control" type="number">
                                @if ($errors->has('productQuantities.' . $index))
                                    <p class="text-danger m-0">{{ $errors->first('productQuantities.' . $index) }}</p>
                                @endif
                            </td>
                            <td>
                                <input wire:model="productPrices.{{ $index }}" class="form-control" type="number">
                                @if ($errors->has('productPrices.' . $index))
                                    <p class="text-danger m-0">{{ $errors->first('productPrices.' . $index) }}</p>
                                @endif
                            </td>
                            <td class="text-right">
                                <a wire:click="deleteProduct({{ $index }})" class="delete btn btn-sm btn-danger" href="javascript:;">
                                    <i class="icons-office-52"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">Ничего не выбрано</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-right">
                @if ($incomeProducts)
                    <button wire:click="updateIncome" type="button" class="btn btn-embossed btn-primary">
                        Создать
                        <i wire:loading="" wire:target="updateIncome" class="fa fa-spinner faa-spin animated"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('modals')

@endpush

@push('styles')
    <style>
        .search-results {
            margin-top: 15px;
            background-color: #ECEDEE;
            padding: 0 5px;
            max-height: 350px;
            overflow-y: auto;
        }
        .search-results ul li {
            list-style: none;
        }
        .search-results ul li:not(:last-child) {
            border-bottom: 1px solid #ddd;
        }
        .search-results ul li div {
            display: flex;
            align-items: center;
            padding: 5px 0;
        }
        .search-results ul li div p {
            flex: 1;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .search-results ul li div button {
            margin: 0;
        }
    </style>
@endpush

@push('scripts')

@endpush