@extends('dashboard.base')
@section('css')
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <style>
    #editor {
      height: 350px;
    }
    #toolbar-container{
      text-align: left !important;
    }
  </style>
@endsection
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('master.create') }}</div>
                    <div class="card-body">
                        <form method="POST" id="create" action="{{ route('posts.update', $post->id) }}"  enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group row">
                                <label>{{__("master.title")}}</label>
                                <input class="form-control" type="text" placeholder="{{ __('master.title') }}" 
                                name="title" required autofocus value="{{$post->title}}">
                            </div>

                            <div class="standalone-container">
                                <input name="body" type="hidden">
                                <label>{{__("master.content")}}</label>
                                <div id="toolbar-container">
                                  <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                  </span>
                                  <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                    <button class="ql-formula"></button>
                                  </span>
                                  <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                  </span>
                                </div>
                                <div id="editor">
                                  {{old("body")}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label>{{__("master.image")}}</label>
                                <img src="{{asset('storage/'.$post->image)}}">
                                <input type="file" value="" class="form-control" name="image"/>
                            </div>
                            <button class="btn btn-block btn-success" type="submit">{{ __('master.edit') }}</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-block btn-primary">{{ __('master.return') }}</a> 
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')
  <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <script>
    var quill = new Quill('#editor', {
      modules: {
        'history': {          // Enable with custom configurations
          'delay': 2500,
          'userOnly': true
        },
        toolbar: '#toolbar-container'
      },
      theme: 'snow'
    });
    
    quill.format('direction', 'rtl');
    quill.format('align', 'right');
    quill.clipboard.dangerouslyPasteHTML(`{!! $post->body !!}`);
    {{-- quill.setContents({!! $post->body !!}); --}}
    var form = document.getElementById('create');
    form.onsubmit = function() {
      // Populate hidden form on submit
      var about = document.querySelector('input[name=body]');
      about.value = quill.root.innerHTML;
      // No back end to actually submit to!
      // alert('Open the console to see the submit data!')
      // return false;
};
  </script>
  
@endsection