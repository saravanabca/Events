@extends('layouts.app')

@php
$title = 'events';
@endphp

@section('custom_style')


@endsection

@section('content')
@include('layouts.top_navbar')
<div class="main-div">
    <div class="main_head1 d-flex">
        <p class="page_heading">Event Details</p>

        <button class="create_btn ms-auto add_event_btn">Add New
            event</button>
    </div>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Event Descrption</th>
                <th>Event Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal " id="add_event" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog event-dialog modal-l">
            <div class="modal-content">
                <p class="event_add_title">Add event Details</p>

                <div class="modal-header">

                </div>

                <div class="modal-body">
                    <form id="event_add_form">
                        <div class="event_add_main">
                            <div class="row">
                                <div class="col col-md-12">
                                    <div class="form-floating text-center w-100">
                                        <input type="text" class="form-control" id="eventName" placeholder="Event Name"
                                            name="name">
                                        <label for="eventName">Event Name</label>
                                        <div class="error-message" id="eventName_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating w-100">

                                        <input type="date" class="form-control" id="eventDate" placeholder="event Date"
                                            name="event_date">
                                        <label for="eventDate">Event Date</label>

                                        <div class="error-message" id="eventDate_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <div class="form-floating w-100">

                                        <input type="text" class="form-control" id="eventDescrption"
                                            placeholder="event Descrption" name="event_descrption">
                                        <label for="eventDescrption">Event Descrption</label>

                                        <div class="error-message" id="eventDescrption_error"></div>

                                    </div>
                                </div>

                                <div class="col col-md-12 mt-4">
                                    <p>Event Image</p>
                                    <input type="file" class="form-control" id="eventImage" placeholder="Event Image"
                                        name="image">
                                    <div class="error-message" id="eventImage_error"></div>
                                    <img src="" id="previewImage" alt="">
                                </div>

                            </div>

                            <div class="d-flex mt-4">
                                <div class="ms-auto">
                                    <button type="button" class="cancel_btn " data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button>
                                    <button type="submit" class="save_event_details">Save</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



</div>
@endsection

@section('custom_scripts')

<script src="{{asset('js/event.js') }}"></script>

@endsection