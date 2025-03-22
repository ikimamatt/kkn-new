@extends('layouts.vertical', ['title' => 'Basic Tables'])

@section('css')
    @vite([
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
        'node_modules/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css',
        'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'
     ])
@endsection

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Data Tables</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
            <li class="breadcrumb-item active">Data Tables</li>
        </ol>
    </div>
</div>

<!-- Fixed Header Datatable -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Fixed Header DataTable</h5>
            </div>

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">Scrollable modal</button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalScrollableTitle">Scrollable Modal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3">
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault02" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="validationDefault02" value="Otto" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefaultUsername" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                        <input type="text" class="form-control" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault03" class="form-label">City</label>
                                    <input type="text" class="form-control" id="validationDefault03" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault04" class="form-label">State</label>
                                    <select class="form-select" id="validationDefault04" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option>City 1</option>
                                        <option>City 2</option>
                                        <option>City 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault05" class="form-label">Zip</label>
                                    <input type="text" class="form-control" id="validationDefault05" required>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                                        <label class="form-check-label" for="invalidCheck2">
                                            Agree to terms and conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal --}}

            <div class="card-body">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>Emma Young</td>
                            <td>Product Owner</td>
                            <td>Denver</td>
                            <td>29</td>
                            <td>2022-11-30</td>
                            <td>$120,000</td>
                        </tr>
                        <tr>
                            <td>Aiden Evans</td>
                            <td>Business Consultant</td>
                            <td>Seattle</td>
                            <td>32</td>
                            <td>2023-04-05</td>
                            <td>$100,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @vite([ 'resources/js/pages/datatable.init.js'])
@endsection
