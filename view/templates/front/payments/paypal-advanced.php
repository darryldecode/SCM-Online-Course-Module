<!-- pay pal advanced payment form -->
<div id="payPalAdvanceForm">

    <?php

    // set params
    $ENDPOINTURL    = trim($scmData['data']['ENDPOINTURL']);
    $MODE           = trim($scmData['data']['MODE']);
    $SECURETOKENID  = trim($scmData['data']['SECURETOKENID']);
    $SECURETOKEN    = trim($scmData['data']['SECURETOKEN']);
    $USERID         = trim($scmData['data']['USERID']);
    $COURSEID       = trim($scmData['data']['COURSEID']);
    $INVOICEID      = trim($scmData['data']['INVOICEID']);

    // build url
    $scmSRC = $ENDPOINTURL;
    $scmSRC .= "?mode={$MODE}";
    $scmSRC .= "&SECURETOKENID={$SECURETOKENID}";
    $scmSRC .= "&SECURETOKEN={$SECURETOKEN}";
    $scmSRC .= "&USER1={$USERID}";
    $scmSRC .= "&USER2={$COURSEID}";
    $scmSRC .= "&USER3={$INVOICEID}";

    ?>

    <div class="panel">
        <table class="table">
            <tr>
                <td colspan="2">
                    <b>Order/Payment Info:</b>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>PMP®/CAPM® Cert Exam Prep Class</b>
                </td>
            </tr>
            <tr>
                <td>Course Name:</td>
                <td><?php echo $scmData['courseData']['name']; ?></td>
            </tr>
            <tr>
                <td>Fee:</td>
                <td><span class="label label-info">$<?php echo $scmData['courseData']['fee']; ?></span></td>
            </tr>
        </table>
    </div>

    <iframe src="<?php echo $scmSRC; ?>" name="paypal_frame" scrolling="no" width="570px" height="540px">
    </iframe>

</div>