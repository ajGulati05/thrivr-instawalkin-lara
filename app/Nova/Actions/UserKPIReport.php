<?php

namespace App\Nova\Actions;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Nova\Exports\UserKPIExport;
class UserKPIReport extends DetachedAction
{
    use InteractsWithQueue, Queueable,SerializesModels;

    /**
     * Get the displayable label of the button.
     *
     * @return string
     */
    public function label()
    {
        return __('Export Users');
    }

    /**
     * Perform the action.
     *
     * @param  ActionFields  $fields
     *
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {


         Excel::download(new UserKPIExport, 'users.xlsx');
        return DetachedAction::message('It worked!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }








}
