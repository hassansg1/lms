@extends('layouts.master')

@section('title') {{ $heading }} @endsection
@section('content')
    @include('layouts.top_heading',['heading' => 'Create '. $heading,'goBack' => route($route.'.index')])
    <div class="row">
        <div class="col-lg-12">
            <form class="item_form" method="post" enctype="multipart/form-data" action="{{ route($route.'.store') }}">
                @include($route.'.form')
                @include('components.form_submit_btns')
            </form>
            @include('components.asset_popups')
        </div>
    </div>
@endsection
