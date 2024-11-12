@extends('layout.app')
@section('body')
    @include('partials.flash')

    <div class="text-3xl mb-2">{{ $plan->title }}
      <a class="" href="{{route('plan.edit', ['plan' => $plan])}}">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
      </svg>
      </a>
    </div>


    <div class="py-4">
      {!! __('plan.admin_help') !!}
    </div>

    @if(count($plan->shifts) > 0)
    <div class="py-4">
    <a class="my-button" href="{{route('plan.show', ['plan' => $plan])}}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        {{__('plan.publish')}}
    </a>
    <a class="my-button" href="{{route('plan.admin_subscriptions', ['plan' => $plan])}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        {{__('plan.show_subscriptions')}}
    </a>
    </div>
    @endif

    <br>
    @if(count($plan->shifts) >= 3)
    <a class="my-button" href="{{route('plan.shift.create', ['plan' => $plan])}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        {{__('shift.add')}}
    </a>
    <br>
    @endif

    {{ __('plan.sort_help') }}

    @if(count($plan->shifts) === 0)
        <br>
        <div>{{__('shift.noshifts')}}</div>
        <br>
    @else
      <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="rounded p-2 overflow-x-auto">
              <table class="min-w-full">
        @foreach($plan->shifts as $index => $shift)
            {{--  Header of a new group --}}
            @if($loop->first || ($plan->shifts[$index - 1]->type !== $shift->type))
              @if($shift->type !== "")
                <thead class="">
                <tr><td colspan="6">
                  <div class="m-10"><span class="font-bold rounded bg-green-100 p-5 m-2">{{ $shift->type }}</span></div>
                </td></tr>
                </thead>
              @endif
              <thead class="border-b">
                    <tr>
                        <th class="px-2 text-sm px-0 py-4 text-left">{{__('shift.title')}}</th>
                        <th class="text-sm px-0 py-4 text-left ">{{__('shift.description')}}</th>
                        <th class="text-sm px-0 py-4">{{__('shift.startDesc')}}</th>
                        <th class="text-sm px-0 py-4 text-left">{{__('shift.team_size')}}</th>
                        <th class="text-sm px-0 py-4 text-left">{{__('shift.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
            @endif
                    @if ($index % 2 == 0)
                      <tr class="">
                    @else
                      <tr class="bg-gray-100">
                    @endif
                        <td style="border-radius: 10px 0 0 10px;" class="text-sm px-4 py-1">{{$shift->title}}</td>
                        <td class="text-sm px-4 py-1">{{$shift->description}}</td>
                        <td class="text-sm text-right px-4 py-1 whitespace-nowrap">
                        {!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end) !!}
                        </td>
                        <td class="text-sm px-4 py-1">{{$shift->team_size}}</td>
                        <td style="border-radius: 0 10px 10px 0; class="text-sm px-4 py-1">

                            <a class="my-button mt-4" href="{{route('plan.shift.edit',  ['plan' => $plan, 'shift' => $shift])}}" class="mt-3 mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg></a>
                            <form method="post" action="{{route('plan.shift.destroy', ['plan' => $plan, 'shift' => $shift])}}" style="display:inline" class="delete-shift" data-confirm-delete-msg="{{ __('shift.confirmDelete') }}">
                                @method('delete')
                                @csrf
                                <button type="submit" class="my-button mt-2 mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
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
    <a display="position:absolute" class="my-button" href="{{route('plan.shift.create', ['plan' => $plan])}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        {{__('shift.add')}}
    </a>

    <br>
    <br>

    <div style="float:right;">
    <a class="my-button" href="{{route('plan.export', ['plan' => $plan])}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        {{__('plan.export')}}
    </a>

    <a id="openImportButton" href="#import" class="my-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{__('plan.import')}}
    </a>

    <div style="display:none" id="importForm">
    {{ __('plan.importHelp') }}
    <a id="#import" />
    <form id="importPlanForm" method="post" action="{{route('plan.import', ['plan' => $plan])}}" enctype="multipart/form-data">
    @csrf
    <input type="file"
       id="import" name="import"
       accept="text/csv">
    </form>
    </div>
    </div>

    <br>
    <br>

@endsection
