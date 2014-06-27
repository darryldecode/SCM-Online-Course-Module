<div class="clearfix text-right button-wide-holder">
    <a href="?page=scmCourseModule&state=Course&action=create" class="btn btn-success">
        <span class="glyphicon glyphicon-plus-sign"></span> New Course
    </a>
</div>

<div>
    <table class="table table-bordered">
        <tr>
            <th class="course-name">COURSE NAME</th>
            <th class="course-description">COURSE DESCRIPTION</th>
            <th class="text-center course-action">ACTION</th>
        </tr>
        <?php foreach($scmData['data'] as $course):?>
            <tr>
                <td><?php echo $course['name']; ?></td>
                <td><?php echo $course['description']; ?></td>
                <td class="text-center">
                    <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Course&action=delete'); ?>">
                        <div class="btn-group btn-group-sm">
                            <a href="?page=scmCourseModule&state=Course&action=show&courseID=<?php echo $course['id']; ?>" type="button" class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span> view</a>
                            <a href="?page=scmCourseModule&state=Course&action=edit&courseID=<?php echo $course['id']; ?>" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> edit</a>
                            <button type="submit" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                        </div>
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                    <input type="hidden" name="courseID" value="<?php echo $course['id']; ?>">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if(count($scmData['data'])==0): ?>
            <tr>
                <td colspan="3">
                    <div class="well well-lg text-center">
                        No Course/Classes yet..
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>