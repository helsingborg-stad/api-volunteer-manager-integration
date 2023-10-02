@php
    /** @var  object $viewModel */
@endphp

@extends('volunteer-assignment.modal.template.assignment')

@section('before-modal')
    @button([
    'text' => 'lol',
    'color' => 'primary',
    'style' => 'filled',
    'attributeList' => ['data-open' => $viewModel->id],
    'classList' => ['js-show-assignment-sign-up-dialog', 'u-display--none']
    ])
    @endbutton
@endsection

@section('modal-bottom')
    <div class="js-assignment-sign-up"
         data-labels='{{ json_encode($viewModel->labels) }}'
         data-volunteer-api-uri='{{ $viewModel->volunteerApiUri }}'
         data-volunteer-app-secret='{{$viewModel->volunteerAppSecret}}'
         data-sign-out-url={{$viewModel->signOutUrl}}></div>
@overwrite