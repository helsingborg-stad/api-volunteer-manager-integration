@php
    /** @var  object $viewModel */
@endphp

@yield('before-modal')

@modal([
'isPanel' => false,
'id' => $viewModel->id,
'overlay' => 'dark',
'size' => 'sm',
'animation' => 'scale-up',
'classList' => ['c-modal--normalized', 'c-modal--assignment'],
'closeButtonText' => $viewModel->closeButtonText,
])

@card([
'image' => $viewModel->assignment->image,
'heading' => $viewModel->assignment->title,
'meta' => $viewModel->assignment->employer,
'metaFirst' => true,
'context' => ['archive', 'archive.list', 'archive.list.card'],
'containerAware' => true,
'hasPlaceholder' => false,
'classList' => ['u-height--100', 'c-card--flat', 'u-text-align--center']
])
@endcard

@slot('bottom')
    @yield('modal-bottom')
@endslot
@endmodal
