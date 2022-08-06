@if ($sortBy !== $field)
    <i class="fa fa-sort"></i>
@elseif ($sortDirection == 'asc')
    <i class="fa fa-sort-asc"></i>
@else
    <i class="fa fa-sort-desc"></i>
@endif