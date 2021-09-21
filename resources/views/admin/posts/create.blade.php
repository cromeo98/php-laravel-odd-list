@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>

                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>                  
                @endforeach

            </ul>
        </div>
    @endif
    <div></div>
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.posts.store')}}" method="post">
                @csrf
                <h3 class="my-3">Inserimento nuovo Post</h3>
                <div class="card-title">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" name="title" class="form-control
                  @error('title')
                    is-invalid
                  @enderror
                  " id="title" value="{{old('title')}}">
                </div>
                @error('title')
                <div class="alert alert-danger">{{$error}}</div> {{--or {{$message}} --}}
                @enderror
                <div class="card-text">
                  <label for="content" class="form-label">Content</label>
                  <textarea name="content" class="form-control
                  @error('content')
                    is-invalid
                  @enderror
                  " id="content" placeholder="Inserisci il contenuto del post">{{old('content')}}</textarea>
                </div>
                @error('title')
                <div class="alert alert-danger">{{$error}}</div> {{--or {{$message}} --}}
                @enderror
                <div class="card-text">
                    <label for="category" class="form-label pt-2">Category</label>
                    <select name="category_id" id="category" class="form-control">
                        <option value="">-- Seleziona una categoria --</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{-- necessario l'id nel value perchè è il dato da passare al db --}}
                                @if ($category->id == old('category_id'))
                                    selected
                                @endif>
                                {{$category->name}}
                            </option>    
                        @endforeach
                    </select>
                </div>
                <div class="card-text">
                    <h4 class="form-label pt-2">Tags</h4>
                    @foreach ($tags as $tag)
                    <div class="form-check d-inline-block">
                        <input name="tags[]" class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag{{$loop->iteration}}" {{-- il loop->iteration aggiunge il valore (numerico) della nostra posizione all'interno del loop del foreach--}}
                        @if (in_array($tag->id, old('tags', [])))
                            checked
                        @endif
                        >
                        <label class="form-check-label" for="tag{{$loop->iteration}}">
                          {{$tag->name}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="py-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('admin.posts.index')}}" class="btn btn-warning">Torna indietro</a>
                </div>
            </form>
        </div>
    </div>
@endsection