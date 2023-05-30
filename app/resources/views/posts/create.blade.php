@extends('layouts.app')

@section('content')


<form action="post">
    <textarea name="" id="" cols="30" rows="10" style="height: 100px; resize: none;"></textarea>
    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile02">
            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
        </div>
        <div class="input-group-append">
            <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
        </div>
    </div>
</form>

@endsection
