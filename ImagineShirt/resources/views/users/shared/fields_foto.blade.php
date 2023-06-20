<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <img alt="{{$user->name}}" src="{{$user->fullPhotoUrl}}" class="rounded-circle img-responsive mt-2" width="128" height="128" style="margin-bottom: 10px">
        </div>
    </div>
</div>

@if($allowUpload)
    <div class="mt-2">
        <label for="formFile" class="form-label">Escolha uma imagem</label>
        <input class="form-control" type="file" id="formFile">
    </div>
@endif