@php
    if ($readonlyData){
        $ro = 'readonly';
        $select = 'disabled';
    }else{
        $ro = '';
        $select = '';
    }
@endphp

<div class="form-group">
    <label for="inputAddress">Morada</label>
    <input type="text" class="form-control" id="inputAddress" value = "{{$user->cliente->address}}" {{ $ro }}>
</div>
<div class="form-row">
    <div class="form-group col-md-3" style="display:flex; align-items: center;">
        <span>Método de Pagamento</span>
    </div>
    <div class="form-group col-md-3" style="display:flex; align-items: center;">
        <select id="inputMetodoPagamento" {{ $select }}>
        <option {{empty($user->cliente->default_payment_type) ? 'selected' : ''}}></option>
        <option value="Paypal" {{ $user->cliente->default_payment_type === 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
        <option value="MC" {{$user->cliente->default_payment_type === 'MC' ? 'selected' : ''}}>MC</option>
        <option value="Visa" {{ $user->cliente->default_payment_type === 'Visa' ? 'selected' : ''}}>Visa</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="inputRef">Referência de Pagamento</label>
        <input type="text" class="form-control" id="inputRef" value="{{$user->cliente->default_payment_ref}}" {{ $ro }}>
    </div>
</div>