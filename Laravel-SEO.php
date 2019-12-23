<?php
#How to create dynamic SEO using Laravel

#See Database in "seo_manager.sql"

#STEP 1: Create SeoManagerController

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\SeoManager;
use Auth;

class SeoManagerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * [seo_manager View ? Edit method]
     * 
     */
    public function index() {
        $record = SeoManager::find(1);

        $data['record'] = $record;
        $data['active_class'] = 'seo_manager';
        $data['settings'] = FALSE;
        $data['title'] = getPhrase('manage');

        $view_name = getTheme() . '::seo_managers.add-edit';
        return view($view_name, $data);
    }

    public function update(Request $request, $slug) {
        $record = SeoManager::find($slug);

        if ($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $request->validate([
            "seo_title" => "bail|required|max:250",
            "seo_author" => "bail|required|max:100",
            "seo_keywords" => "bail|required|max:1000",
            "seo_description" => "bail|required|max:1000",
            "seo_url" => "bail|required",
        ]);

        if ($request->hasFile('seo_og_image_url')) {
            $request->validate(["seo_og_image_url" => "image|mimes:jpeg,png,jpg|max:2048"]);
        }

        $record->seo_title = $request->seo_title;
        $record->seo_keywords = $request->seo_keywords;
        $record->seo_description = $request->seo_description;
        $record->seo_url = $request->seo_url;
        $record->seo_author = $request->seo_author;
        $record->seo_og_title = $request->seo_og_title;
        $record->seo_og_site_name = $request->seo_og_site_name;
        $record->seo_og_description = $request->seo_og_description;
        $record->seo_og_url = $request->seo_og_url;
        $record->seo_og_type = $request->seo_og_type;
        $record->save();

        $image_name = "";

        if ($request->hasFile('seo_og_image_url')) {
            $image = $request->file('seo_og_image_url');
            $image_name = time() . '_' . rand(0, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path("/uploads/seo_manager/" . $slug);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $image_name);
            if (!empty($record->seo_og_image_url)) {
                unlink($destinationPath . "/" . $record->seo_og_image_url);
            }
        }
        if (!empty($image_name)) {
            $record->seo_og_image_url = $image_name;
            $record->update();
        }

        flash('success', 'record_updated_successfully', 'success');
        return redirect(URL_SEO_MANAGER);
    }

    public function isValidRecord($record) {
        if ($record === null) {

            flash('Ooops...!', getPhrase("page_not_found"), 'error');
            return $this->getRedirectUrl();
        }

        return FALSE;
    }

}

STEP 2: Create SeoManager Model

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoManager extends Model {

    protected $primaryKey = 'seo_id';
    protected $table = 'seo_manager';

    const CREATED_AT = "seo_created_at";
    const UPDATED_AT = "seo_updated_at";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    protected $guarded = [];

}

#STEP 3: Create View in views/seo_managers/add-edit.blade.php

