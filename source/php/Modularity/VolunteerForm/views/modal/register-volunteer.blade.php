@php
    /** @var  object $viewModel */
@endphp

@button([
'text' => $viewModel->heading,
'color' => 'primary',
'style' => 'filled',
'attributeList' => ['data-open' => $viewModel->id],
'classList' => ['js-press-on-dom-loaded', 'u-display--none']
])
@endbutton

@modal([
'heading' => $viewModel->heading,
'isPanel' => false,
'id' => $viewModel->id,
'overlay' => 'dark',
'size' => 'sm',
'animation' => 'scale-up'
])

<div class="js-volunteer-form"
     data-labels='{{ json_encode($viewModel->registerVolunteerForm['labels'] ?? []) }}'
     data-volunteer-api-uri={{ $viewModel->registerVolunteerForm['volunteerApiUri'] ?? '' }}
     data-sign-out-url={{$viewModel->registerVolunteerForm['signOutUrl']}}></div>
@endmodal