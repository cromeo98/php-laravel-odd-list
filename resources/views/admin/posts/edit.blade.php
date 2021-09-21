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
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.posts.update', $post->id)}}" method="post">
                @csrf
                @method('PUT')
                <h3 class="my-3">Aggiornamento Post</h3>
                <div class="card-title">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" name="title" class="form-control
                  @error('title')
                  is-invalid
                  @enderror
                  " id="title" value="{{old('title', $post->title)}}">
                  @error('title')
                  <div class="alert alert-danger">{{$error}}</div> {{--or {{$message}} --}}
                  @enderror
                </div>
                <div class="card-text">
                  <label for="content" class="form-label">Content</label>
                  <textarea name="content" class="form-control
                  @error('content')
                  is-invalid
                  @enderror
                  " id="content" placeholder="Inserisci il contenuto del post">{{old('content', $post->content)}}</textarea>
                </div>
                <div class="card-text">
                    <label for="category" class="form-label pt-2">Category</label>
                    <select name="category_id" id="category" class="form-control">
                        <option value="">-- Seleziona una categoria --</option>

                        {{-- Passo le categorie con il foreach
                        Se l'id attualmente selezionato nel value è uguale a quello selezionato prima (old('category_id')) oppure a quello presente nella tabella nel db ($post->category_id) mi scrivi selected --}}
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{-- necessario l'id nel value perchè è il dato da passare al db --}}
                                @if ($category->id == old('category_id', $post->category_id))
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
                        {{--Se non ci sono errori e la tabella ponte(quindi il db) contiene il $tag->id corrispondente, mi segni checked (ovviamente essendo in unforeach il checked sarà solamente sulle checkbox con l'id corrispondente altrimenti non mi segni checked)--}}
                        @if(!$errors->any() && $post->tags->contains($tag->id))
                            checked
                        {{--se invece non si verifica quanto sopra e all'interno dell'array che ho passato è presente il tag->id mi riporti quanto segnato in precedenza--}}
                        @elseif(in_array($tag->id, old('tags', [])))
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