<?php $__env->startSection('main'); ?>


<?php
$activenews = App\Models\NewsPost::where('status',1)->get();
$inactivenews = App\Models\NewsPost::where('status',0)->get();
$breakingnews = App\Models\NewsPost::where('breaking_news',1)->get();
?>

<div class="content">

  <!-- Start Content-->
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <?php if(Auth::user()->can('news.add')): ?> 
                <a href="<?php echo e(route('add.news.post')); ?>" class="btn btn-blue waves-effect waves-light">Add News Post</a>
              <?php else: ?>
                  <a href="#" class="btn btn-blue waves-effect waves-light" onclick="alert('You Have No Permission, Contact Admin!')">Add News Post</a>
              <?php endif; ?>
            </ol>
          </div>

        </div>
      </div>
    </div>
    <!-- end page title -->

    <br>

    <div class="row">
      <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="avatar-lg rounded-circle bg-primary border-primary border shadow">
                  <i class="fe-heart font-22 avatar-title text-white"></i>
                </div>
              </div>
              <div class="col-6">
                <div class="text-end">
                  <h3 class="text-dark mt-1"> <span data-plugin="counterup"><?php echo e(count($allnews)); ?></span></h3>
                  <p class="text-muted mb-1 text-truncate">All News Post</p>
                </div>
              </div>
            </div> <!-- end row-->
          </div>
        </div> <!-- end widget-rounded-circle-->
      </div> <!-- end col-->

      <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                  <i class="fe-thumbs-up font-22 avatar-title text-white"></i>
                </div>
              </div>
              <div class="col-6">
                <div class="text-end">
                  <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e(count($activenews)); ?></span></h3>
                  <p class="text-muted mb-1 text-truncate">Active News</p>
                </div>
              </div>
            </div> <!-- end row-->
          </div>
        </div> <!-- end widget-rounded-circle-->
      </div> <!-- end col-->

      <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="avatar-lg rounded-circle bg-info border-info border shadow">
                  <i class="fe-thumbs-down font-22 avatar-title text-white"></i>
                </div>
              </div>
              <div class="col-6">
                <div class="text-end">
                  <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e(count($inactivenews)); ?></span> </h3>
                  <p class="text-muted mb-1 text-truncate">InActive News</p>
                </div>
              </div>
            </div> <!-- end row-->
          </div>
        </div> <!-- end widget-rounded-circle-->
      </div> <!-- end col-->

      <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="avatar-lg rounded-circle bg-warning border-warning border shadow">
                  <i class="fe-eye font-22 avatar-title text-white"></i>
                </div>
              </div>
              <div class="col-6">
                <div class="text-end">
                  <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e(count($breakingnews)); ?></span> </h3>
                  <p class="text-muted mb-1 text-truncate">Breaking News</p>
                </div>
              </div>
            </div> <!-- end row-->
          </div>
        </div> <!-- end widget-rounded-circle-->
      </div> <!-- end col-->
    </div>
    <!-- end row-->







    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">


            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Image </th>
                  <th>Title </th>
                  <th>Category </th>
                  <th>User </th>
                  <th>Date </th>
                  <th>Status </th>
                  <th>Action </th>
                </tr>
              </thead>


              <tbody>
                <?php $__currentLoopData = $allnews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($key+1); ?></td>
                  <td><img src="<?php echo e(asset($item->image)); ?> " style="width: :50px; height:50px;"></td>
                  <td><?php echo e(Str::limit($item->news_title,20)); ?></td>
                  <td><?php echo e($item['category']['category_name']); ?></td>
                  <td><?php echo e($item['user']['name']); ?></td>
                  <td><?php echo e(Carbon\Carbon::parse($item->post_date)->diffForHumans()); ?></td>
                  <td>
                    <?php if($item->status == 1): ?>
                    <span class="badge badge-pill bg-success">Active</span>

                    <?php else: ?>
                    <span class="badge badge-pill bg-danger">InActive</span>
                    <?php endif; ?>


                  </td>
                  <td>
                    <?php if(Auth::user()->can('news.edit')): ?> 
                      <a href="<?php echo e(route('edit.news.post',$item->id)); ?>" class="btn btn-primary rounded-pill waves-effect waves-light">Edit</a>
                    <?php else: ?>
                        <a href="#" class="btn btn-primary  rounded-pill waves-effect waves-light" onclick="alert('You Have No Permission, Contact Admin!')">Edit</a>
                    <?php endif; ?>

                    <?php if(Auth::user()->can('news.delete')): ?> 
                      <a href="<?php echo e(route('delete.news.post',$item->id)); ?>" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>
                      <?php if($item->status == 1): ?>
                        <a href="<?php echo e(route('inactive.news.post',$item->id)); ?>" class="btn btn-primary rounded-pill waves-effect waves-light" title="Inactive"><i class="fa-solid fa-thumbs-down"></i> </a>
                      <?php else: ?>
                        <a href="<?php echo e(route('active.news.post',$item->id)); ?>" class="btn btn-primary rounded-pill waves-effect waves-light" title="Active"><i class="fa-solid fa-thumbs-up"></i></a>
                      <?php endif; ?>
                    <?php else: ?>
                        <a href="#" class="btn btn-danger  rounded-pill waves-effect waves-light" onclick="alert('You Have No Permission, Contact Admin!')">Delete</a>
                    <?php endif; ?>

                    

                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </tbody>
            </table>

          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->
    </div>
    <!-- end row-->
  </div> <!-- container -->
</div> <!-- content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/clients/client3/web3/private/udemy/Laravel9A-ZForBeginnerWithCompleteNewsPortalWebsite/news/app/resources/views/backend/news/all_news_post.blade.php ENDPATH**/ ?>