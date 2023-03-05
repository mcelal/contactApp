<?php

namespace App\Http\Controllers;

use App\Enums\ContactItemTypeEnum;
use App\Models\ContactItem;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $report = ContactItem::query()
            ->select([
                'value',
                DB::raw('count(id) as total'),
            ])
            ->whereHas('contact', function (Builder $builder) {
                $builder->where('user_id', Auth::id());
            })
            ->where('type', '=', ContactItemTypeEnum::LOCATION)
            ->groupBy(['value'])
            ->orderBy('total', 'desc')
            ->paginate(10);

        $people = [];
        $phone = [];
        foreach ($report->items() as $item) {
            // This location total people
            $check = ContactItem::query()
                ->select([
                    DB::raw('COUNT(DISTINCT contact_id) AS people')
                ])
                ->leftJoin('contacts', 'contacts.id', '=', 'contact_items.contact_id')
                ->where('contact_items.type', '=', ContactItemTypeEnum::LOCATION)
                ->where('contact_items.value', '=', $item->value)
                ->where('contacts.user_id', '=', Auth::id())
                ->first();

            $people[$item->value] = $check->people;

            // This location total phone
            $check = ContactItem::query()
                ->where('type', '=', ContactItemTypeEnum::PHONE)
                ->whereIn('contact_id', function (\Illuminate\Database\Query\Builder $builder) use ($item) {
                    $builder
                        ->from('contact_items')
                        ->select([
                            'contact_id',
                        ])
                        ->leftJoin('contacts', 'contacts.id', '=', 'contact_items.contact_id')
                        ->where('type', '=', ContactItemTypeEnum::LOCATION)
                        ->where('value', '=', $item->value)
                        ->where('contacts.user_id', '=', Auth::id());
                })
                ->count();

            $phone[$item->value] = $check;
        }

        return view('report', compact('report', 'people', 'phone'));
    }
}
