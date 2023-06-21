<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <img id="imagemPaginaPerfil" alt="{{$user->name}}" src="{{$user->fullPhotoUrl}}" class="rounded-circle img-responsive mt-2">
        </div>
    </div>
</div>

@if($allowElimPhoto && $user->photo_url)
<form id="form_delete_photo" action="{{ route('user.foto.destroy', $user) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="col-md-12 justify-content-center" style = "display:flex; margin-top: 10px">
        <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Eliminar Foto</button>   
    </div>
</form>
@endif

@if($allowUpload)
<form id="form_user" novalidate class="needs-validation" method="POST"
                        action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
    <div class="mt-2">
        <label for="formImage" class="form-label">Escolha uma imagem</label>
        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="formImage">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif