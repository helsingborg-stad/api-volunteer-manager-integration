@php
    /** @var  object $viewModel */
@endphp

<div>
    @button([
    'text' => 'Register as a volunteer',
    'color' => 'primary',
    'style' => 'filled',
    'attributeList' => ['data-open' => $viewModel->id]
    ])
    @endbutton
</div>

@modal([
'heading' => $viewModel->heading,
'isPanel' => false,
'id' => $viewModel->id,
'overlay' => 'dark',
'size' => 'sm',
'animation' => 'scale-up'
])
This is the content of the modal. It can also be another component.

@slot('bottom')
    <div>
        @foreach($viewModel->buttons as $props)
            @button($props)
            @endbutton
        @endforeach
    </div>
@endslot
@endmodal