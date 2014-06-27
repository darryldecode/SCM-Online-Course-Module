<?php

/**
 * Email Template for welcome email
 *
 * @version 1.0
 * @package SCM-Module
 * @author Darryl Decode
 */

?>
<div style="width: 100%; max-width: 100%; padding: 5px; border-radius: 5px; border: 1px solid #808080">
    <table>
        <tr>
            <td colspan="2" style="text-align: center;"><?php $scmData['fromName']; ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $scmData['message']; ?></td>
        </tr>
        <tr>
            <td>Login Link:</td>
            <td><?php echo $scmData['loginUrl']; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $scmData['email']; ?></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><?php echo $scmData['password']; ?></td>
        </tr>
    </table>
</div>