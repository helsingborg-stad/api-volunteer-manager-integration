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
        @foreach($viewModel->employer as $icon => $value)
            @collection__item([
            ])
            @typography(){!! $value !!}@endtypography
            @endcollection__item

        @endforeach
        @endcollection


    </div>

</div>

