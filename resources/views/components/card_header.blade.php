<div class="row align-items-center mb-3">
    <div class="col-md-8">
        <h4 class="card-title">{{ $title }}
            <a href="{{ route($route) }}" class="btn btn-sm btn-info">Create</a>
        </h4>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <form action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search User"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
