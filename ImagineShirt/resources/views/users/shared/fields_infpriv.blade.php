@php
    $ro = $readonlyData ? 'readonly' : '';
@endphp

<div class="form-group">
    <label for="inputName">Nome</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value = "{{ old('name', $user->name) }}" {{ $ro }}>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" value = "{{ old('email', $user->email) }}" {{ $ro }}>
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>