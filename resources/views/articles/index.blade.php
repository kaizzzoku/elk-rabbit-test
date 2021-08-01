@extends('layouts.app')

@section('content')
    <h1>Articles</h1>
    <form action="" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="q" class="form-control" placeholder="Articles" aria-label="Articles" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
            </div>
        </div>
    </form>

    @foreach($articles as $a)
        <div class="card m-2">
            <h4 class="m-2 card-title">{{ $a->title }}</h4>
            <h5 class="m-2 card-subtitle text-muted">Author: {{ $a->author  }}</h5>
        </div>
    @endforeach
    {{  $articles->links() }}
@endsection
