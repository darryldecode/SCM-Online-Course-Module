<div id="scmAadminPaymentsLists" class="clearfix">
    <table class="table table-bordered table-striped">
        <tr>
            <td>Payment For:</td>
            <td>Payment By:</td>
            <td>Status:</td>
            <td>InvoiceID:</td>
            <td>Method:</td>
            <td class="text-center">Action</td>
        </tr>
        <?php foreach($scmData['payments'] as $payment): ?>
            <tr>
                <td><?php echo $payment['course']['name']; ?></td>
                <td><?php echo $payment['student']['first_name'].' '.$payment['student']['middle_name'].' '.$payment['student']['last_name']; ?></td>
                <td>
                    <?php if($payment['paid'] == 0): ?>
                        <span class="label label-warning">
                            <span class="glyphicon glyphicon-time"></span> Waiting For Confirmation
                        </span>
                    <?php else: ?>
                        <span class="label label-primary">
                            <span class="glyphicon glyphicon-thumbs-up"></span> Confirmed
                        </span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $payment['invoice_id']; ?>
                </td>
                <td>
                    <?php foreach($payment['data'] as $paymentData): ?>
                        <?php if($paymentData['key']=='METHOD'): ?>
                            <?php if($paymentData['value']=='CC'): ?>
                                Credit Card
                            <?php else: ?>
                                PayPal
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
                <td class="text-center">
                    <?php if($payment['paid'] == 0): ?>
                        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Payment&action=setPaid'); ?>">
                            <button class="btn btn-xs btn-info">Set as confirmed</button>
                            <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                            <input type="hidden" name="paymentID" value="<?php echo $payment['id']; ?>">
                        </form>
                    <?php else: ?>
                        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Payment&action=setUnPaid'); ?>">
                            <button class="btn btn-xs btn-info">Set to un-confirm</button>
                            <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                            <input type="hidden" name="paymentID" value="<?php echo $payment['id']; ?>">
                        </form>
                    <?php endif; ?>
                    <div class="text-center">
                        <a href="?page=scmCourseModule&state=Payment&action=show&paymentID=<?php echo $payment['id']; ?>">
                            <span class="glyphicon glyphicon-search"></span> More Info
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if(count($scmData['payments'])==0): ?>
            <tr>
                <td colspan="6">
                    <div class="well well-lg text-center">
                        No Payments yet..
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>