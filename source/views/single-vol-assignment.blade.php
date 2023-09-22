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
        @if (!empty($volunteerAssignmentViewModel['signUpInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.sign-up-info', ['viewModel' => (object) $volunteerAssignmentViewModel['signUpInfo']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['employerInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.employer-info', ['viewModel' => (object) $volunteerAssignmentViewModel['employerInfo']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['contactInfo']))
            <div class='u-margin__top--5'>
                @include('volunteer-assignment.contact-info', ['viewModel' => (object) $volunteerAssignmentViewModel['contactInfo']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['loginModal']))
            <div>
                @include('volunteer-assignment.modal.login', ['viewModel' => (object) $volunteerAssignmentViewModel['loginModal']])
            </div>
        @endif

        @if (!empty($volunteerAssignmentViewModel['signUpModal']))
            <div>
                @include('volunteer-assignment.modal.sign-up', ['viewModel' => (object) $volunteerAssignmentViewModel['signUpModal']])
            </div>
        @endif
    </div>
@stop