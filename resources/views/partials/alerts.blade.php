@if(count($errors) > 0)
    <message title="{{ trans('category::main.form.error') }}" type="is-danger">
        <ul class="add-padding-16">
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </message>
@endif

@if(session()->has('error'))
    <message title="{{ trans('category::main.form.error') }}" type="is-danger">{{ session('error') }}</message>
@elseif(session()->has('success'))
    <message title="{{ trans('category::main.form.success') }}" type="is-success">{{ session('success') }}</message>
@endif