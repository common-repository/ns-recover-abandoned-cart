<?php
/*Display notice in wp admin top section*/
function ns_rac_error_wc_version_notice() {
    if(get_transient( 'ns-rac-wc-admin-notice' )){
    ?>
        <div class="error notice">
            <p>NS Recover Abandoned Cart plugin needs <b>Woocommerce 3.0</b> or later versions to work!</p>
        </div>
    <?php
    }
    //delete_transient( 'fx-admin-notice-example' );
}
add_action( 'admin_notices', 'ns_rac_error_wc_version_notice' );
?>