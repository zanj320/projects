@if($clothe->avaliabilities[0]->quantity>0)
    <span class="text-success h5">IN STOCK</span>
@else
    <span class="text-danger h5">SOLD OUT</span>
@endif