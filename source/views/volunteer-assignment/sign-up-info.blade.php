@php
    /** @var  object $viewModel */
@endphp


<div class='c-highlight u-padding--3'>
    <div class='c-stack'>
        <div>
            @typography(['element' => 'h2'])
            {{$viewModel->title ?? ''}}
            @endtypography

            @if (!empty($viewModel->instructions))
                @typography(['element' => 'p'])
                {{$viewModel->instructions}}
                @endtypography
            @endif

            @if (!empty($viewModel->dueDate))
                @typography(['element' => 'p'])
                @typography(['element' => 'b'])Sista ansöknings
                datum:@endtypography {{$viewModel->dueDate}}
                @endtypography
            @endif
        </div>

        @if (!empty($viewModel->signUpContact))
            <div>

                @collection([ 'unbox' => true, 'bordered' => true])
                @foreach($viewModel->signUpContact as $icon => $value)
                    @collection__item([
                    'icon' => $icon
                    ])
                    @typography(){{$value}}@endtypography
                    @endcollection__item
                @endforeach
                @endcollection

            </div>
        @endif

        @if (empty($viewModel->signUpContact) && !empty($viewModel->signUpUrl))
            <div>
                @button([
                'text' => $viewModel->signUpUrl['label'],
                'color' => 'primary',
                'style' => 'filled',
                'href' => $viewModel->signUpUrl['url']
                ])
                @endbutton
            </div>
        @endif


        @if (empty($viewModel->signUpContact) && !empty($viewModel->signUpButton))
            <div>
                @button([
                'text' => $viewModel->signUpButton['label'],
                'color' => 'primary',
                'style' => 'filled',
                'attributeList' => ['data-open' => $viewModel->signUpButton['modalId']],
                ])
                @endbutton
            </div>
        @endif

    </div>
</div>

