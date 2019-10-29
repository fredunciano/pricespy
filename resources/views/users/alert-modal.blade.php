<div id="logOutAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@t('attention')!</h4>
            </div>
            <div class="modal-body modal-danger-body" style="min-height: 55px; height: 20px">
                <p>
                    @t('logout_alert_message')
                </p>

            </div>
            <input type="hidden" id="verificationToken">
            <div class="modal-footer modal-danger-footer">
                <hr class="hr-color">
                <button type="button" onclick="goToVerificationLink()"
                        class="btn btn-danger-custom-full pull-left"
                        style="display: inline-block">
                    @t('yes')
                </button>
                <button type="button" data-dismiss="modal"
                        class="btn btn-danger-custom pull-right"
                        style="display: inline-block">
                    @t('no')
                </button>
            </div>
        </div>

    </div>
</div>