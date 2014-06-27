<div id="scmAadminPaymentsLists" class="clearfix">
    <table class="table table-bordered table-striped">
        <tr>
            <td colspan="3">
                <b><span class="glyphicon glyphicon-time"></span> Payment History</b>

                <a href="?page=scmCourseModule&state=Front&action=myAccount" class="btn btn-xs btn-default pull-right">
                    <span class="glyphicon glyphicon-arrow-left"></span> Back to My Account
                </a>
            </td>
        </tr>
        <tr>
            <td>Payment For:</td>
            <td>Status:</td>
            <td>InvoiceID:</td>
        </tr>
        <?php foreach($scmData['userPayments'] as $payment): ?>
            <tr>
                <td><?php echo $payment['course']['name']; ?></td>
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
            </tr>
        <?php endforeach; ?>

        <?php if(count($scmData['userPayments'])==0): ?>
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