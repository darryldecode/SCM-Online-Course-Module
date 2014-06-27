<?php

/**
 * Email Template for admin notifications
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
    </table>
</div>