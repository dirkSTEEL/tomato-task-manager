@extends('layout.app')
@section('content')
    <task-table :project="{{ $project }}" :task_groups="{{ $task_groups }}"></task-table>
@stop