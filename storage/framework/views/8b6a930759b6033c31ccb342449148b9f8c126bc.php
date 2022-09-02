

<?php $__env->startSection('title', __('labels.backend.reports.students_report').' | '.app_name()); ?>

<?php $__env->startPush('after-styles'); ?>
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            text-align: left;
            margin-left: 25%;
        }

        div.dt-buttons {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        .plot-container.plotly .modebar-container{
            display: none !important;
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
   <?php //dd($testreport);  ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Test Report</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th>Title</th>
                                <th>Report</th>
                                
                            </tr>
                            <?php $i = 0; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $testreport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(++$i); ?></td>
                                    <td><?php echo e($report->title); ?></td>
                                    <?php
                                        $current_content = json_decode($report->content);
                                        //$current_content = json_decode($report->origin_content);
                                    ?>
                                    <td><?php echo $current_content; ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td>Sorry! No Record Found</td></tr>
                            <?php endif; ?>
                            
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp7.4.2\htdocs\laravel\resources\views/backend/reports/student_report.blade.php ENDPATH**/ ?>