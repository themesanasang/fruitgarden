<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CalendarM  extends Model
{
    use Notifiable;

    protected $table = 'f_calendars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'detail', 'start_date', 'end_date', 'save_user'
    ];

}
