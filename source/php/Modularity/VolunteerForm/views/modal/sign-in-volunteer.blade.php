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
'animation' => 'scale-up',
'classList' => ['c-modal--centered', 'c-modal--normalized']
])
<div class='u-text-align--center'>
    @typography()
    Logga in för att registrera dig som volontär.
    @endtypography
</div>

@slot('bottom')
    <div class='c-stack' style='max-width:19rem;margin:auto;'>
        @foreach($viewModel->buttons as $props)
            <div>
                @button($props)
                @endbutton
            </div>
        @endforeach
    </div>
@endslot
@endmodal