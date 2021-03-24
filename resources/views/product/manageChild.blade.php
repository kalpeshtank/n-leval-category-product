@foreach($childs as $child)
@php
$spec='&nbsp;&nbsp;'.$hasChilds;
@endphp
<option value="{{ $child->id }}" @if($child->id == old('category_id', isset($product_data->category_id)?$product_data->category_id:''))
    selected="selected"
    @endif>
    {!! $spec !!}{{ $child->name }}
</option>
@if($child->childs)
@include('product.manageChild',['childs' => $child->childs,'hasChilds'=>$spec])
@endif
@endforeach
