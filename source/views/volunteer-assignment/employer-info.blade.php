@php
    /** @var  object $viewModel */
@endphp


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
    </div>
    <div>
        @collection([ 'unbox' => true, 'bordered' => true])
        @foreach($viewModel->employer as $value)
            @collection__item([
            ])

            @if(!empty($value['icon']))
                @slot('prefix')
                    <div class="c-collection__icon">
                        @icon(['icon' => $value['icon'], 'size' => 'md'])
                        @endicon
                    </div>
                @endslot
            @endif


            @typography(){!! $value['value'] !!}@endtypography
            @endcollection__item

        @endforeach
        @endcollection
    </div>
</div>

