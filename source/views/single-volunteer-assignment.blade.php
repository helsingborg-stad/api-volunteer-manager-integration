@php use APIVolunteerManagerIntegration\Model\VolunteerAssignment; @endphp
@php
    /** @var  VolunteerAssignment $volunteerAssignment */
@endphp

@extends('templates.single')

@section('sidebar-right')

    <ul>
        @if (!empty($volunteerAssignment->employee->contacts))
            @foreach($volunteerAssignment->employee->contacts as $contact)
                @card([])
                <div class="c-card__body">
                    <ul class="unlist">
                        <li>Name: {{$contact->name}}</li>
                        <li>Email: {{$contact->email}}</li>
                        <li>Phone: {{$contact->phone}}</li>
                    </ul>
                </div>
                @endcard
            @endforeach
        @endif
    </ul>

@stop