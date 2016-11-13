@extends('layouts.index')
@section('content')
<form class="form-horizontal" method="post" action="{{ route('categories.update',$model->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <fieldset>

        <!-- Form Name -->
        <legend>Form Name</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Jenis Layanan</label>
            <div class="col-md-4">
                <input id="name" name="name" type="text" placeholder="placeholder" class="form-control input-md"
                       value="{{ $model->name }}">

            </div>
        </div>

        <!-- Multiple Checkboxes (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="roles">Roles</label>
            <div class="col-md-4">
                @foreach($roles as $role)
                    <label class="checkbox-inline" for="roles-0">
                            <label>
                                {{ Form::checkbox('pic[]',$role['id'],(in_array($role['id'],$selected) ? true : ''),['class' =>  'minimal'])}}
                                {{ $role['name'] }}</label>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Multiple Radios -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="status">Status</label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="status-0">
                        <input type="radio" name="status" id="status-0" value="1" checked="checked">
                        Active
                    </label>
                </div>
                <div class="radio">
                    <label for="status-1">
                        <input type="radio" name="status" id="status-1" value="0">
                        InActive
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success" id="btn-add" name="btn-add">
                    Update
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </fieldset>
</form>
@endsection
@section('script')
@endsection