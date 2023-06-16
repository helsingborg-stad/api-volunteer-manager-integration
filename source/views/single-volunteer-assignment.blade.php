@php use APIVolunteerManagerIntegration\Model\VolunteerAssignment; @endphp
@php
    /** @var  VolunteerAssignment $volunteerAssignment */
@endphp


@extends('templates.single')

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
        @if (!empty($volunteerAssignmentViewModel['signUp']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.sign-up', ['viewModel' => (object) $volunteerAssignmentViewModel['signUp']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['contact']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.contact', ['viewModel' => (object) $volunteerAssignmentViewModel['contact']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['modal']))
            <div>
                @include('volunteer-assignment.sign-up-modal', ['viewModel' => (object) $volunteerAssignmentViewModel['modal']])
            </div>
        @endif
    </div>
    </div>
@stop