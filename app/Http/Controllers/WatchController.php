<?php

namespace App\Http\Controllers;

use App\Enum\WatchableEnum;
use App\Enum\WatchEnum;
use App\Repository\WatchableFactory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WatchController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'action' => [
                'required',
                Rule::in(WatchEnum::toArray())
            ],
            'type' => [
                'required',
                Rule::in(WatchableEnum::toArray())
            ]
        ]);

        $repository = WatchableFactory::process(
            $request->get('type')
        );

        match($request->get('action')) {
            WatchEnum::WATCH->value => $repository->watch(),
            WatchEnum::UNWATCH->value => $repository->unWatch(),
            WatchEnum::WATCH_ALL->value => $repository->watchAll(),
            WatchEnum::UNWATCH_ALL->value => $repository->unwatchAll(),
        };

        return back();
    }
}
