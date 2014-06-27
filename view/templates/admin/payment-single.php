<div class="payment-single">

    <div class="clearfix text-right button-wide-holder">
        <a href="?page=scmCourseModule&state=Payment&action=index" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span> Back to Payments Lists
        </a>
    </div>

    <table class="table">
        <tr>
            <td>Payment for course:</td>
            <td>
                <a href="?page=scmCourseModule&state=Course&action=show&courseID=<?php echo $scmData['payment']['course']['id']; ?>">
                    <span class="glyphicon glyphicon-book"></span> <?php echo $scmData['payment']['course']['name']; ?>
                </a>
            </td>
        </tr>
        <tr>
            <td>Payment made by:</td>
            <td>
                <a href="?page=scmCourseModule&state=Users&action=show&studentID=<?php echo $scmData['payment']['id']; ?>">
                    <span class="glyphicon glyphicon-user"></span> <?php echo $scmData['payment']['student']['first_name'].' '.$scmData['payment']['student']['last_name']; ?>
                </a>
            </td>
        </tr>
        <tr>
            <td>Payment Method Used:</td>
            <td>
                <?php foreach($scmData['payment']['data'] as $paymentData): ?>
                    <?php if($paymentData['key']=='METHOD'): ?>
                        <?php if($paymentData['value']=='CC'): ?>
                            Credit Card
                        <?php else: ?>
                            PayPal
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td>Payment Date:</td>
            <td><?php echo $scmData['payment']['created_at']; ?></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td><?php echo ($scmData['payment']['paid']==1) ? 'Confirmed' : 'Not yet confirmed'; ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <form method="post" class="pull-right" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Payment&action=delete'); ?>">
                    <button class="btn btn-sm btn-danger">
                        <span class="glyphicon glyphicon-remove-circle"></span> Delete Payment
                    </button>
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                    <input type="hidden" name="paymentID" value="<?php echo $scmData['payment']['id']; ?>">
                </form>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-striped">
        <?php foreach($scmData['payment']['data'] as $payment): ?>
            <tr>
                <td><?php echo $payment['key']; ?>:</td>
                <td><?php echo $payment['value']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>