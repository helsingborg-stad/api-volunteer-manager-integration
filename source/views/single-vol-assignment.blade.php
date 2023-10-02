@extends('templates.single')

@section('article.content.after')
    <div>
        @if (!empty($volunteerAssignmentViewModel['signUpInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.sign-up-info', [
                    'viewModel' => (object) $volunteerAssignmentViewModel['signUpInfo']
                ])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['employerInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.employer-info', [
                    'viewModel' => (object) $volunteerAssignmentViewModel['employerInfo']
                ])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['contactInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.contact-info', [
                    'viewModel' => (object) $volunteerAssignmentViewModel['contactInfo']
                ])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['loginModal']))
            <div>
                @include('volunteer-assignment.modal.login', [
                    'viewModel' => (object) $volunteerAssignmentViewModel['loginModal']
                ])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['signUpModal']))
            <div>
                @include('volunteer-assignment.modal.sign-up', [
                    'viewModel' => (object) $volunteerAssignmentViewModel['signUpModal']
                ])
            </div>
        @endif
    </div>
@stop