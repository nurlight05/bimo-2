<div class="panel-content">
    <div class="m-b-20">
        <div class="btn-group">
            <button wire:click="addNewRow" class="btn btn-sm btn-dark">
                <i class="fa fa-plus"></i>
                Добавить товар
            </button>
            <button wire:click="$set('isImport', true)" class="btn btn-sm btn-success" @if ($isImport) disabled @endif>
                <i class="fa fa-plus"></i>
                Импортировать Excel
            </button>
        </div>
        @if ($isImport)
            <form wire:submit.prevent="importProducts" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Поставщик</label>
                            <select wire:model="importSupplier" class="form-control" name="supplier" id="">
                                <option value="">Выберите поставщика</option>
                                @forelse ($suppliers as $item)
                                <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->name }}</option>
                                @empty
                                {{-- Empty --}}
                                @endforelse
                            </select>
                            @error('importSupplier')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Excel файл</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Choose...</span><span class="fileinput-exists">Change</span>
                                <input wire:model="importFile" type="file" name="importFile">
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                            @error('importFile')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-embossed btn-primary">
                    Импорт
                    <i wire:loading wire:target="importProducts" class="fa fa-spinner faa-spin animated"></i>
                </button>
                <button wire:click="$set('isImport', false)" type="reset" class="cancel btn btn-embossed btn-default m-b-10 m-r-0">Отмена</button>
            </form>
        @endif
    </div>
    <div>
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
                    <th wire:click="sortBy('sku')" class="is-sortable">
                        Артикул
                        @include('includes.sort-icon', ['field' => 'sku'])
                    </th>
                    <th wire:click="sortBy('name')" class="is-sortable">
                        Название
                        @include('includes.sort-icon', ['field' => 'name'])
                    </th>
                    <th wire:click="sortBy('brand')" class="is-sortable">
                        Бренд
                        @include('includes.sort-icon', ['field' => 'brand'])
                    </th>
                    <th wire:click="sortBy('kaspi_price')" class="is-sortable">
                        Цена Kaspi
                        @include('includes.sort-icon', ['field' => 'kaspi_price'])
                    </th>
                    <th wire:click="sortBy('pre_order')" class="is-sortable">
                        Пред. заказ
                        @include('includes.sort-icon', ['field' => 'pre_order'])
                    </th>
                    <th>
                        Картинка
                    </th>
                    <th>
                        Поставщик
                    </th>
                    <th wire:click="sortBy('active')" class="is-sortable">
                        Активность
                        @include('includes.sort-icon', ['field' => 'active'])
                    </th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($newRow)
                    <tr>
                        <td>
                            <input wire:model="sku" type="text" class="form-control">
                            @error('sku') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td class="text-center">
                            <input wire:model="name" type="text" class="form-control">
                            @error('name') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td class="text-center">
                            <input wire:model="brand" type="text" class="form-control">
                            @error('brand') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <input wire:model="kaspi_price" type="number" class="form-control">
                            @error('kaspi_price') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <input wire:model="pre_order" type="number" class="form-control">
                            @error('pre_order') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <input wire:model="imgFile" type="file" class="form-control">
                            @error('imgFile') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <select wire:model="supplier" class="form-control">
                                <option value="">Выберите поставщика</option>
                                @forelse ($suppliers as $item)
                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->name }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                            @error('supplier') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                <input 
                                    type="checkbox" 
                                    name="active" 
                                    class="onoffswitch-checkbox" 
                                    id="myonoffswitch2"
                                    wire:model="active">
                                <label class="onoffswitch-label m-0" for="myonoffswitch2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </td>
                        <td class="text-right">
                            <a wire:click="storeProduct" class="edit btn btn-sm btn-success" href="javascript:;">
                                Добавить
                            </a>
                            <a wire:click="removeNewRow" class="delete btn btn-sm btn-danger" href="javascript:;">
                                <i class="icons-office-52"></i>
                            </a>
                        </td>
                    </tr>
                @endif
                @forelse ($products as $index => $item)
                    <tr>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="products.{{ $index }}.sku" type="text" class="form-control">
                                @if ($errors->has('products.' . $index . '.sku'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.sku') }}</p>
                                @endif
                            @else
                                {{ $item['sku'] }}
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="products.{{ $index }}.name" type="text" class="form-control">
                                @if ($errors->has('products.' . $index . '.name'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.name') }}</p>
                                @endif
                            @else
                                <p style="max-width: 240px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item['name'] }}">{{ $item['name'] }}</p>
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="products.{{ $index }}.brand" type="text" class="form-control">
                                @if ($errors->has('products.' . $index . '.brand'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.brand') }}</p>
                                @endif
                            @else
                                {{ $item['brand'] }}
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="products.{{ $index }}.kaspi_price" type="number" class="form-control">
                                @if ($errors->has('products.' . $index . '.kaspi_price'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.kaspi_price') }}</p>
                                @endif
                            @else
                                {{ $item['kaspi_price'] }}
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="products.{{ $index }}.pre_order" type="number" class="form-control">
                                @if ($errors->has('products.' . $index . '.pre_order'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.pre_order') }}</p>
                                @endif
                            @else
                                {{ $item['pre_order'] }}
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                @if ($imageChange === $index)
                                    <input wire:model="imgFile" type="file" class="form-control">
                                    @error('imgFile')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                @else
                                    <div style="display: flex; align-items: center;">
                                        <p style="max-width: 120px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['img'] }}</p>
                                        <button wire:click="$set('imageChange', {{ $index }})">Изменить</button>
                                    </div>
                                @endif
                            @else
                                <p data-toggle="popover" data-img="@if($item['img']){{asset($item['img'])}}@endif" style="max-width: 190px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['img'] ?? '(нет)' }}</p>
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <select wire:model.defer="products.{{ $index }}.supplier_id" class="form-control">
                                    @forelse ($suppliers as $supplier)
                                        @if ($supplier->id == $item['supplier']['id'])
                                            <option wire:key="{{ $supplier->id }}" value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                                        @else
                                            <option wire:key="{{ $supplier->id }}" value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endif
                                    @empty
                                        {{-- Empty --}}
                                    @endforelse
                                </select>
                                @if ($errors->has('products.' . $index . '.supplier_id'))
                                    <p class="text-danger m-0">{{ $errors->first('products.' . $index . '.supplier_id') }}</p>
                                @endif
                            @else
                                {{ $item['supplier']['name'] }}
                            @endif
                        </td>
                        <td>
                            @if ($isEditable === $index)
                                <div class="onoffswitch2">
                                    <input 
                                        type="checkbox" 
                                        name="active" 
                                        class="onoffswitch-checkbox" 
                                        id="myonoffswitch6" 
                                        wire:model.defer="products.{{ $index }}.active">
                                    <label class="onoffswitch-label m-0" for="myonoffswitch6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            @else
                                @if ($item['active'])
                                    <span class="label label-success">Да</span>
                                @else
                                    <span class="label label-danger">Нет</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($isEditable === $index)
                                <a wire:click="saveProduct({{ $index }})" class="btn btn-sm btn-success m-0" href="javascript:;">
                                    Сохранить
                                </a>
                                <a wire:click="uneditProduct({{ $index }})" class="delete btn btn-sm btn-danger" href="javascript:;">
                                    <i class="icons-office-52"></i>
                                </a>
                            @else
                                <a wire:click="editProduct({{ $index }})" class="edit btn btn-sm btn-default" href="javascript:;">
                                    <i class="icon-note"></i>
                                </a>
                                <a wire:click="deleteProduct({{ $index }})" class="delete btn btn-sm btn-danger" href="javascript:;">
                                    <i class="icons-office-52"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="7">Ничего не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6">
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                    Показан {{ $paginated->firstItem() }}-{{ $paginated->lastItem() }} из {{ $paginated->total() }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    {{ $paginated->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            $('[data-toggle="popover"]').popover({
                //trigger: 'focus',
                trigger: 'hover',
                html: true,
                content: function () {
                    return '<img style="width: 100%; height: auto;" src="'+$(this).data('img') + '" />';
                }
            }) 
        })
    </script>
</div>

@push('modals')

@endpush

@push('styles')
    <link href="{{ asset('assets/plugins/font-awesome-animation/font-awesome-animation.min.css') }}" rel="stylesheet">
    <style>
        .is-sortable {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    {{-- <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/animations.js') }}"></script>
@endpush