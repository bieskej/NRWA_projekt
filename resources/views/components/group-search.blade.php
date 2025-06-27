<form action="{{ url('/api/groups/search') }}" method="POST" class="w-100">
    {{-- @csrf token NIJE potreban za API rute --}}
    <div class="input-group">
        <input type="text" class="form-control"
               placeholder="Group name"
               name="query"
        >
        <div class="input-group-append">
            <button class="btn btn-outline-success">
                Search
            </button>
        </div>
    </div>
</form>