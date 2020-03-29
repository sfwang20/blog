@php
  $isCreate = !$category->exists;
  $actionUrl = ($isCreate)? '/categories' : '/categories/'.$category->id;
@endphp

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $key => $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<form method="post" action="{{ $actionUrl }}">
  @csrf
  @if (!$isCreate)
    <input type="hidden" name="_method" value="put">
  @endif
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name" value="{{ $category->name }}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="btn btn-default" onclick="window.history.back()">Cancel</button>
</form>
