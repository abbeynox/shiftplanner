<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\RepetitionType;
use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class ShiftController extends Controller
{
    /**
     * Show the form for creating a new shift.
     *
     * @param Plan $plan
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Plan $plan)
    {
        // user needs access to plan to create a new shift
        $this->auth($plan);
        $this->authorize("create", Shift::class);
        $groups = $this->getGroups($plan);
        $shift = new Shift();
        return view('shift.create', ['plan' => $plan, 'shift' => $shift, 'groups' => $groups,
             'repetition_types' => RepetitionType::cases()], );
    }

    /**
     * Store a newly created shift in storage.
     *
     * @param StoreShiftRequest $request
     * @param Plan $plan
     * @return Response
     */
    public function store(StoreShiftRequest $request, Plan $plan)
    {
        $this->auth($plan);
        $this->authorize("create", Shift::class);
        $data = $request->validated();
        $plan->shifts()->create($data);
        if ($data['repetition_type'] != RepetitionType::None) {
            for ($i = 0; $i < $data['repetition']-1; ++$i) {
                $data['start'] = RepetitionType::timeDiff($data['repetition_type'], $data['start']);
                $data['end'] = RepetitionType::timeDiff($data['repetition_type'], $data['end']);
                $plan->shifts()->create($data);
            }
        }
        Session::flash('info', __('shift.successfullyCreated'));
        return redirect()->route('plan.admin', ['plan' => $plan]);
    }

    /**
     * Show the form for editing a shift.
     *
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function edit(Plan $plan, Shift $shift)
    {
        $this->auth($plan);
        $this->authorize('update', $shift);
        $groups = $this->getGroups($plan);
        return view('shift.create', ['shift' => $shift, 'plan' => $plan, 'groups' => $groups]);
    }

    /**
     * Update the a shift in storage.
     *
     * @param StoreShiftRequest $request
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function update(StoreShiftRequest $request, Plan $plan, Shift $shift)
    {
        $this->auth($plan);
        $this->authorize('update',$shift);
        $data = $request->validated();
        $shift->update($data);
        Session::flash('info', __('shift.successfullyUpdated'));
        return redirect()->route('plan.admin', ['plan' => $plan]);

    }

    /**
     * Remove the specified shift from storage.
     *
     * @param Shift $shift
     * @return Response
     */
    public function destroy(Plan $plan, Shift $shift)
    {
        $this->auth($plan);
        $this->authorize('forceDelete', $shift);
        $shift->forceDelete();
        Session::flash('info', __('shift.successfullyDestroyed'));
        return redirect()->route('plan.admin', ['plan' => $plan]);
    }

    /**
     * Return the number of shift groups present for the plan
     * A group is an addition order option for shifts
     * @param Plan $plan
     * @return int
     */
    private function getGroups(Plan $plan): int
    {
        return Shift::select('group')
            ->distinct()
            ->whereBelongsTo($plan)
            ->get()
            ->count();
    }
}
