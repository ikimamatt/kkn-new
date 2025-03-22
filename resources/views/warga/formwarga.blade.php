@extends('layouts.vertical', ['title' => 'Tambah Data Warga'])

@section('content')

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Form Validation</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
            <li class="breadcrumb-item active">Form Validation</li>
        </ol>
    </div>
</div>

<!-- Form Validation -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Data Warga</h5>
            </div><!-- end card header -->

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">Scrollable modal</button>
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
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@endsection
