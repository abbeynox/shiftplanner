@extends('layout.app')
@section('body')
    <h1 class="text-3xl mb-2">{{ $shift->title }}</h1>
    <div>{{$shift->desripion}}</div>
    <div class="mb-10"> {{$shift->start}} - {{$shift->end}}</div>
    @if(isset($subscription->id) && $subscription->id > 0)
        <form method="post" action="{{route('plan.shift.subscription.update', ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription])}}" class="subscription">
            @method("put")
    @else
        <form method="post" action="{{route('plan.shift.subscription.store', ['plan' => $plan, 'shift' => $shift])}}" class="subscription">
    @endif
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">
            <div class="grid grid-rows-4 grid-flow-row gap-4 md:grid-flow-col mb-4">
                <div>
                    <label for="type" class="block text-gray-700 mb-1">{{__("subscription.nameDesc")}}</label>
                    <input id="name" name="name" type="text" class="@error('type') border-red-500 @enderror w-full block text-black p-1 text-lg border rounded" value="{{old('name', $subscription->name)}}">
                    @error('name')
                    <div class="text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="title" class="block text-gray-700 mb-1">{{__("subscription.phone")}}</label>
                    <input id="phone" name="phone" type="tel" class="@error('phone') border-red-500 @enderror w-full block text-black p-1 text-lg border rounded" value="{{old('phone', $subscription->phone)}}">
                    @error('phone')
                    <div class="text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-gray-700 mb-1">{{__("subscription.email")}}</label>
                    <input id="email" name="email" type="email" class="@error('email') border-red-500 @enderror w-full block text-black p-1 text-lg border rounded" value="{{old('email', $subscription->email)}}">
                    @error('email')
                    <div class="text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="px-1 py-2">
                    <input id="notification" name="notification" type="checkbox" class="@error('notification') border-red-500 @enderror w-auto inlineblock text-black p-1     text-lg border rounded" value="1" {{ old('notification', $subscription->notification) ? 'checked' : '' }} > {{__("subscription.notifyMe")}}
                    @error('notification')
                        <div class="text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row-span-3 flex flex-col">
                    <label for="comment" class="block text-gray-700 mb-1">{{__("subscription.comment")}}</label>
                    <textarea id="comment" name="comment" class="@error('comment') border-red-500 @enderror w-full h-full block text-black p-1 text-lg border rounded">{{old('comment', $subscription->comment)}}</textarea>
                    @error('comment')
                    <div class="text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="my-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                @if(isset($subscription->id) && $subscription->id > 0)
                    {{__('subscription.update')}}
                @else
                    {{__('subscription.save')}}
                @endif
            </button>
            <a class="my-button" href="{{ url()->previous() }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{__('subscription.cancel')}}
            </a>
        </form>
@endsection
