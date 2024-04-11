@extends('layout.app')
@section('title''Post')

@section('content')
    <div class="row">
        <div class="col-3 left-sidebar">
             @include('shared.left-sidebar') </div>
                <div class="col-6">
                    @include('shared.success-message')
                    <hr>
                    <div class="mt-3">
                        @include('ideas.shared.idea-card')

                    </div>

                </div>
                <div class="col-3  right-sidebar">
                    @include('shared.search-bar')
                    @include('shared.follow-box')
                </div>
        </div>
    @endsection
