@php
    /** @var  object $viewModel */
@endphp

@button([
'text' => 'lol',
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
'size' => 'sm'
])
<div class="js-assignment-sign-up"
     data-labels='{{ json_encode($viewModel->labels) }}'
     data-volunteer-api-uri={{ $viewModel->volunteerApiUri }}
     data-volunteer-app-secret='{{$viewModel->volunteerAppSecret}}'
     data-sign-out-url={{$viewModel->signOutUrl}}></div>
@endmodal