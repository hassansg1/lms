@php
    $units = getUnits();
    $sites = getSites();
    $sub_sites = getSubSites();
@endphp
@extends('layouts.master')

@section('title') {{ $heading }} @endsection
@section('content')
    @include('layouts.top_heading',['heading' => 'Edit '. $heading,'goBack' => route($route.'.index')])
    <div class="row">
        <div class="col-lg-12">
            @include($route.'.edit_form')
        </div>
        @if(isset($item) && $users)
            <hr class="solid">
        <div class="row">
            <div class="col-md-4">
                <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">User Assignment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="{{ isset($item) ? $item->id:'' }}unit_id"
                                                   class="form-label required">Associated with</label>
                                            <select class="form-control select2" name="parent_id"
                                                    id="unit_id" required>
                                                <option value="">Search by Name</option>
                                                @foreach(getLocationsForDropDown('sites',isset($item)?'edit':'create',$model ?? null) as $heading => $locations)
                                                    <optgroup label={{ \App\Models\Location::getTypeToModel($heading) }}>
                                                        @foreach($locations as $location)
                                                            <option
                                                                {{ isset($item) && $item->unit_id == $location->id ? 'selected' : '' }}
                                                                type="{{$location->type}}" value="{{ $location->id }}">{{ $location->text }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="{{ isset($item) ? $item->id:'' }}sub_site_id"
                                                   class="form-label">User Name</label>
                                            <select class="form-control select2" id="user_id" name="user_id">
                                                <option value="">-Select User Id-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="assign_user">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
@include('layouts.vendor-scripts')
