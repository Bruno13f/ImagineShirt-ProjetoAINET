@php
    $ro = $readonlyData ? 'readonly' : '';
@endphp

<div class="form-group">
    <label for="inputName">Nome</label>
    <input type="text" class="form-control" id="inputName" value = "{{$user->name}}" {{ $ro }}>
</div>
<div class="form-group">
    <label for="inputEmail4">Email</label>
    <input type="email" class="form-control" id="inputEmail4" value = "{{$user->email}}" {{ $ro }}>
</div>