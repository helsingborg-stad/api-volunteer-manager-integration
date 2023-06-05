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
                <div class='c-highlight u-display--inline-block c-highlight--outline u-padding--2'>
                    @foreach($viewModel->signUpContact as $label => $value)
                        @typography(['variant' => 'p u-margin__top--0']){{$value}}
                        @endtypography
                    @endforeach
                </div>
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

    </div>
</div>