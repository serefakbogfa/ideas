<h4> Share yours ideas </h4>
<div class="row">
    <form action="{{route('idea.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" id="content" rows="3"></textarea>
            @error('content')
            <span class="fs-6 text-danger mt-4">{{$message}}</span>
                
            @enderror
        </div>
        <div class="">
            <button type="submit" class="btn btn-dark"> Share </button>
        </div>
    </form>
</div>
