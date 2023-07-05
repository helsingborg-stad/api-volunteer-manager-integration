@php
    /** @var  object $viewModel */
@endphp
<div>
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
        Du måste vara registrerad som volontär för att kunna anmäla dig till uppdraget.
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
</div>