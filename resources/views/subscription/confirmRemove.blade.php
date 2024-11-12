@extends('layout.app')
@section('body')
        <div class="py-2">
        {{ __('subscription.confirmRemoveHelp') }} {{ $shift->title }} : {{ $shift->start }} - {{ $shift->end }}
        </div>
        <form method="post" action="{{route('plan.subscription.doConfirmRemove', [$plan, $shift,$confirmation])}}">
            @csrf
            <button type="submit" class="my-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                {{__('plan.submit')}}
            </button>
        </form>
    </div>
@endsection
