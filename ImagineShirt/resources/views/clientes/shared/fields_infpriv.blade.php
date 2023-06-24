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
    <label for="inputNif">NIF</label>
    <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif" value = "{{ old('nif', $user->cliente->nif )}}" {{ $ro }}>
    @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="inputAddress">Morada</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" value = "{{ old('address', $user->cliente->address) }}" {{ $ro }}>
    @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <div class="form-group">
        <label for="inputRef">Referência de Pagamento</label>
        <input type="text" class="form-control @error('default_payment_ref') is-invalid @enderror" name="default_payment_ref" id="inputRef" value="{{ old('default_payment_ref', $user->cliente->default_payment_ref)}}" {{ $ro }}>
        @error('default_payment_ref')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="form-group">
    <div class="form-group" style="display:flex; align-items: center;">
        <span>Método de Pagamento</span>
    </div>
    <div class="form-group" style="display:flex; align-items: center;">
        <select class="@error('default_payment_type') is-invalid @enderror" name="default_payment_type" id="inputMetodoPagamento" {{ $select }}>
            <option {{empty($user->cliente->default_payment_type) ? 'selected' : ''}}></option>
            <option value="PAYPAL" {{ old('default_payment_type', $user->cliente->default_payment_type) === 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
            <option value="MC" {{ old('default_payment_type', $user->cliente->default_payment_type) === 'MC' ? 'selected' : ''}}>Mastercard</option>
            <option value="VISA" {{ old('default_payment_type', $user->cliente->default_payment_type)  === 'VISA' ? 'selected' : ''}}>Visa</option>
        </select>
        @error('default_payment_type')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>