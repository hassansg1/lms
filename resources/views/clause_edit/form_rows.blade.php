@foreach($items as $item)
    @php($padding = 5)
    @include('tree_files.clause_table_edit',['padding' => $padding,'class'=>''])
@endforeach


