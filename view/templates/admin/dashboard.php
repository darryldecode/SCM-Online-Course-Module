<h3><span class="glyphicon glyphicon-dashboard"></span> DASHBOARD</h3>

<div class="scm-dashboard">

    <?php if($scmData['payment']['total_unconfirmed'] > 0): ?>
        <div class="alert alert-info">
            <span class="glyphicon glyphicon-exclamation-sign"></span> You have <span class="badge"><?php echo $scmData['payment']['total_unconfirmed']; ?></span> awaiting payment confirmations.
        </div>
    <?php endif; ?>

    <table class="table">
        <tr>
            <td colspan="2">
                <b>PAYMENTS</b>
            </td>
        </tr>
        <tr>
            <td>Total Payments Received:</td>
            <td><span class="badge"><?php echo $scmData['payment']['total_count']; ?></span></td>
        </tr>
        <tr>
            <td>Number of un-confirmed payments:</td>
            <td><span class="badge"><?php echo $scmData['payment']['total_unconfirmed']; ?></span></td>
        </tr>
        <tr>
            <td>Number of confirmed payments:</td>
            <td><span class="badge"><?php echo $scmData['payment']['total_confirmed']; ?></span></td>
        </tr>
        <tr>
            <td>Over all total sales:</td>
            <td><span class="label label-success">$<?php echo $scmData['totalSales']; ?></span></td>
        </tr>
        <tr>
            <td colspan="2">
                <b><span class="glyphicon glyphicon-book"></span> COURSES</b>
            </td>
        </tr>
        <tr>
            <td>Over all number of courses:</td>
            <td><span class="badge"><?php echo $scmData['course']['total_courses']; ?></span></td>
        </tr>
        <tr>
            <td colspan="2">
                <b><span class="glyphicon glyphicon-user"></span> STUDENTS</b>
            </td>
        </tr>
        <tr>
            <td>Over all number of students:</td>
            <td><span class="badge"><?php echo $scmData['student']['total_students']; ?></span></td>
        </tr>
    </table>
</div>