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
        @foreach($viewModel->contact as $item)
            @collection__item(['link' => $item['link'] ?? null])

            @if(!empty($item['icon']))
                @slot('prefix')
                    <div class="c-collection__icon">
                        @icon(['icon' => $item['icon'], 'size' => 'md'])
                        @endicon
                    </div>
                @endslot
            @endif

            @typography(){{$item['value']}}@endtypography
            @endcollection__item

        @endforeach
        @endcollection


    </div>

</div>

