@extends('layouts.master')

@section('title', 'Casos COVID-19 en Costa Rica')

@section('content')
    <div class="content">
        <div class="title">
            @lang('Casos en ') {{ $report->country }}
            <div class="title">
                <span>{{ $report->latitude }}/{{ $report->longitude }}</span>
            </div>
        </div>

        <ul class="groups">
            <li><span class="confirmed">{{ $report->confirmed }}</span> <p>@lang('confirmados')</p></li>
            <li><span class="deaths">{{ $report->deaths }}</span> <p>@lang('fallecidos')</p></li>
            <li><span class="recovered">{{ $report->recovered }}</span> <p>@lang('recuperados')</p></li>
            <li><span class="active">{{ $report->active }}</span> <p>@lang('activos')</p></li>
        </ul>

        <div class="date">
            @lang('Última actualización:') <span>{{ $report->update }}</span>
        </div>
    </div>
@stop