@php
    /** @var  object $viewModel */
@endphp

@extends('volunteer-assignment.modal.template.assignment')

@section('modal-bottom')
    <div class='o-stack--3'>
        <div class='o-stack--1 u-text-align--center'>
            <div>
                @typography(['classList' => ['u-margin__top--0'], 'element' => 'h2'])
                {{ $viewModel->footer->heading }}
                @endtypography
            </div>

            <div>
                @typography(['classList' => ['u-margin__top--0'], 'element' => 'p'])
                {{ $viewModel->footer->text }}
                @endtypography
            </div>
        </div>
        <div class='c-stack--1 u-text-align--center'>
            @foreach($viewModel->footer->buttons as $props)
                <div>
                    @button($props)
                    @endbutton
                </div>
            @endforeach
        </div>
    </div>
@overwrite