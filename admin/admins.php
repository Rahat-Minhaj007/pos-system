<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff
                <a href="admins-create.php" class="btn btn-primary float-end">ADD ADMIN</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">
                                SI
                            </th>
                            <th class="text-center">
                                ID
                            </th>
                            <th class="text-center">
                                Name
                            </th>
                            <th class="text-center">
                                Email
                            </th>
                            <th class="text-center">
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                1
                            </td>
                            <td class="text-center">
                                487
                            </td>
                            <td class="text-center">
                                Minhajul Abedin Rahat
                            </td>
                            <td class="text-center">
                                rahat55@gmail.com
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-warning me-2">Edit</button>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>



<?php
include("includes/footer.php");
?>