<!-- <form action="{{ route('company.update', $company->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Company Name</label>
        <input type="text" name="name" class="form-control" value="{{ $company->name }}">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $company->email }}">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form> -->

<form class="tablelist-form" autocomplete="off" action="{{ route('company.update', $company->id) }}" method="POST">
@csrf
@method('PUT')
    <div class="modal-body">
        <input type="hidden" id="id-field" />
        <div class="row g-3">
            <div class="col-lg-12">
                <div>
                    <label for="parent-company-field" class="form-label">Parent Company</label>
                    <select name="parent_id" id="parent-company-field" class="form-select">
                        <option value="">Select parent company</option>
                        @foreach($parentCompanies as $parent)
                            <option value="{{ $parent->id }}" {{ $parent->id == $company->parent_id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-lg-12">
                <div>
                    <label for="company_name-field" class="form-label">Company Name</label>
                    <input name="name" type="text" id="company_name-field" class="form-control"
                        placeholder="Enter company name" value="{{ $company->name }}" required />
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="edit-btn">Update</button>
        </div>
    </div>
</form>