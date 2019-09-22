@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ul class="stories-index-list list-unstyled row">
            @foreach ($stories as $story)
                <li class="col-md-6">
                    <a href="{{ route('stories.show', $story) }}" class="text-reset text-decoration-none">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $story->title }}</h3>
                            </div>
                            <div class="card-body">
                                <div>{!! $story->content !!}</div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        
        {{ $stories->links() }}
    </div>
@endsection