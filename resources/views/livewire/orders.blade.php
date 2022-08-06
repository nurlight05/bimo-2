<div>
    <div>
        @if (session()->has('notify'))
            <ul class="noty_inline_layout_container i-am-new" style="width: auto; height: auto; margin: 0px; padding: 0px; list-style-type: none; z-index: 9999999; top: 0px; left: 0px;">
                <li class="made noty_container_type_alert animated fadeIn" style="cursor: pointer; height: 63px;">
                    <div class="noty_bar noty_type_alert" id="noty_889097152506636900">
                        <div class="noty_message"><span class="noty_text">
                                <div class="alert alert-{{session('notify')['status']}} media fade in">
                                    <p>{{ session('notify')['message'] }}</p>
                                </div>
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
            <script>
                setTimeout(function(){
                    $('.made').removeClass('fadeIn').addClass('fadeOut')
                }, 3000)
            </script>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12 portlets">
            <div class="panel">
                <div class="panel-header panel-controls">
                    <h3><i class="fa fa-table"></i> <strong>Все заказы</strong></h3>
                </div>
                <div class="panel-content">
                    <div class="m-b-30">
                        <div>
                            <p><strong>Выберите дату</strong></p>
                        </div>
                        <div class="m-b-10">
                            <input 
                                class="form-control input-sm @error('filterDate') form-error @enderror" 
                                wire:model="filterDate" 
                                type="date" 
                                style="line-height: 18px; max-width: 300px;"
                                wire:loading.attr="disabled"
                                wire:target="sync">
                            @error('filterDate')<div id="date-error" class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="btn-group">
                            <button wire:click="sync" class="btn btn-sm btn-success" wire:loading.class="disabled">
                                <i class="fa fa-refresh" wire:loading.class="faa-spin animated" wire:target="sync"></i>&nbsp;&nbsp;&nbsp;
                                Синхронизировать
                            </button>
                        </div>
                    </div>
                    <div>
                        {{-- <div class="row">
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
                        </div> --}}
                        <table class="table table-hover dataTable" id="table-editable">
                            <thead>
                                <tr>
                                    <th>Код</th>
                                    <th>Сумма</th>
                                    <th>Тип оплаты</th>
                                    <th>План-я дата доставки</th>
                                    <th>Дата создания</th>
                                    <th>Тип доставки</th>
                                    <th>Положение</th>
                                    <th>Статус</th>
                                    <th>Сумма доставки</th>
                                    <th>Товары</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $index => $item)
                                    <tr>
                                        <td>{{ $item->code ?? '-' }}</td>
                                        <td>{{ $item->total_price ?? '-' }}</td>
                                        <td>{{ $item->payment_mode ?? '-' }}</td>
                                        <td>{{ $item->planned_delivery_date ?? '-' }}</td>
                                        <td>{{ $item->creation_date ?? '-' }}</td>
                                        <td>{{ $item->delivery_mode ?? '-' }}</td>
                                        <td>{{ $item->state ?? '-' }}</td>
                                        <td>
                                            @if ($item->inStock)
                                            <span class="label label-success">Есть в наличии</span>
                                            @else
                                            <select class="form-control" wire:model="editedOrder" wire:change="updateOrderStatus({{ $item->id }})" wire:loading.attr="disabled" wire:target="updateOrderStatus" autocomplete="off">
                                                @foreach ($statusList as $key => $value)
                                                    @if ($item->warehouse_status == $key)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                @endforeach
                                                @foreach ($statusList as $key => $value)
                                                    @if ($item->warehouse_status != $key)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif
                                        </td>
                                        <td>{{ $item->delivery_cost ?? '-' }}</td>
                                        @if ($item->products()->exists())
                                            @php
                                                $skus = array();
                                                foreach ($item->products as $product) {
                                                    array_push($skus, $product->sku);
                                                }
                                                $products = implode(', ', $skus);
                                            @endphp
                                            <td class="text-truncate" title="{{ $products }}">
                                                {{ $products }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="9">Ничего не найдено</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                    Показан {{ $orders->firstItem() }}-{{ $orders->lastItem() }} из {{ $orders->total() }}
                                </div> --}}
                                <a wire:click="$set('perPage', 10)" @if($perPage != 10) style="cursor: pointer;" @else style="color: #000;" @endif>10</a>
                                <a wire:click="$set('perPage', 25)" @if($perPage != 25) style="cursor: pointer;" @else style="color: #000;" @endif>25</a>
                                <a wire:click="$set('perPage', 50)" @if($perPage != 50) style="cursor: pointer;" @else style="color: #000;" @endif>50</a>
                                <a wire:click="$set('perPage', 100)" @if($perPage != 100) style="cursor: pointer;" @else style="color: #000;" @endif>100</a>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('modals')

@endpush

@push('styles')
    <link href="{{ asset('assets/plugins/font-awesome-animation/font-awesome-animation.min.css') }}" rel="stylesheet">
    <style>
        .is-sortable {
            cursor: pointer;
        }
        #date-error {
            margin-top: 0 !important;
            color: #f36363 !important;
            font-style: normal !important;
        }
        .text-truncate {
            max-width: 75px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        select {
            padding: 0px 5px 3px !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/pages/animations.js') }}"></script>
@endpush