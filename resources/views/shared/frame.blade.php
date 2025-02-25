@extends('layouts.app')

@section('content')
<div class="container">
    <iframe src="{{ request()->query('url') }}" style="width:100%; height:80vh; border:none;"></iframe>
</div>
@endsection
