<div class="flex justify-between" style="height: 8%;">
    <div class="flex p-5">
       <img class="w-14 h-14" src="{{ asset('media/logos/logo-sm.png') }}" alt="">
    </div>
    <div class="text-center">
        <h4>Republic of the Philippines</h4>
        <h3>{{ get_config('lgu.name') }}</h3>
        <h4>{{ get_config('lgu.address') }}</h4>
    </div>

    <div class="flex items-center">
        <p class="italic">{{ $appendix ?? null }}</p>
    </div>
</div>