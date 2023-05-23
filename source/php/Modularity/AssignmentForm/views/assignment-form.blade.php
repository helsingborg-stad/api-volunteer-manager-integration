<style>
    .c-field input {
        overflow: hidden;
    }
</style>

<div class="js-assignment-form-app o-container o-container--content u-padding--0 u-margin__x--0"
     data-labels='{{ json_encode($labels) }}'
     data-volunteer-api-uri='{{ $volunteerApiUri }}' data-volunteer-app-secret='{{$volunteerAppSecret}}'></div>