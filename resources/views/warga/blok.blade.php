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
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
                            <p>This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal,
                                we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating
                                the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed.
                            </p>
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
