@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{ __('ログインしています') }}
        </div>
        <div class="col-md-8 mt-5">
            <a href="/tasks">ToDoリストを見る</a>
        </div>
    </div>
</div>
@endsection
