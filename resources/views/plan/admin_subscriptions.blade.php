@extends('layout.app')
@section('body')
    @include('partials.flash')

    <h1 class="text-3xl mb-2">{{ $plan->title }}</h1>

    <div class="py-4">
      {{ __('plan.admin_subscriptions_help') }}
    </div>

    @if(count($plan->shifts) > 0)
    <div class="py-4">
    <a class="my-button" href="{{route('plan.admin', ['plan' => $plan])}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
        {{__('plan.admin')}}
    </a>
    </div>
    @endif

    <br>
    @if(count($plan->shifts) === 0)
        <br>
        <div>{{__('shift.noshifts')}}</div>
        <br>
    @else
      <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
              <table class="min-w-full">
        @php($x = 0)
        @foreach($plan->shifts as $index => $shift)
            {{--  Header of a new group --}}
            @if($loop->first || ($plan->shifts[$index - 1]->type !== $shift->type))
                    <thead class="border-b">
                    <tr>
                        <th class="text-sm px-2 py-4 text-left"></th>
                        <th class="text-sm px-0 py-4 text-left"></th>
                        <th class="text-sm px-0 py-4 text-left">{{__('subscription.name')}}</th>
                        <th class="text-sm px-0 py-4 text-left">{{__('subscription.phone')}}</th>
                        <th class="text-sm px-0 py-4 text-left">{{__('subscription.email')}}</th>
                        <th class="text-sm px-0 py-4 text-left">{{__('subscription.comment')}}</th>
                        <th class="text-sm px-0 py-4 text-left" colspan="2">{{__('shift.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
            @endif
              @if($loop->first || ($plan->shifts[$index - 1]->type !== $shift->type))
                @if($shift->type !== "")
                  <thead class="">
                  <tr><td colspan="6">
                    <div class="m-10"><span class="font-bold rounded bg-green-100 p-5 m-2">{{ $shift->type }}</span></div>
                  </td></tr>
                  </thead>
                @endif
              @endif

              @foreach($shift->subscriptions as $subscription)
                    @if ($index % 2 == 0)
                      <tr class="">
                    @else
                      <tr class="bg-gray-200">
                    @endif

                    @if ($subscription == $shift->subscriptions->first())
                        <td class="text-left text-sm px-4 py-1"  style="border-radius: 10px 0 0 0;" >{{$shift->title}}</td>
                        <td class="text-sm text-right px-4 py-1 whitespace-nowrap">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end) !!}</td>
                    @else
                        <td colspan="2"  style="border-radius: 10px 0 0 0;" ></td>
                    @endif

                        <td class="px-4">
                            {{$subscription->name}}
                        </td>
                        <td class="px-2">
                            {{$subscription->phone}}
                        </td>
                        <td class="px-2">
                            {{$subscription->email}}
                        </td>
                        <td class="px-2">
                            {{$subscription->comment}}
                        </td>
                        <td class="px-1">
                            <a href="{{route('plan.shift.subscription.edit',  ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription])}}" class="mt-4 my-button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg></a>
                        </td>
                        @if ($loop->index == 0)
                        <td style="border-radius: 0 10px 0 0;" class="px-0">
                        @else
                        <td class="px-0">
                        @endif
                            <form method="post" action="{{route('plan.shift.subscription.destroy', ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription])}}">
                                @method('delete')
                                @csrf
                                <button type="submit" class="mt-4 mr-4 my-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
            @endforeach
            @if ($index % 2 == 0)
              <tr class="">
            @else
              <tr class="bg-gray-200">
            @endif
            @if ($shift->subscriptions->count() === 0)
              <td style="border-radius: 10px 0 0 10px;" class="text-left text-sm px-4 py-1 rounded-">{{$shift->title}}</td>
              <td class="text-sm text-right px-4 py-1 whitespace-nowrap">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end) !!}</td>
              <td style="border-radius: 0 10px 10px 0;" colspan="6">
            @else
              <td colspan=3 style="border-radius: 0 0 0 10px;"></td>
              <td style="border-radius: 0 0 10px 0;" colspan="6">
            @endif
            @if($shift->subscriptions->count() < $shift->team_size)
                <span class="rounded m-4 p-3 bg-red-100 float-right">
                {{$shift->subscriptions->count()}} / {{$shift->team_size}}
                </span>
            @endif
            </td>
            </tr>
        @endforeach
               </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endif

@endsection
