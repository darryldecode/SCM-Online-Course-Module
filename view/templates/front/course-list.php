<h1>COURSE LISTINGS</h1>

<!-- course list repeater -->
<ul class="list-group">

    <li class="list-group-item active">
        <div class="row">

            <div class="col-lg-4">
                <b>COURSE NAME:</b>
            </div>

            <div class="col-lg-6">
                <b>LOCATION:</b>
            </div>

            <div class="col-lg-1">

            </div>

        </div>
    </li>

    <?php foreach($scmData['data'] as $course): ?>
        <li class="list-group-item">
            <div class="row">

                <div class="col-lg-4">
                    <?php echo $course['name']; ?>
                </div>

                <div class="col-lg-6">
                    <?php echo $course['location']; ?>
                </div>

                <div class="col-lg-1">
                    <a href="?page=scmCourseModule&state=Front&action=viewCourse&courseID=<?php echo $course['id']; ?>" class="btn btn-sm btn-info">
                        <span class="glyphicon glyphicon-eye-open"></span> View Course
                    </a>
                </div>

            </div>
        </li>
    <?php endforeach; ?>

    <?php if(count($scmData['data'])==0): ?>
        <li class="list-group-item">
            <div class="well well-lg text-center">
                No Course/Classes yet..
            </div>
        </li>
    <?php endif; ?>

</ul>