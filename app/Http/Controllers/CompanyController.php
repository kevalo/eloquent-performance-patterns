<?php

namespace App\Http\Controllers;

use App\Enums\BillStatus;
use App\Models\Bill;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyController
{
    public function index(): JsonResource
    {
        $data = Company::all();

        return JsonResource::collection($data);
    }

    public function show(int $id): JsonResource
    {
        $data = Company::query()->findOrFail($id);

        return JsonResource::make($data);
    }

    public function users(int $id): JsonResource
    {
        $data = Company::query()->with('users')->findOrFail($id);

        return JsonResource::make($data);
    }

    public function bills(int $id): JsonResource
    {
        $data = Company::query()->with('bills')->findOrFail($id);

        return JsonResource::make($data);
    }

    public function report(int $id): JsonResource
    {
        $company = Company::query()->findOrFail($id);

        $totalUsers = User::query()->where('company_id', $id)->count();
        $totalBills = Bill::query()->where('company_id', $id)->count();

        // top 5 users with most value paid
        $topUsers = User::query()->where('company_id', $id)
            ->whereHas('bills', function (Builder $query) {
                $query->where('status', BillStatus::PAID->value)->orderByDesc('payment');
            })
            ->with('bills', function (Builder $query) {
                $query->where('status', BillStatus::PAID->value);
            })
            ->take(5)->get();

        $usersData = $topUsers->map(static function (User $user) {
            return ['user' => $user->first_name.' '.$user->last_name, 'total' => $user->bills()->sum('payment')];
        })->sortBy(['total', 'asc']);

        // top 5 most expensive pending bills
        $topPendingBills = Bill::query()->where('company_id', $id)
            ->where('status', BillStatus::PENDING->value)
            ->whereHas('users')
            ->orderByDesc('payment')
            ->take(5)->get();

        $data = [
            'company' => $company->name,
            'users' => $totalUsers,
            'bills' => $totalBills,
            'topUsers' => $usersData->reverse()->map(static function (array $item) {
                return $item['user'].' - $'.$item['total'];
            })->toArray(),
            'topPendingBills' => $topPendingBills->map(static function (Bill $bill) {
                return $bill->users->pluck('first_name')->flatten()->implode(', ').'. '.$bill->created_at->format('d/m/Y').' - $'.number_format($bill->payment);
            }),
        ];

        return JsonResource::make($data);
    }
}
