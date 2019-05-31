{!! Form::open(['url' => '/processform', 'class' => 'form-horizontal']) !!}

	<!-- Text -->
	<div class="form-group">
	    {!! Form::label('name', 'Your Name') !!}
    	    {!! Form::text('name', null, ['class' => 'form-control']) !!}
	</div>

        <!-- Email -->
        <div class="form-group">
            {!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
            </div>
        </div>
 
        <!-- Password -->
        <div class="form-group">
            {!! Form::label('password', 'Password:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password']) !!}
                <div class="checkbox">
                    {!! Form::label('checkbox', 'Checkbox') !!}
                    {!! Form::checkbox('checkbox') !!}
                </div>
            </div>
        </div>
 
        <!-- Text Area -->
        <div class="form-group">
            {!! Form::label('textarea', 'Textarea', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('textarea', $value = null, ['class' => 'form-control', 'rows' => 3]) !!}
                <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
            </div>
        </div>
 
        <!-- Radio Buttons -->
        <div class="form-group">
            {!! Form::label('radios', 'Radios', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="radio">
                    {!! Form::label('radio1', 'This is option 1.') !!}
                    {!! Form::radio('radio', 'option1', true, ['id' => 'radio1']) !!}
 
                </div>
                <div class="radio">
                    {!! Form::label('radio2', 'This is option 2.') !!}
                    {!! Form::radio('radio', 'option2', false, ['id' => 'radio2']) !!}
                </div>
            </div>
        </div>
 
        <!-- Select With One Default -->
        <div class="form-group">
            {!! Form::label('select', 'Select w/Default', ['class' => 'col-lg-2 control-label'] )  !!}
            <div class="col-lg-10">
                {!!  Form::select('select', ['S' => 'Small', 'L' => 'Large', 'XL' => 'Extra Large', '2XL' => '2X Large'],  'S', ['class' => 'form-control' ]) !!}
            </div>
        </div>
 
        <!-- Select Multiple -->
        <div class="form-group">
            {!! Form::label('multipleselect[]', 'Multi Select', ['class' => 'col-lg-2 control-label'] )  !!}
            <div class="col-lg-10">
                {!!  Form::select('multipleselect[]', ['honda' => 'Honda', 'toyota' => 'Toyota', 'subaru' => 'Subaru', 'ford' => 'Ford', 'nissan' => 'Nissan'], $selected = null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
            </div>
        </div>
 
        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>
 
 
    {!! Form::close()  !!}
