@php use APIVolunteerManagerIntegration\Model\VolunteerAssignment; @endphp
@php
    /** @var  VolunteerAssignment $volunteerAssignment */
@endphp


@extends('templates.single')
{{--

@section('article.content.after')
    <div>
        <div class='u-margin__top--5'>
            @include('volunteer-assignment.sign-up', ['viewModel' => (object) [
                'title' => $volunteerAssignmentLabels['sign_up'],
                'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'dueDate'    =>  '07-11-2023',
                'signUpUrl' => [
                    'url' => 'https://helsingborg.test',
                    'label' => $volunteerAssignmentLabels['sign_up_c2a']
                ],
                'signUpContact2' => [
                    'Name' => 'Nikolas Ramstedt',
                    'Email' => 'nikolas.ramstedt@gmail.com',
                    'Phone' => '0733261515'
                ],
            ]])

        </div>
        <div class='u-margin__top--5'>
            @include('volunteer-assignment.contact', ['viewModel' => (object) [
                'title' => $volunteerAssignmentLabels['contact_us'],
                'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'contact' => [
                    'Name' => 'Nikolas Ramstedt',
                    'Email' => 'nikolas.ramstedt@gmail.com',
                    'Phone' => '0733261515'
                ],
            ]])
        </div>
    </div>
@stop
--}}


@section('article.title.before')

    <style>
        .c-article h1 {
            margin-top: 0 !important;
        }

        .c-article {
            padding-top: 40px;
            width: 100%;
            margin: auto;
        }

        .c-highlight {
            border-radius: var(--c-card-border-radius, var(--radius-lg, calc(var(--base, 8px) * 1.5)));
            background-color: var(--color-complementary-lighter, #fddde5);
        }

        .c-highlight--white {
            background-color: white;
        }

        .c-highlight--transparent {
            background-color: transparent;
        }

        .c-highlight--outline {
            background-color: transparent;
            border: solid 1px;
        }

        .c-stack {
            display: flex;
            flex-direction: column;
        }

        .c-stack > * + * {
            margin-top: calc(var(--base, 8px) * 2)
        }
    </style>
@stop
@section('article.content.after')

    <div>
        <div class='u-margin__top--5'>
            @include('volunteer-assignment.sign-up', ['viewModel' => (object) [
                'title' => $volunteerAssignmentLabels['sign_up'],
                'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'dueDate'    =>  '07-11-2023',
                'signUpUrl' => [
                    'url' => 'https://helsingborg.test',
                    'label' => $volunteerAssignmentLabels['sign_up_c2a']
                ],
                'signUpContact2' => [
                    'Name' => 'Nikolas Ramstedt',
                    'Email' => 'nikolas.ramstedt@gmail.com',
                    'Phone' => '0733261515'
                ],
            ]])

        </div>
        <div class='u-margin__top--5'>
            @include('volunteer-assignment.contact', ['viewModel' => (object) [
                'title' => $volunteerAssignmentLabels['contact_us'],
                //'instructions' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
                'contact' => [
                    'person' => 'Nikolas Ramstedt',
                    'email' => 'nikolas.ramstedt@gmail.com',
                    'phone' => '0733261515'
                ],
            ]])
        </div>

    </div>
    </div>
@stop