@extends('layouts.admin.adminlayout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="/"><i class="mdi mdi-home"></i></a> </li>
                    <li><a href="{{URL_SEO_MANAGERS}}">Seo Manager</a></li>
                    <li class="active">{{isset($title) ? $title : ''}}</li>
                </ol>
            </div>
        </div>
        @include('errors.errors')
        <!-- /.row -->

        <div class="panel panel-custom col-lg-8 col-lg-offset-2">
            <div class="panel-heading">
                <div class="pull-right messages-buttons">
                    <a href="{{url()->previous()}}" class="btn  btn-primary button" >{{ getPhrase('back')}}</a>
                </div>

                <h1>{{ $title}}  </h1>
            </div>
            <div class="panel-body">
                {{ Form::model($record, array('url' => URL_SEO_MANAGERS_EDIT.$record->seo_id, 'method'=>'patch', 'name'=>'formQuiz', 'novalidate'=>'', 'files' => true)) }}
                <fieldset class="form-group col-md-12">
                    <label for="seo_title">Seo Title</label>
                    <input class="form-control" placeholder="Enter title" name="seo_title" id="seo_title" type="text" value="{{$record->seo_title}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_keywords">Seo Keywords</label>
                    <textarea class="form-control" placeholder="Enter comma separated keywords" name="seo_keywords" id="seo_keywords" rows="3" style="resize: none;">{{$record->seo_keywords}}</textarea>
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_description">Seo Description</label>
                    <textarea class="form-control" placeholder="Enter description" name="seo_description" id="seo_description" rows="3" style="resize: none;">{{$record->seo_description}}</textarea>
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_url">Seo Url</label>
                    <input class="form-control" placeholder="Enter url" name="seo_url" id="seo_url" type="url" value="{{$record->seo_url}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_author">Seo Author</label>
                    <input class="form-control" placeholder="Enter author" name="seo_author" id="seo_author" type="text" value="{{$record->seo_author}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_title">Seo Open Graph Title</label>
                    <input class="form-control" placeholder="Enter open graph title" name="seo_og_title" id="seo_og_title" type="text" value="{{$record->seo_og_title}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_site_name">Seo Open Graph Site Name</label>
                    <input class="form-control" placeholder="Enter Open Graph Site Name" name="seo_og_site_name" id="seo_og_site_name" type="text" value="{{$record->seo_og_site_name}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_description">Seo Open Graph Description</label>
                    <textarea class="form-control" placeholder="Enter Open Graph Description" name="seo_og_description" id="seo_og_description" rows="3" style="resize: none;">{{$record->seo_og_description}}</textarea>
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_url">Seo Open Graph Url</label>
                    <input class="form-control" placeholder="Enter Open Graph Url" name="seo_og_url" id="seo_og_url" type="text" value="{{$record->seo_og_url}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_type">Seo Open Graph Site Type</label>
                    <input class="form-control" placeholder="Enter Open Graph Site Type" name="seo_og_type" id="seo_og_type" type="text" value="{{$record->seo_og_type}}">
                </fieldset>
                <fieldset class="form-group col-md-12">
                    <label for="seo_og_image_url">Seo Open Graph Image</label>
                    <input class="form-control" placeholder="Select image" name="seo_og_image_url" id="seo_og_image_url" type="file">
                </fieldset>

                @if($record->seo_og_image_url!='')
                <fieldset class="form-group col-md-12">
                    <img src="{{ IMAGE_PATH_SEO_MANAGER }}{{$record->seo_id}}/{{$record->seo_og_image_url}}" class="img-responsive" width="100"/>
                </fieldset>
                @endif

                <div class="buttons text-center">
                    <button class="btn btn-lg btn-success button">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@stop

@section('footer_scripts')
@stop

#STEP 4: Add below Routes in web.php

//SeoManager Module
Route::get('seo_manager', 'SeoManagerController@index');
Route::patch('seo_manager/edit/{slug}', 'SeoManagerController@update');

#STEP 5: Set Meta in your Head

@php
$meta = App\SeoManager::find(1);
@endphp
@if(!empty($meta))
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="keywords" content="{{$meta->seo_keywords}}"/>
<meta name="description" content="{{$meta->seo_description}}"/>
<meta name="title" content="{{$meta->seo_title}}"/>
<meta name="url" content="{{$meta->seo_url}}"/>
<meta name="author" content="{{$meta->seo_author}}"/>
<meta property="og:type" content="{{$meta->seo_og_type}}"/>
<meta property="og:title" content="{{$meta->seo_og_title}}"/>
<meta property="og:description" content="{{$meta->seo_og_description}}"/>
<meta property="og:image" content="{{ IMAGE_PATH_SEO_MANAGER }}{{$meta->seo_id}}/{{$meta->seo_og_image_url}}"/>
<meta property="og:url" content="{{$meta->seo_og_url}}"/>
<meta property="og:locale" content="en_US"/>
<meta property="og:site_name" content="{{$meta->seo_og_site_name}}"/>
@endif
