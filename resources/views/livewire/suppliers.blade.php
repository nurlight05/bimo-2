<div class="panel-content">
    <div class="m-b-20">
        <div class="btn-group">
            <button wire:click="addNewRow" class="btn btn-sm btn-dark">
                <i class="fa fa-plus"></i>
                Добавить поставщика
            </button>
        </div>
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
                    <th wire:click="sortBy('name')" class="is-sortable">
                        Имя
                        @include('includes.sort-icon', ['field' => 'name'])
                    </th>
                    <th wire:click="sortBy('nds')" class="text-center is-sortable">
                        НДС
                        @include('includes.sort-icon', ['field' => 'nds'])
                    </th>
                    <th wire:click="sortBy('rrc')" class="text-center is-sortable">
                        RRC
                        @include('includes.sort-icon', ['field' => 'rrc'])
                    </th>
                    <th wire:click="sortBy('bonus')" class="text-center is-sortable">
                        Бонус
                        @include('includes.sort-icon', ['field' => 'bonus'])
                    </th>
                    <th wire:click="sortBy('info')" class="text-center is-sortable">
                        Инфо
                        @include('includes.sort-icon', ['field' => 'info'])
                    </th>
                    <th wire:click="sortBy('active')" class="text-center is-sortable">
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
                            <input wire:model="name" type="text" class="form-control">
                            @error('name') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td class="text-center">
                            <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                <input 
                                    type="checkbox" 
                                    name="nds" 
                                    class="onoffswitch-checkbox" 
                                    id="myonoffswitch1" 
                                    wire:model="nds">
                                <label class="onoffswitch-label m-0" for="myonoffswitch1">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                <input 
                                    type="checkbox" 
                                    name="rrc" 
                                    class="onoffswitch-checkbox" 
                                    id="myonoffswitch2" 
                                    wire:model="rrc">
                                <label class="onoffswitch-label m-0" for="myonoffswitch2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <input wire:model="bonus" type="number" class="form-control">
                            @error('bonus') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td>
                            <input wire:model="info" type="text" class="form-control">
                            @error('info') <p class="text-danger m-0">{{ $message }}</p> @enderror
                        </td>
                        <td class="text-center">
                            <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                <input 
                                    type="checkbox" 
                                    name="active" 
                                    class="onoffswitch-checkbox" 
                                    id="myonoffswitch3" 
                                    wire:model="active">
                                <label class="onoffswitch-label m-0" for="myonoffswitch3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </td>
                        <td class="text-right">
                            <a wire:click="storeSupplier" class="edit btn btn-sm btn-success" href="javascript:;">
                                Добавить
                            </a>
                            <a wire:click="removeNewRow" class="delete btn btn-sm btn-danger" href="javascript:;">
                                <i class="icons-office-52"></i>
                            </a>
                        </td>
                    </tr>
                @endif
                @forelse ($suppliers as $index => $item)
                    <tr>
                        <td>
                            @if ($isEditable === $index)
                                <input wire:model.defer="suppliers.{{ $index }}.name" type="text" class="form-control">
                                @if ($errors->has('suppliers.' . $index . '.name'))
                                    <p class="text-danger m-0">{{ $errors->first('suppliers.' . $index . '.name') }}</p>
                                @endif
                            @else
                                {{ $item['name'] }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isEditable === $index)
                                <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                    <input 
                                        type="checkbox" 
                                        name="nds" 
                                        class="onoffswitch-checkbox" 
                                        id="myonoffswitch4" 
                                        wire:model.defer="suppliers.{{ $index }}.nds">
                                    <label class="onoffswitch-label m-0" for="myonoffswitch4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            @else
                                @if ($item['nds'])
                                    <span class="label label-success">Да</span>
                                @else
                                    <span class="label label-danger">Нет</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isEditable === $index)
                                <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                    <input 
                                        type="checkbox" 
                                        name="rrc" 
                                        class="onoffswitch-checkbox" 
                                        id="myonoffswitch5" 
                                        wire:model.defer="suppliers.{{ $index }}.rrc">
                                    <label class="onoffswitch-label m-0" for="myonoffswitch5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            @else
                                @if ($item['rrc'])
                                    <span class="label label-success">Да</span>
                                @else
                                    <span class="label label-danger">Нет</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isEditable === $index)
                                <input wire:model.defer="suppliers.{{ $index }}.bonus" name="bonus" class="form-control" type="number" min="0" max="100">
                                @if ($errors->has('suppliers.' . $index . '.bonus'))
                                    <p class="text-danger m-0">{{ $errors->first('suppliers.' . $index . '.bonus') }}</p>
                                @endif
                            @else
                                {{ $item['bonus'] }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isEditable === $index)
                                <input wire:model.defer="suppliers.{{ $index }}.info" name="info" class="form-control" type="text">
                                @if ($errors->has('suppliers.' . $index . '.info'))
                                    <p class="text-danger m-0">{{ $errors->first('suppliers.' . $index . '.info') }}</p>
                                @endif
                            @else
                                {{ $item['info'] }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isEditable === $index)
                                <div class="onoffswitch2" style="margin: 0 auto; float: none;">
                                    <input 
                                        type="checkbox" 
                                        name="active" 
                                        class="onoffswitch-checkbox" 
                                        id="myonoffswitch6" 
                                        wire:model.defer="suppliers.{{ $index }}.active">
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
                                <a wire:click="saveSupplier({{ $index }})" class="btn btn-sm btn-success m-0" href="javascript:;">
                                    Сохранить
                                </a>
                                <a wire:click="deleteSupplier({{ $index }})" class="delete btn btn-sm btn-danger" href="javascript:;">
                                    <i class="icons-office-52"></i>
                                </a>
                            @else
                                <a wire:click="editSupplier({{ $index }})" class="edit btn btn-sm btn-default" href="javascript:;">
                                    <i class="icon-note"></i>
                                </a>
                                <a wire:click="deleteSupplier({{ $index }})" class="delete btn btn-sm btn-danger" href="javascript:;">
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
                    {{ $paginated->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('modals')

@endpush

@push('styles')
    <style>
        .is-sortable {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')

@endpush