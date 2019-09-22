@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">{{ $story->title }}</div>
                    <div class="card-body">{!! $story->content !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection