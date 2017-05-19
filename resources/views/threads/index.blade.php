@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h3 class="flex">
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </h3>

                                <strong>
                                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                                </strong>
                            </div>
                        </div>

                        <div class="panel-body">
                            <article>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                            <hr>
                        </div>
                    </div>
                @empty
                    <p>There are no relevant results at this time.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
