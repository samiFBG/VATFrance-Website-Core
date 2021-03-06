<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCRosterMember;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Booking;
use App\Models\ATC\Mentor;
use App\Models\ATC\MentoringRequest;
use App\Models\ATC\SoloApproval;
use App\Models\Users\DiscordData;
use App\Models\Users\User;
use App\Models\Users\UserEmailPreference;
use App\Models\Users\UserSetting;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GDPRController extends Controller
{
    public function download()
    {
        $userData = User::where('id', auth()->user()->id)->first();
        $userSettings = UserSetting::where('id', auth()->user()->id)->first();
        $userEmail = UserEmailPreference::where('id', auth()->user()->id)->first();
        $userDiscord = DiscordData::where('user_id', auth()->user()->id)->first();

        // ATC
        $atcBookings = Booking::where('user_id', auth()->user()->id)->get();
        $atcRoster = ATCRosterMember::where('id', auth()->user()->id)->first();
        $atcStudent = ATCStudent::where('id', auth()->user()->id)->first();
        $atcMentoringReq = MentoringRequest::where('student_id', auth()->user()->id)->first();
        $atcMentor = Mentor::where('id', auth()->user()->id)->first();
        $atcSolo = SoloApproval::where('student_id', auth()->user()->id)->get();

        $pdf = PDF::loadView('gdpr_gb', compact(
            'userData',
            'userSettings',
            'userEmail',
            'userDiscord',
            'atcBookings',
            'atcRoster',
            'atcStudent',
            'atcMentoringReq',
            'atcMentor',
            'atcSolo',
            ))->setPaper('a4', 'landscape');
        $dateToday = Carbon::today()->format('Y-m-d');
        return $pdf->stream($dateToday.'_GDPR_DATA_'.auth()->user()->vatsim_id.'.pdf');
    }
}
