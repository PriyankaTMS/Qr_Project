<?php

namespace App\Exports;

use App\Models\StallUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StallVisitorsExport implements FromCollection, WithHeadings
{
    protected $stallId, $date;

    public function __construct($stallId, $date)
    {
        $this->stallId = $stallId;
        $this->date = $date;
    }

    public function collection()
    {
        return StallUser::where('stall_id', $this->stallId)
            ->whereDate('scanned_at', $this->date)
            ->with('user')
            ->get()
            ->map(function ($item) {
                return [
                    $item->user->name ?? '',
                    $item->user->email ?? '',
                    $item->user->phone ?? '',
                    $item->user->comp_name ?? '',
                    $item->user->city ?? '',
                    $item->user->occupation ?? '',
                    $item->scanned_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Mobile',
            'Company Name',
            'City',
            'Occupation',
            'Scanned Date'
        ];
    }
}
