@if($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@if($post->exists)
<form action="{{route('admin.posts.update', $post->id)}}" method="POST">
  @method('PUT')
  @else
  <form action="{{route('admin.posts.store')}}" method="POST">
    @endif
    @csrf
    <div class="row">
      <div class="col-8">
        <div class="form-group">
          <label for="title" class="form-label">Titolo</label>
          <input type="text" name="title" id="title" placeholder="Titolo" value="{{old('title', $post->title)}}" class="form-control @error('title') is-invalid @enderror">
          @error('title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="col-4">
        <div class="form-group">
          <label for="category">Categoria</label>
          <select class="form-control @error('category_id') is-invalid @enderror" id="category" name="category_id">
            <option value="">Nessuna categoria</option>
            @foreach($categories as $category)
            <option @if(old('category_id', $post->category_id)==$category->id) selected @endif value="{{$category->id}}">{{$category->label}}</option>
            @endforeach
          </select>
          @error('category_id')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="content" class="form-label">Testo</label>
          <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="10">{{old('content', $post->content)}}</textarea>
        </div>
        @error('image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="col-10">
        <div class="form-group">
          <label for="image" class="form-label">Inserisci url immagine:</label>
          <input type="url" name="image" class="form-control @error('image') is-invalid @enderror" id="image" placeholder="Url dell'immagine" value="{{old('image', $post->image)}}">
        </div>
        @error('image')
        <div class=" invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="col-2">
        <img src="{{ old('image', $post->image) ?? 'https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png?w=640' }}" class="img-fluid" id="preview" alt="placeholder">
      </div>
      <div class="col-12">
        <hr>
      </div>

      <div class="col-12 d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk mr-2"></i>Salva</button>
      </div>
    </div>
  </form>