<link rel="stylesheet"
          href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding: 25px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        .date {
            min-width: 75px;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }
    </style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <br>
            <div class="list-group">
                <?php if(empty($files)): ?>
                    <a class="list-group-item liv-active">No Log Files Found</a>
                <?php else: ?>
                    <?php foreach($files as $file): ?>
                        <a href="?f=<?php echo base64_encode($file); ?>"
                           class="list-group-item <?php echo ($currentFile == $file) ? "llv-active" : "" ?>">
                            <?php echo $file; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-9 col-md-10 table-container">
            <?php if(is_null($logs)): ?>
                <div>
                    <br><br>
                    <strong>Log file > 50MB, please download it.</strong>
                    <br><br>
                </div>
            <?php else: ?>
                <table id="table-log" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Level</th>
                        <th>Date</th>
                        <th>Content</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($logs as $key => $log): ?>
                        <tr data-display="stack<?php echo $key; ?>">

                            <td class="text-<?php echo $log['class']; ?>">
                                <span class="<?php echo $log['icon']; ?>" aria-hidden="true"></span>
                                &nbsp;<?php echo $log['level']; ?>
                            </td>
                            <td class="date"><?php echo $log['date']; ?></td>
                            <td class="text">
                                <?php if (array_key_exists("extra", $log)): ?>
                                    <a class="pull-right expand btn btn-default btn-xs"
                                       data-display="stack<?php echo $key; ?>">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </a>
                                <?php endif; ?>
                                <?php echo $log['content']; ?>
                                <?php if (array_key_exists("extra", $log)): ?>
                                    <div class="stack" id="stack<?php echo $key; ?>"
                                         style="display: none; white-space: pre-wrap;">
                                        <?php echo $log['extra'] ?>
                                    </div>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <div>
                <?php if($currentFile): ?>
                    <a href="?dl=<?php echo base64_encode($currentFile); ?>">
                        <span class="glyphicon glyphicon-download-alt"></span>
                        Download file
                    </a>
                    -
                    <a id="delete-log" href="?del=<?php echo base64_encode($currentFile); ?>"><span
                                class="glyphicon glyphicon-trash"></span> Delete file</a>
                    <?php if(count($files) > 1): ?>
                        -
                        <a id="delete-all-log" href="?del=<?php echo base64_encode("all"); ?>"><span class="glyphicon glyphicon-trash"></span> Delete all files</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function () {

        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });

        $('#table-log').DataTable({
            "order": [],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            }
        });
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });
    });
</script>
