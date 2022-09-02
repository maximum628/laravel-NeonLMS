<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('Charts & Tables').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Charts & Tables</h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_create')): ?>
                <div class="float-right">
                   <a id="order_change" 
                       class="btn btn-primary" style="color:white">Order change</a>
                    <a href="<?php echo e(route('admin.charts.create')); ?>"
                       class="btn btn-success">Add New</a>

                </div>
            <?php endif; ?>
        </div>
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::select('test_id', $tests,  (request('test_id')) ? request('test_id') : old('test_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'test_id']); ?>

                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.charts.index')); ?>"
                                                    style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                    </li>
                    |
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.charts.index')); ?>?show_deleted=1"
                                                    style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                    </li>
                </ul>
            </div>
            <table id="myTable"
                   class="table table-bordered table-striped <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> ">
                <thead>
                <tr>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_delete')): ?>
                        <?php if( request('show_deleted') != 1 ): ?>
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th><?php endif; ?>
                    <?php endif; ?>
                        <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                        <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                        <th>Title</th>
                  
                        <th>Type</th>
                        <th>Short Code</th>
                        <?php if( request('show_deleted') == 1 ): ?>
                        <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php else: ?>
                        <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php endif; ?>
                        
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
  

<script>

        jQuery(document).ready(function (e) {
           // QuestionEdit.init();
          //    $(function() {
          //      $('#sortable-20').sortable({
          //          update: function(event, ui) {
          //          }
          //      });
          //  });

            $("#order_change").on('click',function(e){
                var order_info=[], id_info=[];
                for (var i=1;i<=$("#sortable-20").children().length;i++)
                {
                
                    id_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                    order_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(1)").text();// order value
                } 

                e.preventDefault();
                    $.ajax({
                        data: { "id_info":JSON.stringify(id_info)},
                        url: 'questions/order-edit',
                        type: 'get',
                        dataType: 'json',
                        complete: function(response){     
                            alert("The order is updated successfully.");
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });    
            });


            var route = '<?php echo e(route('admin.charts.get_data')); ?>';

            <?php if(request('show_deleted') == 1): ?>
                route = '<?php echo e(route('admin.charts.get_data',['show_deleted' => 1])); ?>';
            <?php endif; ?>

            <?php if(request('test_id') != ""): ?>
                route = '<?php echo e(route('admin.charts.get_data',['test_id' => request('test_id')])); ?>';
            <?php endif; ?>

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        <?php if(request('show_deleted') != 1): ?>
                    { "data": function(data){
                        return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                    }, "orderable": false, "searchable":false, "name":"id" },
                        <?php endif; ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "title", name: 'title'},
                    {data: "type", name: 'type'},     
                    {data: "short_code", name: 'short_code'},                     
                    {data: "actions", name: "actions"},
                  
                ],
                <?php if(request('show_deleted') != 1): ?>
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                <?php endif; ?>

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo e($locale_full_name); ?>.json",
                    buttons :{
                        colvis : '<?php echo e(trans("datatable.colvis")); ?>',
                        pdf : '<?php echo e(trans("datatable.pdf")); ?>',
                        csv : '<?php echo e(trans("datatable.csv")); ?>',
                    }
                }
            });

            $(document).on('change', '#test_id', function (e) {
                var course_id = $(this).val();
                window.location.href = "<?php echo e(route('admin.charts.index')); ?>" + "?test_id=" + course_id;
            });
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_delete')): ?>
            <?php if(request('show_deleted') != 1): ?>
            $('.actions').html('<a href="' + '<?php echo e(route('admin.charts.mass_destroy')); ?>' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            <?php endif; ?>
            <?php endif; ?>



        });





    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp7.4.2\htdocs\laravel\resources\views/backend/charts/index.blade.php ENDPATH**/ ?>