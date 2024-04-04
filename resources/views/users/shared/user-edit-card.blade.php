<div class="card">
    <div class="px-3 pt-4 pb-2">
        <form enctype="multipart/form-data" method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('put')
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img style="width:150px" class="me-3 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}"
                        alt="Mario Avatar">
                    <div>

                        <input name="name" value="{{ $user->name }}" type="text" class="form-control"></input>
                        @error('name')
                            <span class="d-block mt-2 text-danger fs-6">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div style="float: right;  margin-top: -100px;">
                @auth
                    @if (Auth::id() === $user->id)
                        <a href="{{ route('users.show', $user->id) }}">View</a>
                    @endif
                @endauth
            </div>
            <div class="mt-3">
                <label for="">Profile Picture</label>
                <input name="image" class="form-control" type="file">
                @error('image')
                    <span class="fs-6 text-danger mt-4">{{ $message }}</span>
                @enderror
            </div>
            <div class="px-2 mt-4">
                <h5 class="fs-5"> Bio : </h5>

                <div class="mb-3">
                    <textarea name="bio" class="form-control" id="bio" rows="3">{{ $user->bio }}</textarea>
                    @error('bio')
                        <span class="fs-6 text-danger mt-4">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-dark btn-sm mt-3">Save</button>
               @include('users.shared.user-stats')
                @auth
                    @if (Auth::id() !== $user->id)
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm"> Follow </button>
                        </div>
                    @endif
                @endauth
            </div>
        </form>
    </div>
</div>
